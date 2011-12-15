<?php

namespace Clinner\ArgumentsFormatter;

use Clinner\ArgumentsFormatter\Base;


/**
 * Dashed Arguments Formatter
 * Formats arguments in a `-name=value` pattern.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Dashed extends Base
{
    /**
     * Get the format String to use in a sprintf() call to format the
     * argument name and value.
     *
     * @return string
     */
    public function getFormat()
    {
        return '-%s=%s';
    }
}