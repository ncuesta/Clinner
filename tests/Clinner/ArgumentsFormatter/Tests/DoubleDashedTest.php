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
    public function testGetFormat()
    {
        $doubleDashed = new DoubleDashed();
        
        $this->assertStringStartsWith('--', $doubleDashed->getFormat());
    }
}