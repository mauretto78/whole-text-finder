<?php

namespace Matecat\Finder\Helper;

class Replacer
{
    /**
     * This method replaces content avoiding to replace html content.
     *
     * Example:
     * $haystack = "Beauty -> 2 Anti-Akne Gesichtsreiniger Schlankmacher <g id=\"2\">XXX</g>";
     * $needle = 2;
     * $replacement = "test";
     *
     * $expected = "Beauty -> test Anti-Akne Gesichtsreiniger Schlankmacher <g id=\"2\">XXX</g>";
     *
     * @param $pattern
     * @param $replacement
     * @param $haystack
     *
     * @return string|string[]
     */
    public static function replace($pattern, $replacement, $haystack)
    {
        return preg_replace(self::getModifiedRegexPattern($pattern), $replacement, $haystack);
    }

    /**
     * Modifies regex pattern for avoiding replacement of html content
     *
     * @param $pattern
     *
     * @return string
     */
    private static function getModifiedRegexPattern($pattern)
    {
        $explode = explode('/', $pattern);

        return '/(\|\|\|\||<.*?>|%{.*?})(*SKIP)(*FAIL)|'.$explode[1].'/'.$explode[2];
    }
}
