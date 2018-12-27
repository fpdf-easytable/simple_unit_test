<?php
include 'simple_unit_test.php';
use SimpleUnitTest\Test;
Test::Set_URL('http://localhost/UnitTest/demo.php');
include 'header.html.php';


//####################################################################
//####################################################################
//####################################################################


function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}

//====================================================================

//*
$Test=new Test('Demo', array(
				'autoload'=>'class_loader2',
				'prepend'=>false, 
				'dummies'=>array('Helper'=>array('get_name'=>2))
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

//####################################################################
//*
$Test=new Test('Wrapper', array(
				'constructor_params'=>array(),
				'autoload'=>'class_loader2',
	)
);

$test_data=array(
	'Test1'=>array(array(null),'Hello world')
	);
$Test->test('say_hello', $test_data);
echo $Test->print_results();

/**/

//####################################################################
//####################################################################
//####################################################################
// *
$Test=new Test('RemoteConnect', array(
				'constructor_params'=>array(),
				'autoload'=>'class_loader2',
			));

$test_data=array(
	'Test1'=>array(array('www.google.co.uk'),true)
	);
function assertion($x, $y){
	return $x===$y;
}
$Test->test('connectToServer', $test_data, 'assertion');
echo $Test->print_results();

//####################################################################

function class_loader($class){
	$base='phpunit_example/src/';
	$base.="{$class}.php";
	$base=strtr($base, array('Abc\\Def\\Ghi\\'=>''));
	if(file_exists($base)){
		include_once $base;
	}
}

$Test=new Test('Abc\\Def\\Ghi\\Number',array(
				'constructor_params'=>array(34),
				'autoload'=>'class_loader',
			)
		);

$test_data=array(
	'Test3'=>array(array('weight'), 'Heavy'),
	'Test1'=>array(array(4), 136),
	'Test2'=>array(array(-4), 30),
	
);
$Test->test('multiply', $test_data);
echo $Test->print_results();

/**/

//####################################################################
//####################################################################
//####################################################################
//####################################################################

function calculator_autoloader($name) {
    $name = str_replace('\\', '/', $name) . '.php';
    // Try to load class from src dir
    $srcPath = __DIR__ . '/src/' . $name;
    if (is_file($srcPath)) include_once $srcPath;
   
    // Load the class from tests dir otherwise
    else include_once __DIR__ . '/' . $name;
}

//--------------------------------------------------------------------

//*

$Test=new Test('Math\Calculator',array(
				'constructor_params'=>array(),
				'autoload'=>'calculator_autoloader',
			)
);

$test_data=array(
	//'Test3'=>array(array('weight'), 'Heavy'),
	'Test1'=>array(array(4, 2), 2),
	'Test2'=>array(array(-4,0), -2),
	
);

$Test->test('divide', $test_data);
echo $Test->print_results();

/**/
//####################################################################
//####################################################################
//*

spl_autoload_register('calculator_autoloader');

$rgtr=new WebService\WebRegister();

//echo serialize($rgtr);

$Test=new Test('Math\Calculator2',array(
				'constructor_params'=>array($rgtr),
				'autoload'=>'calculator_autoloader',
				)			
);

$test_data=array(
	'Test3'=>array(array('weight', 45), 'Heavy'),
	'Test1'=>array(array(4, 2), 2),
	'Test2'=>array(array(-4,0), -2),	
);

$result=$Test->test('multiply', $test_data);
echo $Test->print_results();

//####################################################################
//*

$Test=new Test('Math\Calculator_wrapper', array(
				'constructor_params'=>array(),
				'autoload'=>'calculator_autoloader',
				'dummies'=>array('WebService\\WebRegister'=>array('send'=>'true'))
			));

$test_data=array(
	'Test1'=>array(array(4, 2), 2),
	'Test2'=>array(array(4, 0), 2),
	);
$Test->test('divide', $test_data);
echo $Test->print_results();
/**/

//####################################################################
//####################################################################

include 'footer.html';

?>