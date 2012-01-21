<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner\Command\Tests;

use Clinner\Command\Command;
use Clinner\ValueHolder;


/**
 * Command test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Clinner\Command\Command::create
     */
    public function testStaticCreateNoArgsNoOpts()
    {
        $name = 'ls';

        $command = Command::create($name);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);
        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEmpty('_next', $command);
        $this->assertAttributeEmpty('_exitCode', $command);
        $this->assertAttributeEmpty('_output', $command);
    }

    /**
     * @covers \Clinner\Command\Command::create
     */
    public function testStaticCreateWithArgsAndOpts()
    {
        $name = 'ls';
        $args = array('first' => 'value', 'second' => 'second value');
        $opts = array('some_option' => 'some value');

        $command = Command::create($name, $args, $opts);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);
        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEmpty('_next', $command);
        $this->assertAttributeEmpty('_exitCode', $command);
        $this->assertAttributeEmpty('_output', $command);
    }

    /**
     * @covers \Clinner\Command\Command::__construct
     */
    public function testConstructorDefaults()
    {
        $name = 'some-command';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName', 'setArguments', 'setOptions'))
            ->getMock();

        $command->expects($this->once())
            ->method('setName')
            ->with($this->equalTo($name))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo(array()))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setOptions')
            ->with($this->equalTo(array()))
            ->will($this->returnSelf());

        $command->__construct($name);
    }

    /**
     * @covers \Clinner\Command\Command::__construct
     */
    public function testConstructorWithValues()
    {
        $name = 'command-name';
        $args = array('first' => 'value');
        $opts = array('delimiter' => '?');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName', 'setArguments', 'setOptions'))
            ->getMock();

        $command->expects($this->once())
            ->method('setName')
            ->with($this->equalTo($name))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo($args))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setOptions')
            ->with($this->equalTo($opts))
            ->will($this->returnSelf());

        $command->__construct($name, $args, $opts);
    }

    /**
     * @covers \Clinner\Command\Command::getName
     */
    public function testGetName()
    {
        $name = 'command-name';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName'))
            ->getMock();

        $this->_setPrivateProperty($command, '_name', $name);

        $this->assertEquals($name, $command->getName());
    }

    /**
     * @covers \Clinner\Command\Command::setName
     */
    public function testSetName()
    {
        $name = 'command';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName'))
            ->getMock();

        $this->assertAttributeEmpty('_name', $command);

        $response = $command->setName($name);

        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::getArguments
     */
    public function testGetArguments()
    {
        $args = new ValueHolder(array('some' => 'arg'));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName'))
            ->getMock();

        $this->_setPrivateProperty($command, '_arguments', $args);

        $this->assertEquals($args, $command->getArguments());
    }

    /**
     * @covers \Clinner\Command\Command::setArguments
     */
    public function testSetArgumentsWithArray()
    {
        $args = array('some' => 'arg', 'another' => 'argument');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getArguments'))
            ->getMock();

        $this->assertAttributeEmpty('_arguments', $command);

        $response = $command->setArguments($args);

        $instanceValueHolder = $this->_getPrivateProperty($command, '_arguments');

        $this->assertInstanceof('\\Clinner\\ValueHolder', $instanceValueHolder);
        $this->assertAttributeEquals($args, '_values', $instanceValueHolder);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::setArguments
     */
    public function testSetArgumentsWithValueHolder()
    {
        $args = $this->getMock('\\Clinner\\ValueHolder');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getArguments'))
            ->getMock();

        $this->assertAttributeEmpty('_arguments', $command);

        $response = $command->setArguments($args);

        $this->assertAttributeInstanceof('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeEquals($args, '_arguments', $command);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::getOptions
     */
    public function testGetOptions()
    {
        $opts = new ValueHolder(array('one' => 'option'));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setOptions'))
            ->getMock();

        $this->_setPrivateProperty($command, '_options', $opts);

        $this->assertEquals($opts, $command->getOptions());
    }

    /**
     * @covers \Clinner\Command\Command::setOptions
     */
    public function testSetOptionsWithArray()
    {
        $opts = array('some' => 'opt', 'another' => 'nifty option');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getOptions'))
            ->getMock();

        $this->assertAttributeEmpty('_options', $command);

        $response = $command->setOptions($opts);

        $instanceValueHolder = $this->_getPrivateProperty($command, '_options');

        $this->assertInstanceof('\\Clinner\\ValueHolder', $instanceValueHolder);
        $this->assertAttributeEquals($opts, '_values', $instanceValueHolder);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::setOptions
     */
    public function testSetOptionsWithValueHolder()
    {
        $opts = $this->getMock('\\Clinner\\ValueHolder');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getArguments'))
            ->getMock();

        $this->assertAttributeEmpty('_options', $command);

        $response = $command->setOptions($opts);

        $this->assertAttributeInstanceof('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEquals($opts, '_options', $command);
        $this->assertSame($command, $response);
    }

    /**
     * Set a private property to a Command $object.
     *
     * @param \Clinner\Command\Command $object The object to update.
     * @param string                   $name   The private property name.
     * @param mixed                    $value  The new value for the property.
     */
    protected function _setPrivateProperty($object, $name, $value)
    {
        $property = new \ReflectionProperty(
            '\\Clinner\\Command\\Command',
            $name
        );

        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * Get the value of a private property from a Command $object.
     *
     * @param \Clinner\Command\Command $object The object to inspect.
     * @param string                   $name   The private property name.
     *
     * @return mixed
     */
    protected function _getPrivateProperty($object, $name)
    {
        $property = new \ReflectionProperty(
            '\\Clinner\\Command\\Command',
            $name
        );

        $property->setAccessible(true);

        return $property->getValue($object);
    }
}