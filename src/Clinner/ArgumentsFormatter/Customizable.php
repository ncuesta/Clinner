<?php

namespace Clinner\ArgumentsFormatter;

use Clinner\ArgumentsFormatter\Base;


/**
 * Customizable Arguments Formatter
 * Formats arguments using any provided `prefix` and `separator` strings.
 *
 * For instance,
 *
 *  Prefix | Separator |    Output
 * -----------------------------------
 *     -   |           |  -key value
 * -----------------------------------
 *    --   |     =     |  --key=value
 * -----------------------------------
 *         |     =     |  key=value
 * -----------------------------------
 *
 * Both `prefix` and `separator` have their dedicated setters and they
 * default to ' ' (a blank space).
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Customizable extends Base
{
    protected $_prefix;
    protected $_separator;
    
    public function __construct($prefix = ' ', $separator = ' ')
    {
        $this->_prefix = $prefix;
        $this->_separator = $separator;
    }
    
    /**
     * Set the prefix for this argument formatter.
     *
     * @param  string $prefix The new prefix string.
     *
     * @return Customizable This instance, for a fluent API.
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        
        return $this;
    }
    
    /**
     * Set the separator for this argument formatter.
     *
     * @param  string $separator The new separator string.
     *
     * @return Customizable This instance, for a fluent API.
     */
    public function setSeparator($separator)
    {
        $this->_separator = $separator;
        
        return $this;
    }
    
    /**
     * Get the prefix for this argument formatter.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }
    
    /**
     * Get the separator for this argument formatter.
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->_separator;
    }
    
    /**
     * Get the format String to use in a sprintf() call to format the
     * argument name and value.
     *
     * @return string
     */
    public function getFormat()
    {
        return "{$this->getPrefix()}%s{$this->getSeparator()}%s";
    }
}