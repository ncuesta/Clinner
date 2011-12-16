<?php

namespace Clinner\Command;

use Clinner\Command\CommandInterface;
use Clinner\ValueHolder;


/**
 * Base command class.
 *
 * Commands are an abstraction to be executed by a Runner.
 * A Command takes a name (the actual name of the command to be run) and
 * an optional set of arguments.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
abstract class Base implements CommandInterface
{
    /**
     * Name of the command.
     *
     * @var string
     */
    private $_name;
    
    /**
     * Arguments ValueHolder for the command.
     *
     * @var \Clinner\ValueHolder
     */
    private $_args;

    /**
     * Create a new command and return it.
     * Shorthand method for using chained API methods.
     *
     * @param  string The name of the command to create.
     *
     * @return \Clinner\Command\Base
     */
    static public function create($name)
    {
        $class = get_called_class();

        return new $class($name);
    }

    /**
     * Constructor.
     *
     * @param string                      $name The name of the command.
     * @param array|\Clinner\ValueHolder  $args (Optional) arguments for this command.
     */
    public function __construct($name, $args = array())
    {
        $this->_name = $name;
        $this->setArguments($args);
    }
    
    /**
     * Get the value for argument $name. If none has been set, return $default.
     *
     * @param  string $name    The name of the argument.
     * @param  mixed  $default (Optional) default value.
     *
     * @return mixed
     */
    public function getArgument($name, $default = null)
    {
        return $this->_args->get($name, $default);
    }

    /**
     * Set the value for argument $name to $value.
     *
     * @param  string $name  The name of the argument to set.
     * @param  mixed $value The value for the argument to set.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setArgument($name, $value)
    {
        $this->_args->set($name, $value);
        
        return $this;
    }
    
    /**
     * Get the name of the command.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the name of the command.
     *
     * @param  string $name The name of the command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setName($name)
    {
        $this->_name = $name;
        
        return $this;
    }
    
    /**
     * Get the arguments passed to the command as a ValueHolder.
     *
     * @return \Clinner\ValueHolder
     */
    public function getArguments()
    {
        return $this->_args;
    }

    /**
     * Set (replace) the arguments for the command.
     *
     * @param  array|\Clinner\ValueHolder $arguments The new arguments for this command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setArguments($arguments)
    {
        $this->_args = ValueHolder::create($arguments);
        
        return $this;
    }

    /**
     * Get the arguments passed to the command as an array.
     *
     * @return array
     */
    public function getArgumentsArray()
    {
        return $this->_args->getAll();
    }

    /**
     * Get the string representation for this command.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}