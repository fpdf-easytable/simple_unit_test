<?php
namespace Ampersand\Challenge\Tests\BasicOop;

use Ampersand\Challenge\BasicOop\Number;

class NumberTest extends \PHPUnit_Framework_TestCase
{
    public function testImplements()
    {
        $this->assertInstanceOf(
            'Ampersand\\Challenge\\BasicOop\\NumberInterface',
            new Number,
            'Number does not implement NumberInterface.'
        );
    }
    
    public function testConstruct()
    {
        $n = new Number;
        $this->assertEquals(0, $n->toInt());
        
        $n = new Number(0);
        $this->assertEquals(0, $n->toInt());
        
        $n = new Number(3);
        $this->assertEquals(3, $n->toInt());
    }
    
    public function testAdd()
    {
        $n = new Number;
        
        $n->add(5);
        $this->assertEquals(5, $n->toInt());
        
        $n->add(-7);
        $this->assertEquals(-2, $n->toInt());
    }
    
    public function testSubtract()
    {
        $n = new Number;
        
        $n->subtract(8);
        $this->assertEquals(-8, $n->toInt());
        
        $n->subtract(-10);
        $this->assertEquals(2, $n->toInt());
    }
    
    public function testMultiply()
    {
        $n = new Number(1);
        
        $n->multiply(10);
        $this->assertEquals(10, $n->toInt());
        
        $n->multiply(6);
        $this->assertEquals(60, $n->toInt());
    }
    
    public function testDivide()
    {
        $n = new Number(100);
        
        $n->divide(5);
        $this->assertEquals(20, $n->toInt());
        
        $n->divide(5);
        $this->assertEquals(4, $n->toInt());
    }
}