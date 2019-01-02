<?php
namespace Ampersand\Challenge\Tests\BasicOop;

use Ampersand\Challenge\BasicOop\Number;

class AdvancedNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getNonIntValues
     * @expectedException InvalidArgumentException
     */
    public function testConstruct($value)
    {
        new Number($value);
    }
    
    /**
     * @dataProvider getNonIntValues
     * @expectedException InvalidArgumentException
     */
    public function testAdd($value)
    {
        $n = new Number;
        $n->add($value);
    }
    
    /**
     * @dataProvider getNonIntValues
     * @expectedException InvalidArgumentException
     */
    public function testSubtract($value)
    {
        $n = new Number;
        $n->subtract($value);
    }
    
    /**
     * @dataProvider getNonIntValues
     * @expectedException InvalidArgumentException
     */
    public function testMultiply($value)
    {
        $n = new Number;
        $n->subtract($value);
    }
    
    /**
     * @dataProvider getNonIntValues
     * @expectedException InvalidArgumentException
     */
    public function testDivide($value)
    {
        $n = new Number;
        $n->divide($value);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testDivideByZero()
    {
        $n = new Number;
        $n->divide(0);
    }
    
    public function getNonIntValues()
    {
        return array(
            array(
                '5',
            ),
            array(
                null,
            ),
            array(
                3.00,
            ),
        );
    }
}