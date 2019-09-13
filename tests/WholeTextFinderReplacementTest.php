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
}
