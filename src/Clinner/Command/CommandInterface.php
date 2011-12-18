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
     * Get the name of the command.
     *
     * @return string
     */
    public function getName();

    /**
     * Set the name of the command.
     *
     * @param  string $name The name of the command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setName($name);

    /**
     * Get the arguments passed to the command as a ValueHolder.
     *
     * @return \Clinner\ValueHolder
     */
    public function getArguments();

    /**
     * Set (replace) the arguments for the command.
     *
     * @param  array|\Clinner\ValueHolder $arguments The new arguments for this command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setArguments($arguments);

    /**
     * Get the arguments passed to the command as an array.
     *
     * @return array
     */
    public function getArgumentsArray();

    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return int This command's execution exit code.
     */
    public function run($input = null);
}
