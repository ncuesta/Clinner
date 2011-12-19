<?php

namespace Clinner\Command;

/**
 * Command Interface
 * Interface to be implemented by Commands.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface CommandInterface
{
    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return \Clinner\Command\CommandInterface This command, for a fluent API.
     */
    public function run($input = null);
}
