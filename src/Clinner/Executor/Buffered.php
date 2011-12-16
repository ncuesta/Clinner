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
    /**
     * Buffer for this executor.
     *
     * @var string
     */
    private $_buffer;

    /**
     * Hook for pre-execution preparation.
     */
    protected function _preExecute()
    {
        $this->_buffer = '';

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

    /**
     * Get the buffer.
     *
     * @return string
     */
    public function getBuffer()
    {
        return $this->_buffer;
    }
}