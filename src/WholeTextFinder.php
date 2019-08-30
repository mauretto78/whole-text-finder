<?php

namespace Finder;

class WholeTextFinder
{
    /**
     * @param string $haystack
     * @param string $needle
     * @param bool   $skipHtmlEntities
     * @param bool   $exactMatch
     * @param bool   $caseSensitive
     *
     * @return array
     */
    public static function find($haystack, $needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false)
    {
        $pattern = self::getSearchPattern($needle, $skipHtmlEntities, $exactMatch, $caseSensitive);

        if ($skipHtmlEntities) {
            $haystack = html_entity_decode($haystack, ENT_COMPAT, 'UTF-8');
        }

        preg_match_all($pattern, StringEscaper::escape($haystack), $matches, PREG_OFFSET_CAPTURE);

        return self::unescapeMatches($matches[0], $needle);
    }

    /**
     * @param string $needle
     * @param bool   $skipHtmlEntities
     * @param bool   $exactMatch
     * @param bool   $caseSensitive
     *
     * @return string
     */
    private static function getSearchPattern($needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false)
    {
        $pattern = '/';

        if ($exactMatch) {
            $pattern .= '\b';
        }

        $pattern .= StringEscaper::escape($needle);

        if ($exactMatch) {
            $pattern .= '\b';
        }

        $pattern .= '/';

        if (false === $caseSensitive) {
            $pattern .= 'i';
        }

        if ($skipHtmlEntities) {
            $pattern .= 'u';
        }

        return $pattern;
    }

    /**
     * @param array $matches
     *
     * @return array
     */
    private static function unescapeMatches($matches, $needle)
    {
        $unescapeMatches = [];

        foreach ($matches as $index => $match) {
            $unescapeMatches[$index] = [
                $needle,
                $match[1],
            ];
        }

        return $unescapeMatches;
    }
}
