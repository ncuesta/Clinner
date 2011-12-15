<?php

namespace Clinner\ArgumentsFormatter\Tests;

use Clinner\ArgumentsFormatter\DoubleDashed;


/**
 * DoubleDashed test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class DoubleDashedTest extends \PHPUnit_Framework_TestCase
{
    public function testPrefixIsDoubleDash()
    {
        $doubleDashed = new DoubleDashed();
        
        $this->assertEquals('--', $doubleDashed->getPrefix());
    }
    
    public function testSeparatorIsEquals()
    {
        $doubleDashed = new DoubleDashed();
        
        $this->assertEquals('=', $doubleDashed->getSeparator());
    }
}