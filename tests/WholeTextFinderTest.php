<?php

namespace Finder\Tests;

use Finder\StringEscaper;
use PHPUnit\Framework\TestCase;
use Finder\WholeTextFinder;

class WholeTextFinderTest extends TestCase
{
    /**
     * @test
     */
    public function search_in_texts()
    {
        $haystack  = "PHP é il linguaggio numero 1 del mondo.";

        $needle = "é";
        $matches = WholeTextFinder::find($haystack, $needle, true, true, true);
        $this->assertCount(1, $matches);

        $haystack  = "PHP PHP is the #1 web scripting PHP language of choice.";

        $needle = "php";
        $matches = WholeTextFinder::find($haystack, $needle);
        $this->assertCount(3, $matches);

        $needle = "php";
        $matches = WholeTextFinder::find($haystack, $needle, true, true, true);
        $this->assertCount(0, $matches);

        $needle = "#1";
        $matches = WholeTextFinder::find($haystack, $needle, true, true, true);
        $this->assertCount(1, $matches);

        $haystack  = "Lawful basis for processing including basis of legitimate interest";

        $needle = "including";
        $matches = WholeTextFinder::find($haystack, $needle, true, true, true);
        $this->assertCount(1, $matches);

        $haystack  = "To process and deliver your order including: (a) Manage payments, fees and charges (b) Collect and recover money owed to us";

        $needle = "including:";
        $matches = WholeTextFinder::find($haystack, $needle, true, true, true);
        $this->assertCount(1, $matches);
    }

    /**
     * @test
     */
    public function search_in_texts_with_html_entities()
    {
        $haystack  = "&lt;a href='##'/&gt;This is a string&lt;/a&gt; with HTML entities;&#13;&#13;They must be skipped!";

        $needle = "&";
        $matches = WholeTextFinder::find($haystack, $needle, true);
        $this->assertCount(0, $matches);

        $needle = ";";
        $matches = WholeTextFinder::find($haystack, $needle, true);
        $this->assertCount(1, $matches);

        $needle = "&lt;a";
        $matches = WholeTextFinder::find($haystack, $needle, false);
        $this->assertCount(1, $matches);

        $needle = "<a";
        $matches = WholeTextFinder::find($haystack, $needle, true);
        $this->assertCount(1, $matches);

        $needle = "<A";
        $matches = WholeTextFinder::find($haystack, $needle, true, false, true);
        $this->assertCount(0, $matches);

        $needle = "<a";
        $matches = WholeTextFinder::find($haystack, $needle, true, true);
        $this->assertCount(1, $matches);

        $haystack  = "&quot;This is a quotation&quot; - says the donkey.";

        $needle = "quot";
        $matches = WholeTextFinder::find($haystack, $needle, true);
        $this->assertCount(1, $matches);
        $matches = WholeTextFinder::find($haystack, $needle, true, true);
        $this->assertCount(0, $matches);

        $needle = ";";
        $matches = WholeTextFinder::find($haystack, $needle, true);
        $this->assertCount(0, $matches);

        $haystack  = "&quot;This is a quotation&quot; - says the donkey.";

        $needle = "&quot;";
        $matches = WholeTextFinder::find($haystack, $needle, false);
        $this->assertCount(2, $matches);
    }

    /**
     * @test
     */
    public function search_in_texts_with_japanese_ideograms()
    {
        $haystack = '「ハッスルの日」開催について';
        $needle = "ハッスルの日";

        $matches = WholeTextFinder::find($haystack, $needle, true, true);
        $this->assertCount(1, $matches);

        $needle = "開催について";

        $matches = WholeTextFinder::find($haystack, $needle, true, true);
        $this->assertCount(1, $matches);
    }

    /**
     * @test
     */
    public function search_in_texts_with_arabic_words()
    {
        $haystack = '. سعدت بلقائك.';
        $needle = ". سعدت";

        $matches = WholeTextFinder::find($haystack, $needle, true, true);
        $this->assertCount(1, $matches);
    }
}
