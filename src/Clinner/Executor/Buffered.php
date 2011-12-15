<?php

namespace Clinner\Executor;

use Clinner\Executor\Executor;


/**
 * Buffered Executor a.k.a. Silent executor
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Buffered extends Executor
{
    private $_buffer;

    public function __construct($buffer)
    {
        $this->_buffer = $buffer;
    }

    /**
     * Hook for pre-execution preparation.
     */
    protected function _preExecute()
    {
        ob_start();
    }

    /**
     * Hook for post-execution clean up.
     */
    protected function _postExecute()
    {
        $this->_buffer = ob_get_contents();

        ob_end_clean();
    }
}