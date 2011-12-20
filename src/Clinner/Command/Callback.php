<?php

namespace Clinner\Command;

use Clinner\Command\CommandInterface;


/**
 * Callback class.
 * This is a command abstraction which actually delegates the execution logic
 * to a callback function.
 * The function will be invoked with an input string argument, and is expected
 * to return an integer value representing the exit code for the command:
 *
 * <code>
 *  // @param  string|null $input The input for the string.
 *  // @return int The exit code for the command.
 * function callback(string $input);
 * </code>
 *
 * Any output generated to stdout will be buffered as the command's output.
 *
 * Usage examples:
 *
 * <code>
 *     // Get all the users in the system whose username contains at least one 'a'
 *     $systemUsers = Command::create('cat', array('/etc/passwd'))
 *         ->pipe(
 *             Command::create('grep', array('-v' => '^#'), array('delimiter' => ' '))
 *                 ->pipe(
 *                     Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => ''))
 *                         ->pipe($callbackCommand)
 *                 )
 *         )
 *         ->run()
 *         ->getOutputAsArray("\n");
 * </code>
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Callback implements CommandInterface
{
    /**
     * Exit code for this command.
     *
     * @var int
     */
    private $_exitCode;

    /**
     * Output for this command.
     *
     * @var string
     */
    private $_output;

    /**
     * Callback function/method that will be invoked when command is run.
     *
     * @var \Closure
     */
    private $_callback;

    /**
     * Constructor.
     *
     * @param \Closure $callback The callback function.
     */
    public function __construct($callback)
    {
        $this->setCallback($callback);
    }

    /**
     * Get the callback function for this command.
     *
     * @return \Closure
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Set the callback function for this command.
     *
     * @param  \Closure $callback The callback function.
     *
     * @return \Clinner\Command\Callback This instance, for a fluent API.
     */
    public function setCallback($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return \Clinner\Command\CommandInterface This command, for a fluent API.
     */
    public function run($input = null)
    {
        $callback = $this->getCallback();

        ob_start();

        $this->_exitCode = $callback($input);

        $this->_output = ob_get_contents();

        ob_end_clean();

        return $this;
    }

    /**
     * Get the exit code for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return int
     */
    public function getExitCode()
    {
        return $this->_exitCode;
    }

    /**
     * Get the output for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->_output;
    }
}
