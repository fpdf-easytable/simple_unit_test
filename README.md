# Simple Unit Test

Simple Unit Test is a php class to test php code. Why over http? It is highly 
probably you are developing a web application, therefore server configuration is a 
criteria to be considered.

More than an attempt to be an exhaustive unit test, Simple Unit Test is a proof of the concept.
The concept that testing should be simple, straight forward and automatic.


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

- No need to extend any class
- Dummy objects (test doubles)
- Set custom definition of assertion function to be used for the test;
- Ability to test private or public methods



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

**function __construct ( string $class)**

*Description*

class

    the name of the class (fully qualified name) to be tested

**function autoload( string $autoload, bool $prepend=false)**

*Description*

    set the parameter for spl_autoload_register

*Parameters*

autoload

    callable function to be used to load your classes as they are needed

prepend

    parameter pass to spl_autoload_register

**function add_dummies(string $class_name, array $methods, string $use_namespace=null)**

*Description*

    the methods of the classes that we want to overwrite

*Parameters*

class_name    

    the full qualified name of the class where you want to use dummies methods

methods

    associative array where the keys are the name of the method (of the class specified
    in the first argument) and values are the name of callable functions to be use
    as sustitution for those methods.

use_namespace

	string of semi-colon separated namespaces needed as in the definition of the class
	class_name

*Example*

```
    function dummy_send(some-parameters){
       //some code
    }

    $Test->add_dummies('WebService\\WebRegister', ['send'=>'dummy_send']);
```
**_Note_**
    1) the parameters use for the callback function are the same of the original definition of
    the method.
    
    2) add_dummies method can be called as many times as needed in order to add more classes
    and methods

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
    	 [
           ['Test1', some_result, 1,2,3,a,b,c],
           ['Test2', some_result2, 1,2,3,a],
           ['Test3', some_result3, 1,2,3,e,f,g],
        ];
    
assertion

    name of a callable function to be used to assert the result of the method. If it is 
    omitted, the assertion is via "result==expected_value", if you need to assert '==='
    pass the string '===' as assetion parameter.


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
    include 'header.html.php';
```

2. create a Test object
```
    $Test=new Test('Demo', constructor-parameters-if-any);
```

3. add autoload and dummies if needed
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

4. set the relevant test cases
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

5. when you are done setting your test cases for all the methods of your class you want to
test, run the test
```
    echo $Test->print_results();
```

# Examples

*Example 1.

```
// file: demo_class.php
<?php
class Demo {
	
   private $name, $last_name, $age, $data;
	public function __construct(){
		$this->name='Elephant';
		$this->size='Very big';
		$this->weight='Very heavy';
		$this->age=0;
		$this->data=new Helper('Hola');
	}
	
	public function get_data($str){
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
		return $this->age;
	}

	public function print_to_file(){
		$h=fopen('/tmp/zzzz_demo', 'w');
		fwrite($h, var_export($this, true));
		fclose($h);
	}
}
?>
//end of file

//=========================================================

// test suit for Demo class

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
$test_data=[
	['Test1', 'Elephant', 'name'],
	['Test2', 'Very big', 'size'],
	['Test3', 'Heavy', 'weight'],
	['Test4', 4, 'age'],	
];
$Test->test('get_data', $test_data);

$test_data=[['Test1', null]];
$Test->test('print_to_file', $test_data);

echo $Test->print_results();
?>

// end file
//=========================================================

```
* Result:

![Example1](http://212.67.221.142/img/example1.png)

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
	$c=$a;
	$a++;
	return $b[$c];
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

![Example2](http://212.67.221.142/img/example2.png)

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

```
<?php
include '../../Unit_test/simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/ZPhpSpreadsheet/Test/prueba.php');

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

$Test=new Test('PhpOffice\PhpSpreadsheet\Reader\Xml');
$Test->autoload('autoloader');

// Begin test. Method: load
// for test this method we need to define an assertion to be used

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

![Example3](http://212.67.221.142/img/example3.png)

**_NOTE_**

Of course you can make a class where each method is a test (a la phpinit)
and test those method with Simple Unit Test.

**_More examples_**

More examples can be found in the file [demo.php](https://github.com/fpdf-easytable/simple_unit_test/blob/master/demo.php).

# Conclusion

Testing your software is important... No, it is not rocket science or and art as people out there
think. You do not need to pass your hand behind your back and under your leds to scratch your nose. 

Simple Unit Test is far from being the swedish knife of the testing units.

# License

fpdf-easytable/simple_unit_test (Simple Unit Test) is licensed under the
GNU General Public License v3.0
