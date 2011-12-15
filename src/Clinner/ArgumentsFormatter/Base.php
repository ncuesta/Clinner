<?php

namespace Clinner\ArgumentsFormatter;

use Clinner\ArgumentsFormatter\ArgumentsFormatterInterface;

/**
 * Base Arguments Formatter
 * This class provides basic logic for arguments formatting.
 * Subclasses of this file should only override the value of the `$_format`
 * attribute in order to set the format template use when formatting arguments.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
abstract class Base implements ArgumentsFormatterInterface
{
    /**
     * Format $arguments according to $options.
     *
     * @param  array $arguments The arguments set.
     *
     * @return string
     */
    public function format(array $arguments)
    {
        $output = array();
        
        foreach ($arguments as $key => $value) {
            $output[] = $this->_formatArgument($key, $value);
        }
        
        return implode(' ', $output);
    }
    
    /**
     * Format a single argument.
     * If $key is numeric, it is assumed that the argument is not named.
     *
     * @param  mixed $key   The key name for the argument.
     * @param  mixed $value The value of the argument.
     *
     * @return string
     */
    protected function _formatArgument($key, $value)
    {
        if (is_int($key)) {
            return strval($value);
        } else {
            return sprintf($this->getFormat(), $key, $value);
        }
    }
    
    /**
     * Get the format String to use in a sprintf() call to format the
     * argument name and value.
     *
     * @return string
     */
    abstract public function getFormat();
}