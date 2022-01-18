<?php

namespace Matecat\Finder\Tests;

use Matecat\Finder\Helper\Strings;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    /**
     * @test
     */
    public function html_entity_decode()
    {
        $input  = "&apos; &lt;a href='##'/&gt;This is a string&lt;/a&gt; with HTML entities;&#13;&#13;They must be skipped!";
        $output = "' <a href='##'/>This is a string</a> with HTML entities;\r\rThey must be skipped!";

        $this->assertEquals(Strings::htmlEntityDecode($input), $output);
    }

    /**
     * @test
     */
    public function is_multibyte()
    {
        $string = "La casa e bella";
        $string2 = "La casa è bella";

        $this->assertFalse(Strings::isMultibyte($string));
        $this->assertTrue(Strings::isMultibyte($string2));
    }

    /**
     * @test
     */
    public function strip_tags()
    {
        $string = '[rxkRj$cPt<';
        $string3 = '<g id="123">Ciao</g>';
        $string6 = '4n||6a8v:E]J}(t&m';
        $string7 = '3pWi<\FLpbVB%@>Yy@.8';

        $this->assertEquals('[rxkRj$cPt<', Strings::stripTags($string));

        $this->assertEquals('Ciao', Strings::stripTags($string3));
        $this->assertEquals('4n||6a8v:E]J}(t&m', Strings::stripTags($string6));
        $this->assertEquals('3pWi<\FLpbVB%@>Yy@.8', Strings::stripTags($string7));
    }
}