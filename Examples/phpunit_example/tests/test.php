<?php

require_once 'NumberInterface.php';
require_once 'NumberTest.php';
require_once 'AdvancedNumberTest.php';
require_once 'Number.php';

$basicTests = new Ampersand\Challenge\BasicOop\NumberTest;

foreach (array(
    'construct',
    'add',
    'subtract',
    'multiply',
    'divide',
) as $method) {
    try {
        $realMethodName = 'test' . ucfirst($method);
        call_user_func(array($basicTests, $realMethodName));
        echo "Basic $realMethodName() test passed\n";
    } catch (\Exception $e) {
        echo "Basic $realMethodName() test failed: {$e->getMessage()}\n";
    }
}

$advancedTests = new Ampersand\Challenge\BasicOop\AdvancedNumberTest;

foreach (array(
    'construct',
    'add',
    'subtract',
    'multiply',
    'divide',
    'divideByZero',
) as $method) {
    try {
        $realMethodName = 'test' . ucfirst($method);
        call_user_func(array($advancedTests, $realMethodName));
        echo "Basic $realMethodName() test passed\n";
    } catch (\Exception $e) {
        echo "Basic $realMethodName() test failed: {$e->getMessage()}\n";
    }
}