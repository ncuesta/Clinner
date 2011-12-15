<?php

namespace Clinner\ArgumentsFormatter\Tests;

use Clinner\ArgumentsFormatter\Base;


/**
 * Base test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getArguments
     */
    public function testFormat($arguments, $expected)
    {
        $base = new ConcreteBase();
        
        $got = $base->format($arguments);
        $this->assertEquals($expected, $got);
    }
    
    public function getArguments()
    {
        return array(
            array(array('a' => 1), 'a=1'),
            array(array('a' => 'some', 'b' => 'other', 'c'), 'a=some b=other c'),
            array(array(), ''),
            array(array('a' => true, 'b' => false), 'a=1 b='),
            array(array('a', 'b', 'c', 'e', 'd'), 'a b c e d'),
        );
    }
}

class ConcreteBase extends Base
{
    public function getFormat() { return '%s=%s'; }
}