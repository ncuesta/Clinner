<?php

namespace Clinner;

use Clinner\Command;
use Clinner\ArgumentsFormatter\ArgumentsFormatterInterface;


class Runner
{
    /**
     * Arguments formatter.
     *
     * @var Clinner\ArgumentsFormatter\ArgumentsFormatterInterface
     */
    private $_formatter;
    
    /**
     * Constructor.
     *
     * @param Clinner\ArgumentsFormatter\ArgumentsFormatterInterface $formatter (Optional) arguments formatter.
     */
    public function __construct(ArgumentsFormatterInterface $formatter = null)
    {
        $this->_formatter = $formatter ?: $this->_getDefaultFormatter();
    }
    
    public function getFormatter()
    {
        return $this->_formatter;
    }
    
    /**
     * Get a default formatter to use when none is provided.
     *
     * @return Clinner\ArgumentsFormatter\DoubleDashed
     */
    protected function _getDefaultFormatter()
    {
        return new \Clinner\ArgumentsFormatter\DoubleDashed();
    }
   
    /**
     * Run $command.
     *
     * @param  Command $command The command to run.
     *
     * @return mixed
     */
    public function run(Command $command)
    {
        return $command->run();
    }
}