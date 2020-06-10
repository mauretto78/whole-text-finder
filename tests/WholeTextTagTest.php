<?php

namespace Matecat\Finder\Tests;

use Matecat\Finder\WholeTextRegexEscaper;
use Matecat\Finder\WholeTextTag;
use PHPUnit\Framework\TestCase;

class WholeTextTagTest extends TestCase
{
    /**
     * @test
     */
    public function extract_percent_tags()
    {
        $string = "Si asistent për përvojën %{experience_name}, ti do të ndihmosh %{primary_host_name} ta përmirësojë edhe më shumë këtë përvojë.";

        $extract = WholeTextTag::extract($string);
        $this->assertCount(1, $extract);

        foreach ($extract as $regex => $matches){
            $this->assertEquals($regex, '/%{\w*}/');
            $this->assertEquals([
                    '%{experience_name}',
                    '%{primary_host_name}',
            ], $matches);
        }
    }

    /**
     * @test
     */
    public function extract_g_tags()
    {
        $string = "Beauty -> 2 Anti-Akne Gesichtsreiniger Schlankmacher <g id=\"2\">XXX</g>";

        $extract = WholeTextTag::extract($string);
        $this->assertCount(1, $extract);

        foreach ($extract as $regex => $matches){
            $this->assertEquals($regex, '#<\s*?g\b[^>]*>(.*?)</g\b[^>]*>#s');
            $this->assertEquals([
                    '<g id="2">XXX</g>',
            ], $matches);
        }
    }

    /**
     * @test
     */
    public function extract_ph_tags()
    {
        $string = '<ph id="1"> {1} </ph> Batterie avec deux ports USB pour recharger les smartphones ou un ordinateur tablette (<ph id="2"> {2} </ph> A <ph id="3"> {3} </ph><ph id="4"> {4} </ph>) <ph id="5"> {5} </ph>';

        $extract = WholeTextTag::extract($string);
        $this->assertCount(1, $extract);

        foreach ($extract as $regex => $matches){
            $this->assertEquals($regex, '#<\s*?ph\b[^>]*>(.*?)</ph\b[^>]*>#s');
            $this->assertEquals([
                    '<ph id="1"> {1} </ph>',
                    '<ph id="2"> {2} </ph>',
                    '<ph id="3"> {3} </ph>',
                    '<ph id="4"> {4} </ph>',
                    '<ph id="5"> {5} </ph>',
            ], $matches);
        }
    }

    /**
     * @test
     */
    public function extract_smart_count_tags()
    {
        $string = '%{booking_guest_first_name} is going on your experience||||%{smart_count} guests are going on your experience';

        $extract = WholeTextTag::extract($string);

        $this->assertCount(2, $extract);
        $this->assertTrue(isset($extract['/\|\|\|\|/']));
        $this->assertTrue(isset($extract['/%{\w*}/']));
        $this->assertEquals([
            '%{booking_guest_first_name}',
            '%{smart_count}',
        ], $extract['/%{\w*}/']);
        $this->assertEquals([
            '||||',
        ], $extract['/\|\|\|\|/']);
    }
}




