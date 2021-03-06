# Simple Unit Test

Simple Unit Test is a php class to test php code. Why over http? It is highly 
probably you are developing a web application, therefore server configuration is a 
criteria to be considered.



# Introduction

Imagine you have written a program that does a simple calculation, that calculates the area
of a hexagon. You run it and it gives you the area -34.56. you just know that that's wrong. 
Why? Because no shape has a negative area. So, you fix that bug (whatever it was) and 
get 51.452673. Is that right? That's harder to say because we don't usually keep the 
formula of a hexagon in our heads. What we must do before keeping fooling ourselves
is just to check that the answer is plausible. In this case, that's easy. A hexagon
is much like a square. We scribble our regular hexagon on a piece of paper and eyeball
it to be the size of a 3-by-3 square. such a square has the area 9. Bummer, our 51.452673
can't be right! So we work over our program again and get 10.3923. Now that just might be 
right!

The general point is not about areas. The point is that unless we have some idea of 
what a correct answer will be like, we don't have a clue whether our result is reasonable.

Does a unit test help to develop better code? Not really, bad code can be tested with 
the wrong test cases and still passes the test. The bottom line is that the code 
and the test cases depend on the skills of the developer. In other words, as far as one
does not use the relevant test cases to test his program, it does not matter if he is using 
the super fancy unit test out there to do the test or the "can you hear me?" approach, 
he will still get valid data with the wrong test. 

# Content

- [Features](#features)
- [Comparisons](#comparisons)
- [Install](#install)
- [Documentation](#documentation)
- [How to use it](#how-to-use-it)
- [Examples](#examples)
- [Conclusion](#conclusion)
- [License](#license)


# Features

- No need to extend any class.
- Dummy methods.
- Spy injection.
- Custom returns.
- Set custom definition of assertion function to be used for the test.
- Ability to test private or public methods.


# Comparisons

Suppose we have a class HelloWorld

    class HelloWorld
    {
        public function sayhi(){
           return 'Hello World!';
        }
    }

Such a simple class shuld be easy to test, right?

*Using one of the most popular unit test for php*

File 1

    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit bootstrap="tests/bootstrap.php">
        <testsuites>
            <testsuite>
                <directory>./tests</directory>
            </testsuite>
        </testsuites>
        <filter>
            <whitelist>
                <directory>./src</directory>
            </whitelist>
        </filter>
    </phpunit>
	
File 2 (the bootstrap thingy)

    <?php

    if (!@include __DIR__ . '/../vendor/autoload.php') {
       require __DIR__ . '/../../../../vendor/autoload.php';
    }

    ?>

File 3 (the "test")

    <?php
    require_once('RemoteConnect.php');

    class HelloWorldTest extends PHPUnit_Framework_TestCase
    {
        public function setUp(){ }
        public function tearDown(){ }

        public function testSayHi()
        {
            $connObj = new HelloWorld();
            $this->assertTrue($connObj->sayhi() == 'Hello World');
            $this->assertTrue($connObj->sayhi('abc') == 'Hello World');
        }
    }
    ?>

*Simple Unit Test*

Just one file

    <?php
    include '../Unit_test/simple_unit_test.php';
    use SimpleUnitTest\Test;
    Test::Set_URL('url/of/for/this/test');

    function autoloader($class) {
        //some code
    }

    // Instantiate a new Test object
    $Test=new Test('HelloWorld');
    $Test->autoload('autoloader');

    //Test
    $Test->test('sayhi', [
            ['Test1', 'Hello World!'],
            ['Test2', 'Hello World!', 'dfdf'],
         ]
    );

    // Get and Print results
    echo $Test->print_results();

    ?>

# Install

Download the Simple Unit Test class and include the relevant files in your test suit.

Compos---what? Seriously, since when the php include statement and autoload became rocket science?

# Documentation

**function __construct ( string $class [, variable list of optional parameters])**

*Description*

    create a Test object.

*Parameters*

class

    the name of the class (fully qualified name) to be tested. As option, it can be added
    any parameter needed to instatiate an object of the class that is being tested. 
    Example:
    
    //Class  My\Super\Drupper\Class use a string parameter 'username'.

    new Test('My\Super\Drupper\Class', 'username');
    

**function source_file( string $source_file)**

*Description*

    set the source file (where the callable functions are defined). 

*Parameters*

source_file

    file (including path if needed) of the source file. Example:
    $Test->source_file(__DIR__.'/test_source.php');
    another example:
    $Test->source_file('demo_test_suit.php');

**function autoload( string $autoload, bool $prepend=false)**

*Description*

    set the parameters for spl_autoload_register. Example:
    $test->autoload('my_autoloader', true);

*Parameters*

autoload

    callable function to be used to load your classes as they are needed.

prepend

    the prepend parameter of spl_autoload_register


**reset_object(int [$reset])**

*Description*

    by default all the tests of a class use the same instance of the class (object). However
    sometimes you might want to reset the object for every test.

*Parameters*

reset

    default is 0, which means that the same instance of the class will be use across all the
    tests of any method.
    value 1 indicates reset object instance for every new method test.
    value 2 will reset object instance at every test of every method being tested

**function add_dummies(string $class_name, array $methods, string $use_namespace=null)**

*Description*

    set the methods that will be override at runtime. This can be useful if you 
    need to mute an expensive method of a class or fake the return of a method or 
    if you want to try a new definition of a method without changing the original one.

*Parameters*

class_name    

    the full qualified name of the class where you want to use dummies methods

methods

    associative array where the keys are the name of the method (of the class specified
    in the first argument) and values are the name of callable functions to be use
    as sustitution for those methods.

use_namespace

    string of semi-colon separated namespaces needed for the definition of the callable functions
    use as dummies. For example if in the definition of the dummy, it requieres the instantiation
    of an object from a particular class. So you need to pass this class in the string use_namespace

*Example*

```
	//Suppose the method we are testing use the method WebService\WebRegister::send
	//which take few seconds to perform or has productions settings. 
	//So we want to override WebService\WebRegister::send with a custom callable function,
	//let's call it dummy_send. 
	
    function dummy_send(some-parameters){
        $obj=new Obj(); // if we suppose this is defined in the namespace NameSpace
       //some code
    }

    $Test->add_dummies('WebService\\WebRegister', ['send'=>'dummy_send'], 'NameSpace\Obj');
```
**_Note_**

    1) the parameters use for the callback function are the same of the original definition of
    the method.
    
    2) add_dummies method can be called as many times as needed in order to add more classes
    and methods

**function add_spy(string $class, string $method, string $position, string $callback, string $ckp1, string $ckp2...)**

*Description*

    Inject a user defined callback function inside the definition of the method $method of 
    the class $class at the position $position.
   
    The idea is to inject a callback function to help you to monitor variables inside a method.
    The output of the callback is captured and display in the Spy log section.
 
*Parameters*

class

    the name (full qualified name) of the class with the method you want to spy on
    
method

    the name of the method you want to spy on
    
position

    it can take just two values: 'begin' (begining of the method definition) 
    or 'end' (the end of the method definition just before return statement)
    
callback

    a callable function that you want to use to spy on the method

ckp1,... etc

    the names of the variables (as many as your callback needs) that you want to pass 
    to the callback. For example if you need to pass the variable $my_variable, you 
    need to pass 'my_variable'.


**function custom_return(string $method, string $callback, string $ckp1, string $ckp2...)**

*Description*

    Sometimes a method does not return any value. How do you test a method that does not return anything?
    Setting a custom return inject a callback into the method you want to test, and it is the
    return of this method that can be used to test your method against to. For example consider a counter

    private function my_counter(){
    	$this->counter++;
    }

    Obviously that method does not return anything, so setting a custom return we have something like
    
    private function my_counter(){
       $this->counter++;
       return my_callback($this->counter);
    }

*Parameters*

method

    the name of the method of the class that is being tested

    
callback

    a callable function that you want to use to return a value

ckp1,... etc

    the names of the variables (as many as your callback needs) that you want to pass 
    to the callback. For example if you need to pass the variable $my_variable, you 
    need to pass 'my_variable'.

**function test(string $method, array $test_data, string $assertion=null)**

*Description*

    Set the method and parameters for the test

*Parameters*	

method

    the name of the class method to be tested

test_data

    array of associative arrays each associative array should contain:
    name for the test, expected result, the parametes to be passed to the method to be tested
    
*Example*
```
    	 [
           ['Test1', some_result, 1,2,3,a,b,c],
           ['Test2', some_result2, 1,2,3,a],
           ['Test3', some_result3, 1,2,3,e,f,g],
        ];
```    
assertion

    name of a callable function to be used to assert the result of the method. If it is 
    omitted, the assertion is via "result==expected_value", if you need to assert '==='
    pass the string '===' as assertion parameter.


*Example*
```
    function assertion($result, $expected){
       return in_array($result, $expected);
    }
    
    function assertion($result, $expected){
       return $result<$expected;
    }

	function assertion($result, $expected){
		return whatever-you-want!
	}    
```

# How to use it

1. set the following lines in your test suit
```
    include 'simple_unit_test.php';
    use SimpleUnitTest\Test;
    Test::Set_URL('URL/of/your/test-suit');
```

2. create a Test object
```
    $Test=new Test('Demo', constructor-parameters-if-any);
```

3. define all the callable functions (autoload, dummies, spies, custom_return). These functions
can be defined in a a file and use the public method Test::set_source to include it in the test.
```
    //source_file.php
    <?php
       function my_autoload($class){
          //some code
       }
       //more definitions
       
   ?>
```

and in the test file:
```
    $Test->source_file('source_file.php');
```
   

4. add autoload and dummies if needed
```
    $Test->autoload('my_autoloader','prepend');
    $Test->add_dummies('someclass',array(
                     			'somemethod1'=>'new-code-for-the-method',
                     			'somemethod2'=>'new-code-for-the-method'
                     			));
    $Test->add_dummies('someotherclass',array(
                     			'someothermethod1'=>'new-code-for-the-method',
                     			'someothermethod2'=>'new-code-for-the-method'
                     			));                     			
```

5. set the relevant test cases
```
    $test_method1=[
               ['Test1',expected, rest-of-arguments], // coma separated
               ['Test2', expected, rest-of-arguments]
    ];

    $Test->test('Some_Method', $test_method1);

    // you can carry on settings other tests for other methods
    
    $test_method2=array(
               'Test1'=>array(array(arguments), expected),
               'Test2'=>array(array(arguments), expected),
    );
    $Test->test('Some_Method2', $test_method2);
```

6. when you are done setting your test cases for all the methods of your class you want to
test, run the test
```
    echo $Test->print_results();
```

# Examples

*Example 1*. This is a good example where we can put in practice the usage of dummies, 
spies and custom retutn.

File: helper_class.php
```
<?php
class Helper{
	public $sleeping;
	function __construct($sleep){
		$this->sleeping=$sleep;
	}
	function do_something(){
		sleep($this->sleeping);
	}
}
?>
```

File: demo_class.php
```
<?php
class Demo {
	
   private $name, $last_name, $age, $data;
   
	public function __construct(){
		$this->name='Elephant';
		$this->size='Very big';
		$this->weight='Very heavy';
		$this->age=0;
		$this->data=new Helper(5); // <<----- "Evil" dependency injection (obviously with lot of sarcasm)
	}
	
	public function get_data($str){
		$this->data->do_something();
		$this->get_old();
		if(isset($this->$str)){
			return $this->$str;
		}
		else{
			return false;
		}
	}
	
	public function get_old(){
		$this->age++;
	}

	public function print_to_file($str){
		$output='/tmp/zzzz_demo';
		$h=fopen($output, 'a');
		fwrite($h, $str);
		fclose($h);
	}
}
?>
```

Test suit file for Demo class:

```
<?php
include 'simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://path/to/this/test/demo_class_test.php')

// define a function to load the classes we need

function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}

$Test=new Test('Demo');
$Test->autoload('class_loader2');

/*
Prepare test for Demo::get_data. 
Since Demo::get_data calls Helper::do_something and this is a expensive call (5secs)
we mute it with a dummy. Also we want to monitor the behaviour of the property Demo::age
*/

function dnt(){
	return;
}
$Test->add_dummies('Helper', ['do_something'=>'dnt']);


function gd($x){
	return $x;
}
$Test->add_spy('Demo','get_old', 'end', 'gd', 'this->age');

$test_data=[
	['Test1', 'Elephant', 'name'],
	['Test2', 'Very big', 'size'],
	['Test3', 'Heavy', 'weight'],
	['Test4', 4, 'age'],	
];
$Test->test('get_data', $test_data);

/*
Prepare test for Demo::print_to_file.
Since this method does not return anything, we want to check the size of the output file.
*/

function ckf($file){
	clearstatcache();
	$n=0;
	if(file_exists($file)){
		$n=filesize($file);
		unlink($file);
	}
	return $n;
}
$Test->custom_return('print_to_file','ckf','output');

$test_data=[
	['Test1', 5, 'Hello'],
	['Test2', 11, 'Hello World'],
	['Test3', 9, 'Something'],
	['Test4', 13, 'Something new'],
];
$Test->test('print_to_file', $test_data, '===');

echo $Test->print_results();
?>
```

We can have a cleaner test suit by using a source file for all the callables functions.

File source_file.php
```
<?php
// define a function to load the classes we need

function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}

function dnt(){
	return;
}

function gd($x){
	return $x;
}

function ckf($file){
	clearstatcache();
	$n=0;
	if(file_exists($file)){
		$n=filesize($file);
		unlink($file);
	}
	return $n;
}
?>
```
Test suit for Demo class:
```
<?php
include 'simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://path/to/this/test/demo_class_test.php')

$Test=new Test('Demo');
$Test->autoload('class_loader2');
$Test->source_file(path/to/source_file.php);

/*
Prepare test for Demo::get_data. 
Since Demo::get_data calls Helper::do_something and this is a expensive call (5secs)
we mute it with a dummy. Also we want to monitor the behaviour of the property Demo::age
*/

$Test->add_dummies('Helper', ['do_something'=>'dnt']);

$Test->add_spy('Demo','get_old', 'end', 'gd', 'this->age');

$test_data=[
	['Test1', 'Elephant', 'name'],
	['Test2', 'Very big', 'size'],
	['Test3', 'Heavy', 'weight'],
	['Test4', 4, 'age'],	
];
$Test->test('get_data', $test_data);

/*
Prepare test for Demo::print_to_file.
Since this method does not return anything, we want to check the size of the output file.
*/


$Test->custom_return('print_to_file','ckf','output');

$test_data=[
	['Test1', 5, 'Hello'],
	['Test2', 11, 'Hello World'],
	['Test3', 9, 'Something'],
	['Test4', 13, 'Something new'],
];
$Test->test('print_to_file', $test_data, '===');

echo $Test->print_results();
?>
```

* Result:

![Example1](http://46.32.229.68/img/example1.png)

**_Example 2_**

The following code can be found [here](https://gist.github.com/jonmchan/4558701) 

```
============file1============
<?php
// Calculator.php
class Calculator {
    public function getNumberFromUserInput() {
        // complicated function to get number from user input
    }
    public function printToScreen($value) {
        // another complicated function
    }
    public function divideBy($num2) {
        if ($num2 == 0) return NAN;
        return $this->getNumberFromUserInput()/$num2;
    }
    public function divideByAndPrint($num2) {
        if ($num2 == 0) $this->printToScreen("NaN");
        $this->printToScreen($this->getNumberFromUserInput()/$num2);
    }
}
==========end file1=============

==========file2=================
<?php
// CalculatorTest.php
include_once("Calculator.php");

class CalculatorTest extends \PHPUnit_Framework_TestCase {
    public function testDivideByPositiveNumber() {
        $calcMock=$this->getMock('\Calculator',array('getNumberFromUserInput'));
        $calcMock->expects($this->once())
            ->method('getNumberFromUserInput')
            ->will($this->returnValue(10));
        $this->assertEquals(5,$calcMock->divideBy(2));
    }
    public function testDivideByZero() {
        $calcMock=$this->getMock('\Calculator',array('getNumberFromUserInput'));
        $calcMock->expects($this->never())
            ->method('getNumberFromUserInput')
            ->will($this->returnValue(10));
        $this->assertEquals(NAN, $calcMock->divideBy(0));
    }
    public function testDivideByNegativeNumber() {
        $calcMock=$this->getMock('\Calculator',array('getNumberFromUserInput'));
        $calcMock->expects($this->once())
            ->method('getNumberFromUserInput')
            ->will($this->returnValue(10));
        $this->assertEquals(-2,$calcMock->divideBy(-5));
    }
    public function testDivideByPositiveNumberAndPrint() {
        $calcMock=$this->getMock('\Calculator',array('getNumberFromUserInput', 'printToScreen'));
        $calcMock->expects($this->once())
            ->method('getNumberFromUserInput')
            ->will($this->returnValue(10));
        $calcMock->expects($this->once())
            ->method('printToScreen')
            ->with($this->equalTo('5'));
        $calcMock->divideByAndPrint(2);
    }
}
===========end file2=================
```

Testing the same class with Simple Unit Test:
```
<?php
include 'simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/UnitTest/demo.php');

function calculator_autoloader($name) {
    $name = str_replace('\\', '/', $name) . '.php';
    $srcPath = __DIR__ . '/Examples/src/' . $name;
    if (is_file($srcPath)) include_once $srcPath;
    else include_once __DIR__ . '/Examples/' . $name;
}

function mock_input(){
	static $a=0;
	$b=[12,16,22,24];
	return $b[$a++];
}

$Test=new Test('Math\CalculatorZ');
$Test->autoload('calculator_autoloader');
$Test->add_dummies('Math\CalculatorZ', ['getNumberFromUserInput'=>'mock_input']);

$test_data=[
	['DivideByPositive', 2, 6],
	['DivideByPositive2', 2, 8],
	['DivideByZero', NAN, 0],
];
$Test->test('divideBy', $test_data);
echo $Test->print_results();
```

* Result:

![Example2](http://46.32.229.68/img/example2.png)

**_Example 3_**

Let's see a real world example. This is from the tests of project [phpspreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)
and the test covered in this example is [this](https://github.com/PHPOffice/PhpSpreadsheet/blob/master/tests/PhpSpreadsheetTests/Reader/XmlTest.php). 
```
<?php
namespace PhpOffice\PhpSpreadsheetTests\Reader;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Reader\Xml;
use PHPUnit\Framework\TestCase;
class XmlTest extends TestCase
{
    /**
     * @dataProvider providerInvalidSimpleXML
     *
     * @param $filename
     */
    public function testInvalidSimpleXML($filename)
    {
        $this->expectException(\PhpOffice\PhpSpreadsheet\Reader\Exception::class);
        $xmlReader = new Xml();
        $xmlReader->trySimpleXMLLoadString($filename);
    }
    public function providerInvalidSimpleXML()
    {
        $tests = [];
        foreach (glob(__DIR__ . '/../../data/Reader/Xml/XEETestInvalidSimpleXML*.xml') as $file) {
            $tests[basename($file)] = [realpath($file)];
        }
        return $tests;
    }
    /**
     * Check if it can read XML Hyperlink correctly.
     */
    public function testReadHyperlinks()
    {
        $reader = new Xml();
        $spreadsheet = $reader->load('../samples/templates/Excel2003XMLTest.xml');
        $firstSheet = $spreadsheet->getSheet(0);
        $hyperlink = $firstSheet->getCell('L1');
        self::assertEquals(DataType::TYPE_STRING, $hyperlink->getDataType());
        self::assertEquals('PhpSpreadsheet', $hyperlink->getValue());
        self::assertEquals('https://phpspreadsheet.readthedocs.io', $hyperlink->getHyperlink()->getUrl());
    }
    public function testReadWithoutStyle()
    {
        $reader = new Xml();
        $spreadsheet = $reader->load(__DIR__ . '/../../data/Reader/Xml/WithoutStyle.xml');
        self::assertSame('Test String 1', $spreadsheet->getActiveSheet()->getCell('A1')->getValue());
    }
}

```
With Simple Unit Test:

source_file.php:
```
<?php

function autoloader($class){
	$name = str_replace('\\', '/', $class) . '.php';
	$name=strtr($name, ['PhpOffice/'=>'']);
   $srcPath = __DIR__ . '/../src/' . $name;
	
   if (is_file($srcPath)){
   	include_once $srcPath;
   }
   else{
   	include_once __DIR__ . '/' . $name;
   }
}


function assertion($result, $expected){
	static $a=0;
	if($a==0){
		$a++;
		$firstSheet = $result->getSheet(0);
   	$hyperlink = $firstSheet->getCell('L1');
	   return $expected === is_string($hyperlink->getDataType()) && ('PhpSpreadsheet'==$hyperlink->getValue()) &&
         ('https://phpspreadsheet.readthedocs.io'==$hyperlink->getHyperlink()->getUrl()); 
	}
	else{
		return $expected==$result->getActiveSheet()->getCell('A1')->getValue();
	}
}

?>

```

Test file:
```
<?php
include '../../Unit_test/simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/ZPhpSpreadsheet/Test/prueba.php');

$Test=new Test('PhpOffice\PhpSpreadsheet\Reader\Xml');
$Test->autoload('autoloader');
$Test->source_file('source_file.php');

// Begin test. Method: load

$test_data=[
	['ReadHyperlinks', true, '../samples/templates/Excel2003XMLTest.xml'],
	['ReadWithoutStyle', 'Test String 1', 'data/Reader/Xml/WithoutStyle.xml'],
];
$Test->test('load', $test_data, 'assertion');

// end test

// begin test. Method: trySimpleXMLLoadString

$test_data=[];
foreach(glob('data/Reader/Xml/XEETestInvalid*.xml') as $file) {
	$test_data[]=[basename($file), false, realpath($file)];
}
$Test->test('trySimpleXMLLoadString', $test_data);

//end of test

echo $Test->print_results();

?>
```
* Result:

![Example3](http://46.32.229.68/img/example3.png)

**_NOTE_**

Of course you can make a class where each method is a test (a la phpunit)
and test those method with Simple Unit Test.

**_More examples_**

More examples can be found in the file [demo.php](https://github.com/fpdf-easytable/simple_unit_test/blob/master/demo.php).

# FQA

*Over HTTP is too complicated*

    Really? Well I did it in less than 600 lines :-)

*But none of the examples are real code example*

    Well if you would have bothered to read the example section you would have seen one. By the way, 
    you will never see real code examples in tutorials for other test units. You want real examples? 
    Try it yourself.

*What about dependency injection?*

    Not a problem! See dummies and the examples are full of dependency injection.

# Conclusion

Testing your software is important. However, it is not rocket science or an art as people out there
think. You do not need to pass your hand behind your back and under your legs to scratch your nose. 

Simple Unit Test is far from being the swedish knife of the testing units. 
Simple Unit Test is a proof of the concept.
The concept that testing should be simple, straight forward and automatic.


# License

fpdf-easytable/simple_unit_test (Simple Unit Test) is licensed under the
GNU General Public License v3.0
