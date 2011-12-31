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


/**
 * Command test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
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
}