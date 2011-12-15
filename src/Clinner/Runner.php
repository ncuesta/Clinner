<?php

namespace Clinner;

use Clinner\Command\CommandInterface;
use Clinner\ArgumentsFormatter\ArgumentsFormatterInterface;
use Clinner\Executor\ExecutorInterface;


class Runner
{
    /**
     * Arguments formatter.
     *
     * @var \Clinner\ArgumentsFormatter\ArgumentsFormatterInterface
     */
    private $_formatter;

    /**
     * Command executor.
     *
     * @var \Clinner\Executor\ExecutorInterface
     */
    private $_executor;

    /**
     * Constructor.
     *
     * @param \Clinner\ArgumentsFormatter\ArgumentsFormatterInterface $formatter (Optional) arguments formatter.
     * @param \Clinner\Executor\ExecutorInterface|null                $executor  (Optional) command executor.
     */
    public function __construct(ArgumentsFormatterInterface $formatter = null, ExecutorInterface $executor = null)
    {
        $this->_formatter = $formatter ?: $this->_getDefaultFormatter();
        $this->_executor = $executor ?: $this->_getDefaultExecutor();
    }
    
    /**
     * Get the formatter for this Runner's arguments.
     *
     * @return \Clinner\ArgumentsFormatter\ArgumentsFormatterInterface
     */
    public function getFormatter()
    {
        return $this->_formatter;
    }
    
    /**
     * Get a default formatter to use when none is provided.
     *
     * @return \Clinner\ArgumentsFormatter\DoubleDashed
     */
    protected function _getDefaultFormatter()
    {
        return new \Clinner\ArgumentsFormatter\DoubleDashed();
    }

    /**
     * Get the executor for this Runner's commands.
     *
     * @return \Clinner\Executor\ExecutorInterface
     */
    public function getExecutor()
    {
        return $this->_executor;
    }

    /**
     * Get a default executor to use when none is provided.
     *
     * @return \Clinner\Executor\Executor
     */
    protected function _getDefaultExecutor()
    {
        return new \Clinner\Executor\Executor();
    }
   
    /**
     * Run $command.
     *
     * @param  \Clinner\Command\CommandInterface $command The command to run.
     *
     * @return mixed
     */
    public function run(CommandInterface $command)
    {
        $commandString = sprintf(
            '%s %s',
            $command->getName(),
            $this->getFormatter()->format($command->getArgumentsArray())
        );

        return $this->getExecutor()->execute($commandString);
    }
}