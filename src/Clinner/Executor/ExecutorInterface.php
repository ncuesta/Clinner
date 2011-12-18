<?php

namespace Clinner\Executor;

use Clinner\Command;

/**
 * ExecutorInterface
 * Interface to be implemented by any command executor.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface ExecutorInterface
{
    /**
     * Execute the command string $command which is assumed to contain
     * a valid and non-malicious command with their arguments.
     *
     * @param  string $command The command string to execute.
     * @param  string $input   (Optional) input string for $command.
     *
     * @return int The exit code for $command.
     */
    public function execute($command, $input = null);
}
