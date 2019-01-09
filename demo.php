<?php
include 'simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/UnitTest/demo.php');


//####################################################################

function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Examples/Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}

//====================================================================

$Test=new Test('Demo');
$Test->autoload('class_loader2');


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

//####################################################################
/*
If you want to test functions wrap them in a class
*/

$Test=new Test('Wrapper');
$Test->autoload('class_loader2');
$test_data=[
	['Test1', 'Hello world']
];

$Test->test('say_hello', $test_data);
echo $Test->print_results();

/**/
//####################################################################
//*
$Test=new Test('RemoteConnect');
$Test->autoload('class_loader2');

$test_data=[
	['Test1', true, 'www.google.co.uk']
];

$Test->test('connectToServer', $test_data, '===');
echo $Test->print_results();

//####################################################################

function class_loader($class){
	$base='Examples/phpunit_example/src/';
	$base.="{$class}.php";
	$base=strtr($base, array('Abc\\Def\\Ghi\\'=>''));
	if(file_exists($base)){
		include_once $base;
	}
}


$Test=new Test('Abc\\Def\\Ghi\\Number',34);
$Test->autoload('class_loader');

$test_data=[
	['Test3', 'Heavy', 'weight'],
	['Test1', 136, 4],
	['Test2', 30, -4],
];

$Test->test('multiply', $test_data);
echo $Test->print_results();

//####################################################################

function calculator_autoloader($name) {
    $name = str_replace('\\', '/', $name) . '.php';
    $srcPath = __DIR__ . '/Examples/src/' . $name;
    if (is_file($srcPath)) include_once $srcPath;
    else include_once __DIR__ . '/Examples/' . $name;
}

//--------------------------------------------------------------------

$Test=new Test('Math\Calculator');
$Test->autoload('calculator_autoloader');

$test_data=[
	['Test1', 2, 4, 2],
	['Test2', -2, -4, 0],
];

$Test->test('divide', $test_data);
echo $Test->print_results();

//####################################################################
/*
The constructor of Calculator2 has  as a parameter a web service object
that require certain time to execute. However we can redefine
that object so we do not wait.
*/

spl_autoload_register('calculator_autoloader');

$rgtr=new WebService\WebRegister(4);

function no_wait(){
	sleep(0);
}

$Test=new Test('Math\Calculator2',$rgtr);
$Test->autoload('calculator_autoloader');
$Test->add_dummies('WebService\WebRegister', ['send'=>'no_wait']);			


$test_data=[
	['Test3', 'Heavy', 'weight', 45],
	['Test1', 8, 4, 2],
	['Test2', -2, -4,0]
];

$Test->test('multiply', $test_data);
echo $Test->print_results();

//####################################################################

function no_send(){
	return true;
}

$Test=new Test('Math\Calculator_wrapper');
$Test->autoload('calculator_autoloader');
$Test->add_dummies('WebService\WebRegister', ['send'=>'no_send']);

$test_data=[
	['Test1', 2, 4, 2],
	['Test2', 2, 4, 0]
];

$Test->test('divide', $test_data);
echo $Test->print_results();

//####################################################################

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

//####################################################################

include 'footer.html';

?>