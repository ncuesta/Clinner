<?php

namespace Clinner\Command\Tests;


/**
 * Base command test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticCreate()
    {
        $command = ConcreteBase::create('name');

        $this->assertInstanceOf(
            '\\Clinner\\Command\\Base',
            $command
        );
        $this->assertEquals('name', $command->getName());
    }

    public function testConstructorWithoutArgs()
    {
        $base = new ConcreteBase('name');
        
        $this->assertEquals('name', $base->getName());
        $this->assertEmpty($base->getArgumentsArray());
    }
    
    public function testConstructorWithArgsArray()
    {
        $args = array(
            'key' => 'value',
            'other',
        );
        $base = new ConcreteBase('name', $args);
        
        $this->assertEquals($args, $base->getArgumentsArray());
    }
    
    public function testConstructorWithArgsValueHolder()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        
        $base = new ConcreteBase('name', $valueHolderMock);
        
        $this->assertSame($valueHolderMock, $base->getArguments());
    }
    
    public function testGetArgument()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $valueHolderMock->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('key'))
            ->will($this->returnValue('value'));
        $valueHolderMock->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('other'))
            ->will($this->returnValue('otherValue'));
        
        $base = new ConcreteBase('name', $valueHolderMock);
        
        $got = $base->getArgument('key');
        $this->assertEquals('value', $got);
        
        $got = $base->getArgument('other');
        $this->assertEquals('otherValue', $got);
    }
    
    public function testSetArgument()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $valueHolderMock->expects($this->at(0))
            ->method('set')
            ->with($this->equalTo('key'), $this->equalTo('value'));
        $valueHolderMock->expects($this->at(1))
            ->method('set')
            ->with($this->equalTo('other'), $this->equalTo('otherValue'));
        
        $base = new ConcreteBase('name', $valueHolderMock);
        
        $this->assertSame($base, $base->setArgument('key', 'value'));
        $this->assertSame($base, $base->setArgument('other', 'otherValue'));
    }
    
    public function testGetName()
    {
        $base = new ConcreteBase('name');
        
        $this->assertEquals('name', $base->getName());
        
        $base->setName('otherName');
        
        $this->assertEquals('otherName', $base->getName());
    }
    
    public function testSetName()
    {
        $base = new ConcreteBase('name');
        
        $this->assertSame($base, $base->setName('otherName'));
        
        $this->assertEquals('otherName', $base->getName());
    }
    
    public function testGetArguments()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $base = new ConcreteBase('name', $valueHolderMock);
        
        $this->assertSame($valueHolderMock, $base->getArguments());
    }
    
    public function testSetArguments()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $base = new ConcreteBase('name');
        
        $this->assertSame($base, $base->setArguments($valueHolderMock));
        
        $this->assertSame($valueHolderMock, $base->getArguments());
    }
    
    public function testGetArgumentsArray()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $valueHolderMock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue(array()));
        
        $base = new ConcreteBase('name', $valueHolderMock);
        
        $this->assertEquals(array(), $base->getArgumentsArray());
    }
    
    public function testToString()
    {
        $base = new ConcreteBase('name');

        $this->assertEquals('name', $base->__toString());
    }
}

/**
 * Concrete implementation class of Base so as to be able to test it.
 */
class ConcreteBase extends \Clinner\Command\Base
{
    public function run($input = null) { }
}