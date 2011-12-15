<?php

namespace Clinner\Tests;

use Clinner\Command;
use Clinner\ValueHolder;


/**
 * Command test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticCreate()
    {
        $command = Command::create('name');
        
        $this->assertInstanceOf(
            '\\Clinner\\Command',
            $command
        );
        $this->assertEquals('name', $command->getName());
    }
    
    public function testConstructorWithoutArgs()
    {
        $command = new Command('name');
        
        $this->assertEquals('name', $command->getName());
        $this->assertEmpty($command->getArgumentsArray());
    }
    
    public function testConstructorWithArgsArray()
    {
        $args = array(
            'key' => 'value',
            'other',
        );
        $command = new Command('name', $args);
        
        $this->assertEquals($args, $command->getArgumentsArray());
    }
    
    public function testConstructorWithArgsValueHolder()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        
        $command = new Command('name', $valueHolderMock);
        
        $this->assertSame($valueHolderMock, $command->getArguments());
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
        
        $command = new Command('name', $valueHolderMock);
        
        $got = $command->getArgument('key');
        $this->assertEquals('value', $got);
        
        $got = $command->getArgument('other');
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
        
        $command = new Command('name', $valueHolderMock);
        
        $this->assertSame($command, $command->setArgument('key', 'value'));
        $this->assertSame($command, $command->setArgument('other', 'otherValue'));
    }
    
    public function testGetName()
    {
        $command = new Command('name');
        
        $this->assertEquals('name', $command->getName());
        
        $command->setName('otherName');
        
        $this->assertEquals('otherName', $command->getName());
    }
    
    public function testSetName()
    {
        $command = new Command('name');
        
        $this->assertSame($command, $command->setName('otherName'));
        
        $this->assertEquals('otherName', $command->getName());
    }
    
    public function testGetArguments()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $command = new Command('name', $valueHolderMock);
        
        $this->assertSame($valueHolderMock, $command->getArguments());
    }
    
    public function testSetArguments()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $command = new Command('name');
        
        $this->assertSame($command, $command->setArguments($valueHolderMock));
        
        $this->assertSame($valueHolderMock, $command->getArguments());
    }
    
    public function testGetArgumentsArray()
    {
        $valueHolderMock = $this->getMock('\\Clinner\\ValueHolder');
        $valueHolderMock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue(array()));
        
        $command = new Command('name', $valueHolderMock);
        
        $this->assertEquals(array(), $command->getArgumentsArray());
    }
    
    public function testRun()
    {
        $this->markTestSkipped();
    }
}