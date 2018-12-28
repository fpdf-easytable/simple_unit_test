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

Does a unit test help to develop better code? Not really, the bottom line is that the code 
and the test cases depend on the skills of the developer. In other words, as far as one
does not use the relevant test cases his program, it does not matter if he is using 
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


	new Test('ClassName',
				array(
						'constructor_params'=>array,
						'autoload'=>string,
						'prepend'=>false, 
						'dummies'=>array
			)
	)
	
	'ClassName': string, it shuld set as it needs to be called (including namespace path if needed)	
	'construnctor_params': [array/mix] of the parameters use to instantiate the object
								if not arguments then empty array can be passed
								if just one argument is needed, the this can be passed instead of array
	'autoload': [string] callable function to be used to load your classes needed
	'prepend': [bool] parameter pass to spl_autoload_register
	'dummies': [array] define which classes and method will be alterated.
	            It is an key/values array where the keys are the name of the 
	            clases(full qualified names) and values are array of the methods of the class
	            and values are the desired result for that method 


	test(
		'get_data', [string]
		$test_data : [array]
		'assertion' : [string]
		);	