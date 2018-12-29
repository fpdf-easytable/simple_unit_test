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

    include '../Unit_test/header.html.php'; // for HTML

    function autoloader($class) {
        //some code
    }

    // Instantiate a new Test object
    $Test=new Test('HelloWorld',array(
									'constructor_params'=>array(),
									'autoload'=>'autoloader',
								)
    );

    //Test
    $Test->test('sayhi', array(
	   						     'Test1'=>array(array(), 'Hello World!'),
   	   						  'Test2'=>array(array('dfdf'), 'Hello World!'),
								    )
    );

    // Get and Print results
    echo $Test->print_results();

    ?>

# Features

- No need to extend any class
- Dummy objects (test doubles)
- Set custom definition of assertion function to be used for the test;
- Ability to test private or public methods


# Documentation

**function __construct ( string $class, array $set_up)**

*Description*

class

    the name of the class (fully qualified name) to be tested
    
set_up

    associative array 
					'constructor_params'=>array,
					'autoload'=>string,
					'prepend'=>false, 
					'dummies'=>array
    'construnctor_params': [array/mix] of the parameters use to instantiate the object
								if not arguments then empty array can be passed
								if just one argument is needed, the this can be passed instead of array
    'autoload': [string] callable function to be used to load your classes needed
    'prepend': [bool] (optional) parameter pass to spl_autoload_register
    'dummies': [array] (optional) define which classes and method will be alterated.
	            It is an key/values array where the keys are the name of the 
	            clases(full qualified names) and values are array of the methods of the class
	            and values are the desired result for that method 

*Example*

```
    $Test=new Test('Demo', array(
                                'constructor_params'=>array(),
                                'autoload'=>'class_loader2',
                                'prepend'=>false, 
                                'dummies'=>array('WebService\\WebRegister'=>array('send'=>'return true')))
        )
    );
```

**function test(string $method, array $test_data, string $assertion=null)**

*Description*

   Set the method and parameters for the test

*Parameters*	

method

    the name of the class method to be tested

test_data

    associative array 
    	 array(
         'name of the test'=>array(
         						array of parameters,
         						expected value
         						)
	    );
    
assertion

    name of a callable function to be used to assert the result of the method. If it is 
    omitted, the assertion is via "result==expected_value".
		
*Example*

```
    function assertion($result, $expected){
        return $result===$expected;
    }

    $Test->test('connectToServer', 
             array('Test1'=>array(array('www.example.com'),true)), 'assertion');
    
```		
*Other examples of assertions*

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
    $Test=new Test('Demo', array(
                     'constructor_params'=>array(of-parameters),
                     'autoload'=>'my_autoloader',
                     'prepend'=>false, 
                     'dummies'=>array('someclass'=>array(
                     			'somemethod1'=>'new-code-for-the-method'),
                     			'somemethod2'=>'new-code-for-the-method')
                     			),
                     			'anotherclass'=>array(
                     			'someothermethod1'=>'new-code-for-the-method'),
                     			'someothermethod2'=>'new-code-for-the-method')
                     			)
							)
    );
```

3. set the relevant test cases
```
    $test_method1=array(
               'Test1'=>array(array(arguments), expected),
               'Test2'=>array(array(arguments), expected),
    );
    $Test->test('Some_Method', $test_method1);

    // you can carry on settings other tests for other methods
    
    $test_method2=array(
               'Test1'=>array(array(arguments), expected),
               'Test2'=>array(array(arguments), expected),
    );
    $Test->test('Some_Method2', $test_method2);
```

4. when you are done setting your test cases for all the methods of your class you want to
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
Test::Set_URL('http://localhost/UnitTest/demo.php');
include 'header.html.php';
//====================================================================

// define a function to load the classes we need

function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}

 
$Test=new Test('Demo', array(
				'autoload'=>'class_loader2',
				'prepend'=>false, 
			)
);

$test_data=array(
	'Test1'=>array(array('name'), 'Elephant'),
	'Test2'=>array(array('size'), 'Very big'),
	'Test3'=>array(array('weight'), 'Heavy'),
	'Test4'=>array(array('age'), 4),	
);
$Test->test('get_data', $test_data);

$test_data=array(
	'Test1'=>array(array(null),null)
	);
$Test->test('print_to_file', $test_data);
echo $Test->print_results();
?>

// end file
//=========================================================


```




