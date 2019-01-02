<?php
include '../Unit_test/simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/Z_test/number_test.php');

include '../Unit_test/header.html.php';

//####################################################################

function autoloader($class) {
	$base='src/';
	$base.="{$class}.php";
	$base=strtr($base, array('Abc\\Def\\Ghi\\'=>''));
	if(file_exists($base)){
		include_once $base;
	}
}

/*
* Instantiate a new Test object
*/
$Test=new Test('Abc\\Def\\Ghi\\Number',array(
				'constructor_params'=>array(0),
				'autoload'=>'autoloader',
			)
);

/*
* Test addition
*/
$add_test=array(
	'Test1'=>array(array(5), 5),
	'Test2'=>array(array(-7), -2),
	'Test3'=>array(array(2), 0),
	'Test4'=>array(array('e'), 0),
);
$Test->test('add', $add_test);

/*
* Test toInt
*/
$Test->test('toInt', array('Test'=>array(array(), 0)));

/*
* Test subtraction
*/
$subtract_test=array(// 
	'Test1'=>array(array(8), -8),
	'Test2'=>array(array(-10), 2),
	'Test3'=>array(array(1), 1),
);
$Test->test('subtract', $subtract_test);


/*
* Test multiplication
*/
$multiply_test=array(
	'Test1'=>array(array(10), 10),
	'Test2'=>array(array(6), 60),	
	'Test3'=>array(array(10), 600),	
);
$Test->test('multiply', $multiply_test); 
 
/*
* Test division
*/   
$divide_test=array(
	'Test1'=>array(array(6), 100),        
	'Test2'=>array(array(5), 20),        
	'Test3'=>array(array(5), 4),        
);
$Test->test('divide', $divide_test);

/*
* Get and Print results
*/
echo $Test->print_results();


?>