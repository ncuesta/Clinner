<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner;


/**
 * Compiler class.
 * This class compiles all Clinner's PHP code into a single PHAR file.
 *
 * @see http://php.net/manual/en/book.phar.php
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Compiler
{
    /**
     * The PHAR generator.
     *
     * @var \Phar
     */
    private $_phar;

    /**
     * Compiles Clinner's source code into a PHAR file named $target.
     *
     * @param string $target The name of the target PHAR file.
     */
    public function compile($target = 'clinner.phar')
    {
        $this->_phar = $this->_createPhar($target);

        $this
            ->_startBuffering()
            ->_addFiles()
            ->_stopBuffering();
    }

    /**
     * Create a new PHAR generator and return it.
     * Also, remove $target file if it already exists.
     *
     * @param  string $target Path to the target PHAR file.
     *
     * @return \Phar
     */
    protected function _createPhar($target)
    {
        if (file_exists($target)) {
            unlink($target);
        }

        $phar = new \Phar($target, 0, 'clinner.phar');

        $phar->setSignatureAlgorithm(\Phar::SHA1);

        $phar->setStub($phar->createDefaultStub('autoload.php'));

        return $phar;
    }

    /**
     * Start PHAR generator's buffering mechanism.
     *
     * @return \Clinner\Compiler This instance, for a fluent API.
     */
    protected function _startBuffering()
    {
        $this->_phar->startBuffering();

        return $this;
    }

    /**
     * Stop PHAR generator's buffering mechanism.
     *
     * @return \Clinner\Compiler This instance, for a fluent API.
     */
    protected function _stopBuffering()
    {
        $this->_phar->stopBuffering();

        return $this;
    }

    /**
     * Add all the required files to the PHAR generator.
     *
     * @return \Clinner\Compiler This instance, for a fluent API.
     */
    protected function _addFiles()
    {
        $this
            ->_addFile(new \SplFileInfo(__DIR__ . '/../../LICENSE'), false)
            ->_addFile(new \SplFileInfo(__DIR__ . '/../../autoload.php'))
            ->_addFile(new \SplFileInfo(__DIR__ . '/ValueHolder.php'))
            ->_addFile(new \SplFileInfo(__DIR__ . '/Command/CommandInterface.php'))
            ->_addFile(new \SplFileInfo(__DIR__ . '/Command/Command.php'))
            ->_addFile(new \SplFileInfo(__DIR__ . '/Command/Callback.php'))
            ->_addfile(new \SplFileInfo(__DIR__ . '/../../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php'));

        return $this;
    }

    /**
     * Add a single file to the PHAR generator.
     *
     * @param  \SplFileInfo $file           File to add.
     * @param  bool         $removeComments Whether comments should be removed from source.
     *
     * @return \Clinner\Compiler This instance, for a fluent API.
     */
    protected function _addFile(\SplFileInfo $file, $removeComments = true)
    {
        $path = str_replace(
            dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR,
            '',
            $file->getRealPath()
        );
        $content = file_get_contents($file);

        if ($removeComments) {
            $content = self::stripComments($content);
        }

        $this->_phar->addFromString($path, $content);

        return $this;
    }

    /**
     * Removes comments from a PHP source string.
     *
     * Taken from Silex framework's Compiler::stripComments().
     *
     * @see http://silex.sensiolabs.org
     *
     * (c) Fabien Potencier <fabien@symfony.com>
     *
     * @param string $source A PHP string
     *
     * @return string The PHP string with the comments removed
     */
    static public function stripComments($source)
    {
        if (!function_exists('token_get_all')) {
            return $source;
        }

        $output = '';

        foreach (token_get_all($source) as $token) {
            if (is_string($token)) {
                $output .= $token;
            } elseif (in_array($token[0], array(T_COMMENT, T_DOC_COMMENT))) {
                $output .= str_repeat("\n", substr_count($token[1], "\n"));
            } else {
                $output .= $token[1];
            }
        }

        return $output;
    }
}