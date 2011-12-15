<?php

namespace Clinner\ArgumentsFormatter\Tests;

use Clinner\ArgumentsFormatter\Dashed;


/**
 * Dashed test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class DashedTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFormat()
    {
        $dashed = new Dashed();
        
        $this->assertStringStartsWith('-', $dashed->getFormat());
    }
}