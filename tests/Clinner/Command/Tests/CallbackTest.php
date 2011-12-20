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

use Clinner\Command\Callback;


/**
 * Callback test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $closure  = function() {};
        $callback = new Callback($closure);

        $this->assertAttributeSame($closure, '_callback', $callback);
    }

    public function testGetCallback()
    {
        $closure = function($a) {};
        $callback = new Callback($closure);

        $this->assertSame($closure, $callback->getCallback());
    }

    public function testSetCallback()
    {
        $closure1 = function() {};
        $closure2 = function($a) {
            echo $a;
        };

        $callback = new Callback($closure1);

        $callback->setCallback($closure2);

        $this->assertAttributeSame($closure2, '_callback', $callback);
    }

    public function testRun()
    {
        $closure = function($a) {
            echo 'Some nifty output.';

            return 0;
        };
        $callback = new Callback($closure);

        $callback->run();

        $this->assertAttributeEquals(0, '_exitCode', $callback);
        $this->assertAttributeEquals('Some nifty output.', '_output', $callback);
    }

    /**
     * @depends testRun
     */
    public function testGetExitCode()
    {
        $closure = function($a) {
            return 17;
        };
        $callback = new Callback($closure);

        // Exit code must be null before the command is run
        $this->assertNull($callback->getExitCode());

        $callback->run();

        // Exit code must be 17 after the command is run with the given $closure
        $this->assertEquals(17, $callback->getExitCode());
    }

    /**
     * @depends testRun
     */
    public function testGetOutput()
    {
        $closure = function($a) {
            echo 'Some nifty output';
        };
        $callback = new Callback($closure);

        // Output must be null before the command is run
        $this->assertNull($callback->getOutput());

        $callback->run();

        // Output must be a string after the command is run with the given $closure
        $this->assertEquals('Some nifty output', $callback->getOutput());
    }
}