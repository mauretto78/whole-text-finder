<?php

namespace Finder\Tests;

use Finder\StringEscaper;
use PHPUnit\Framework\TestCase;
use Finder\WholeTextFinder;
use SebastianBergmann\CodeCoverage\Report\PHP;

class StringEscaperTest extends TestCase
{
    /**
     * @test
     */
    public function escape_and_unescape_a_string()
    {
        $string  = "PHP é il @ linguaggio ggio #1 del mondo. 😀";
        $escaped = StringEscaper::escape($string);

        $this->assertEquals(StringEscaper::unescape($escaped), $string);
    }
}