<?php

namespace Clinner\Executor;

use Clinner\Executor\ExecutorInterface;


/**
 * Base executor
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
abstract class Base implements ExecutorInterface
{
    /**
     * The current command in execution, if any.
     *
     * @var string
     */
    private $_command;

    /**
     * Execute the command string $command which is assumed to contain
     * a valid and non-malicious command with their arguments.
     *
     * @param  string $command The command string to execute.
     *
     * @return int The exit code for $command.
     */
    public function execute($command)
    {
        $this->_setCurrentCommand($command);

        // Allow any required setup prior to execution
        $this->_preExecute();

        // Actually execute the command
        $exitCode = $this->_execute();

        // Allow any tear down or clean up after the execution
        $this->_postExecute();

        $this->_unsetCurrentCommand();

        return $exitCode;
    }

    /**
     * Set the current command in execution to $command.
     *
     * @param string $command
     *
     * @return \Clinner\Executor\Base
     */
    protected function _setCurrentCommand($command)
    {
        $this->_command = $command;

        return $this;
    }

    /**
     * Get the current command in execution, if any.
     *
     * @return string
     */
    public function getCurrentCommand()
    {
        return $this->_command;
    }

    /**
     * Unset (remove) the current command in execution, if any.
     *
     * @return \Clinner\Executor\Base
     */
    protected function _unsetCurrentCommand()
    {
        $this->_setCurrentCommand(null);

        return $this;
    }

    /**
     * Actually execute the current command and return the exit code.
     * Current command is available via getCurrentCommand()
     *
     * @return int The exit code for the current command.
     */
    abstract protected function _execute();

    /**
     * Hook for pre-execution preparation.
     */
    abstract protected function _preExecute();

    /**
     * Hook for post-execution clean up.
     */
    abstract protected function _postExecute();
}