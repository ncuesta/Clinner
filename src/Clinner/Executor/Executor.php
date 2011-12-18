<?php

namespace Clinner\Executor;

use Clinner\Executor\Base;


/**
 * Executor a.k.a. Verbose executor
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Executor extends Base
{
    /**
     * Actually execute the current command and return the exit code.
     * Current command is available via getCurrentCommand()
     *
     * @return int The exit code for the current command.
     */
    protected function _execute($input = null)
    {
        passthru($this->getCurrentCommand(), $exitCode);

        return $exitCode;
    }

    /**
     * Hook for pre-execution preparation.
     */
    protected function _preExecute()
    {
        // Do nothing
    }

    /**
     * Hook for post-execution clean up.
     */
    protected function _postExecute()
    {
        // Do nothing
    }
}