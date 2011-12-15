<?php

namespace Clinner\ArgumentsFormatter;


/**
 * Arguments Formatter Interface
 * Interface to be implemented by Arguments Formatters.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface ArgumentsFormatterInterface
{
    /**
     * Format $arguments and return a string representation for them.
     *
     * @param  array $arguments The arguments set.
     *
     * @return string
     */
    public function format(array $arguments);
}