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
}