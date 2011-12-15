<?php

namespace Clinner;


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
     * Options for the command.
     *
     * @var array
     */
    private $_opts;
    
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
     * @param string $name The name of the command.
     * @param array  $args (Optional) arguments for this command.
     */
    public function __construct($name, array $args = array(), array $options = array())
    {
        $this->_name = $name;
        $this->_args = $args;
        $this->_opts = $opts;
    }
    
    /**
     * Basic (and protected) getter for options and/or arguments.
     * This method is given a $haystack to search in and the desired $needle,
     * along with an optional $default value to return if $needle doesn't exist.
     *
     * @param  array  $haystack The haystack to search in.
     * @param  string $needle   The needle to search for in $haystack.
     * @param  mixed  $default  (Optional) default value to return if $needle isn't set.
     *
     * @return mixed
     */
    protected function _basicGet(array $haystack, $needle, $default = null)
    {
        if (array_key_exists($name, $haystack))
        {
            return $haystack[$name];
        }
        
        return $default;
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
        return $this->_basicGet($this->_args, $name, $default);
    }
    
    /**
     * Get the value for option $name. If none has been set, return $default.
     *
     * @param  string $name    The name of the option.
     * @param  mixed  $default (Optional) default value.
     *
     * @return Command This instance, for a fluent API.
     */
    public function getOption($name, $default = null)
    {
        return $this->_basicGet($this->_opts, $name, $default);
    }

    /**
     * Set the value for argument $name to $value.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setArgument($name, $value)
    {
        $this->_args[$name] = $value;
        
        return $this;
    }
    
    /**
     * Set the value for option $name to $value.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setOption($name, $value)
    {
        $this->_opts[$name] = $value;
        
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
     * Get the arguments passed to the command.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->_args;
    }

    /**
     * Set (replace) the arguments for the command.
     *
     * @param  array $arguments The new arguments for this command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setArguments(array $arguments)
    {
        $this->_args = $arguments;
        
        return $this;
    }
    
    /**
     * Get the options passed to the command.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_opts;
    }

    /**
     * Set (replace) the options for the command.
     *
     * @param  array $options The new options for this command.
     *
     * @return Command This instance, for a fluent API.
     */
    public function setOptions(array $options)
    {
        $this->_opts = $options;
        
        return $this;
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