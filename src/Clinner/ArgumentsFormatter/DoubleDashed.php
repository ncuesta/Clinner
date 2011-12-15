<?php

namespace Clinner\ArgumentsFormatter;

use Clinner\ArgumentsFormatter\Customizable;


/**
 * DoubleDashed Arguments Formatter
 * Formats arguments in a `--name=value` pattern.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class DoubleDashed extends Customizable
{
    /**
     * Get the prefix for this argument formatter: '--'.
     * This method disregards any previously-set prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return '--';
    }
    
    /**
     * Get the separator for this argument formatter: '='.
     * This method disregards any previously-set separator.
     *
     * @return string
     */
    public function getSeparator()
    {
        return '=';
    }
}