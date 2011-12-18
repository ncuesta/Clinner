<?php

namespace Clinner\Command;

use Clinner\Command\Base;


/**
 * Command abstraction to be executed with a Runner.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Command extends Base
{
    /**
     * Command executor.
     *
     * @var \Clinner\Executor\ExecutorInterface
     */
    private $_executor;

    /**
     * Piped command to redirect this command's output.
     *
     * @var \Clinner\Command\CommandInterface
     */
    private $_piped;

    /**
     * Pipe $command to this one.
     *
     * @param  \Clinner\Command\CommandInterface $command The command to pipe to this one.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function pipe(\Clinner\Command\CommandInterface $command)
    {
       $this->_piped = $command;

        return $this;
    }

    /**
     * Get the command piped to this one, if any.
     *
     * @return \Command\Command\CommandInterface
     */
    public function getPipedCommand()
    {
        return $this->_piped;
    }

    /**
     * Answer whether this command has another one piped to it.
     *
     * @return bool
     */
    public function hasPipe()
    {
        return null !== $this->_piped;
    }

    /**
     * Set this command's executor.
     * Note that if this command has a piped command to it, this will be ignored
     * in favor of a Buffered executor.
     *
     * @param \Clinner\Executor\ExecutorInterface $executor
     *
     * @return Command This instance, for a fluent API.
     */
    public function setExecutor(\Clinner\Executor\ExecutorInterface $executor)
    {
        $this->_executor = $executor;

        return $this;
    }

    /**
     * Get this command's executor.
     *
     * @return \Clinner\Executor\ExecutorInterface
     */
    public function getExecutor()
    {
        if ($this->hasPipe()) {
            return new \Clinner\Executor\Buffered();
        } else {
            return $this->_executor ?: new \Clinner\Executor\Executor();
        }
    }

    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return int The execution exit code.
     */
    public function run($input = null)
    {
        $exitCode = $this->getExecutor()->execute($this, $input);

        if ($this->hasPipe()) {
            $exitCode = $this->getPipedCommand()->run($this->getExecutor()->getBuffer());
        }

        return $exitCode;
    }
}