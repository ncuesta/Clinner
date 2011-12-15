<?php

namespace Clinner\ArgumentsFormatter\Tests;

use Clinner\ArgumentsFormatter\Customizable;


/**
 * Customizable test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CustomizableTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorWithDefaults()
    {
        $customizable = new Customizable();
        
        $this->assertEquals(' ', $customizable->getPrefix());
        $this->assertEquals(' ', $customizable->getSeparator());
    }
    
    /**
     * @dataProvider getConstructorParams
     */
    public function testConstructorWithParams($prefix, $separator)
    {
        $customizable = new Customizable($prefix, $separator);
        
        $this->assertEquals($prefix, $customizable->getPrefix());
        $this->assertEquals($separator, $customizable->getSeparator());
    }
    
    /**
     * Data provider for testConstructorWihParams() and testGetFormatWithParams()
     */
    public function getConstructorParams()
    {
        return array(
            array('-', ' '),
            array('--', '='),
            array('=', '-'),
            array('- ', ' = '),
        );
    }
    
    public function testSetPrefix()
    {
        $customizable = new Customizable();
        
        $customizable->setPrefix('-');
        $this->assertEquals('-', $customizable->getPrefix());
    }

    public function testSetSeparator()
    {
        $customizable = new Customizable();
        
        $customizable->setSeparator('=');
        $this->assertEquals('=', $customizable->getSeparator());
    }
    
    public function testGetFormatWithDefaults()
    {
        $customizable = new Customizable();
        
        $this->assertEquals(' %s %s', $customizable->getFormat());
    }
    
    /**
     * @dataProvider getConstructorParams
     */
    public function testGetFormatWithParams($prefix, $separator)
    {
        $customizable = new Customizable($prefix, $separator);
        
        $expected = "{$prefix}%s{$separator}%s";

        $this->assertEquals($expected, $customizable->getFormat());
    }
}