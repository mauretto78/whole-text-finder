<?php

namespace Matecat\Finder\Tests;

use Matecat\Finder\WholeTextFinder;
use PHPUnit\Framework\TestCase;

class WholeTextFinderReplacementTest extends TestCase
{
    /**
     * @test
     */
    public function find_and_replace_test_on_greek_text()
    {
        $haystack = 'Δύο παράγοντες καθόρισαν την αντίληψή μου για την Τενεσί Ουίλιαμς και τη σκηνική παρουσίαση των κειμένων: η Maria Britneva και η Annette Saddik, αφετέρου.';
        $needle = 'και';
        $replacement = 'test';

        $expected = [
            'replacement' => 'Δύο παράγοντες καθόρισαν την αντίληψή μου για την Τενεσί Ουίλιαμς test τη σκηνική παρουσίαση των κειμένων: η Maria Britneva test η Annette Saddik, αφετέρου.',
            'occurrencies' => [
                [$needle, 122],
                [$needle, 213],
            ],
        ];
        $matches = WholeTextFinder::findAndReplace($haystack, $needle, $replacement);

        $this->assertEquals($expected, $matches);
    }

    /**
     * @test
     */
    public function find_and_replace_test_close_to_period_on_greek_text()
    {
        $haystack = 'Δύο παράγοντες καθόρισαν την αντίληψή μου για την Τενεσί Ουίλιαμς και τη σκηνική παρουσίαση των κειμένων: η Maria Britneva και η Annette Saddik, αφετέρου.';
        $needle = 'αφετέρου';
        $replacement = 'test';

        $expected = 'Δύο παράγοντες καθόρισαν την αντίληψή μου για την Τενεσί Ουίλιαμς και τη σκηνική παρουσίαση των κειμένων: η Maria Britneva και η Annette Saddik, test.';
        $matches = WholeTextFinder::findAndReplace($haystack, $needle, $replacement);

        $this->assertEquals($expected, $matches['replacement']);
    }

    /**
     * @test
     */
    public function find_and_replace_must_skip_matecat_ph_tags()
    {
        $haystack = "Si asistent për përvojën %{experience_name}, ti do të ndihmosh %{primary_host_name} ta përmirësojë edhe më shumë këtë përvojë.";
        $needle = 'host';
        $replacement = 'test';

        $expected = $haystack;
        $matches = WholeTextFinder::findAndReplace($haystack, $needle, $replacement);

        $this->assertEquals($expected, $matches['replacement']);
    }

    /**
     * @test
     */
    public function find_and_replace_must_skip_matecat_html_tags()
    {
        $haystack = "Beauty -> 2 Anti-Akne Gesichtsreiniger Schlankmacher <g id=\"2\">XXX</g>";
        $needle = 2;
        $replacement = "test";

        $expected = "Beauty -> test Anti-Akne Gesichtsreiniger Schlankmacher <g id=\"2\">XXX</g>";
        $matches = WholeTextFinder::findAndReplace($haystack, $needle, $replacement);

        $this->assertEquals($expected, $matches['replacement']);
    }
}
