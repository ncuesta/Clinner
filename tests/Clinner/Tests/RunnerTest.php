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
        $commandMock = $this->getMockBuilder('\\Clinner\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('run'))
            ->getMock();
        $commandMock->expects($this->once())
            ->method('run');
        
        $runner = new Runner();
        $runner->run($commandMock);
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