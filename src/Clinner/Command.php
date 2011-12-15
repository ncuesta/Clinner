<?php

namespace Clinner;

use Clinner\ValueHolder;


/**
 * Command abstraction to be executed with a Runner.
 * A Command takes a name (the actual name of the command to be run) and
 * an optional set of arguments.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Command
{
    /**
     * Name of the command.
     *
     * @var string
     */
    private $_name;
    
    /**
     * Arguments array for the command.
     *
     * @var array
     */
    private $_args;
    
    /**
     * Create a new Command and return it.
     * Shorthand method for using chained API methods.
     *
     * @param  string The name of the command to create.
     *
     * @return Command
     */
    static public function create($name)
    {
        return new self($name);
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
     * Set the name for the command.
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
     * Run the command in the CLI, according to what's been specified
     * by the different options.
     *
     * @return Command This instance, for a fluent API.
     */
    public function run()
    {
        // @TBD
        // This method should capture output to both stdout and stderr
        
        return $this;
    }
}