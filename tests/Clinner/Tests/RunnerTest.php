<?php

namespace Clinner\Tests;

use Clinner\Runner;
use Clinner\ArgumentsFormatter\Customizable;


/**
 * Runner test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class RunnerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorWithoutFormatter()
    {
        $runner = new Runner();
        
        $this->assertInstanceOf(
            '\\Clinner\\ArgumentsFormatter\\DoubleDashed',
            $runner->getFormatter()
        );
    }
    
    /**
     * @dataProvider getFormatters
     */
    public function testConstructorWithFormatter($formatter)
    {
        $runner = new Runner($formatter);
        
        $this->assertInstanceOf(get_class($formatter), $runner->getFormatter());
    }
    
    public function testRun()
    {
        $commandMock = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName', 'getArgumentsArray'))
            ->getMock();
        $commandMock->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('name'));
        $commandMock->expects($this->once())
            ->method('getArgumentsArray')
            ->will($this->returnValue(array()));

        $formatterMock = $this->getMock('\\Clinner\\ArgumentsFormatter\\Dashed');
        $formatterMock->expects($this->once())
            ->method('format')
            ->with($this->equalTo(array()))
            ->will($this->returnValue(''));

        $executorMock = $this->getMock('\\Clinner\\Executor\\Executor');
        $executorMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo('name '))
            ->will($this->returnValue(0));

        $runner = new Runner($formatterMock, $executorMock);

        $exitCode = $runner->run($commandMock);

        $this->assertEquals(0, $exitCode);
    }
    
    /**
     * Data provider for testConstructorWithFormatter()
     */
    public function getFormatters()
    {
        return array(
            array(new \Clinner\ArgumentsFormatter\Customizable()),
            array(new \Clinner\ArgumentsFormatter\Dashed()),
            array(new \Clinner\ArgumentsFormatter\DoubleDashed()),
        );
    }
}