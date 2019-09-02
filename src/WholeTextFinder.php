<?php

namespace Finder;

class WholeTextFinder
{
    /**
     * @param string $originalHaystack
     * @param string $needle
     * @param bool   $skipHtmlEntities
     * @param bool   $exactMatch
     * @param bool   $caseSensitive
     *
     * @return array
     */
    public static function find( $originalHaystack, $needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false)
    {
        $pattern = self::getSearchPattern($needle, $skipHtmlEntities, $exactMatch, $caseSensitive);

        if ($skipHtmlEntities) {
            $originalHaystack = html_entity_decode($originalHaystack, ENT_COMPAT, 'UTF-8');
        }

        $haystack = ($exactMatch)  ? StringEscaper::escape($originalHaystack) : $originalHaystack;

        preg_match_all($pattern, $haystack, $matches, PREG_OFFSET_CAPTURE);

        return self::unescapeMatches($matches[0], $needle, $haystack);
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
        $pattern .= ($exactMatch) ? '\b' : '';
        $pattern .= ($exactMatch) ? StringEscaper::escape($needle) : $needle;
        $pattern .= ($exactMatch) ? '\b' : '';
        $pattern .= '/';
        $pattern .= (false === $caseSensitive) ? 'i' : '';
        $pattern .= ($skipHtmlEntities) ? 'u' : '';

        return $pattern;
    }

    /**
     * @param array  $matches
     * @param string $needle
     * @param string $haystack
     *
     * @return array
     */
    private static function unescapeMatches($matches, $needle, $haystack)
    {
        $unescapeMatches = [];

        foreach ($matches as $index => $match) {

            // calculate the position in the original string
            $position = $match[1];
            $substring = substr($haystack, 0, $position);
            $originalSubstring = StringEscaper::unescape($substring);

            $posDiff = mb_strlen($substring) - mb_strlen($originalSubstring);
            $originalPosition = ($position - $posDiff);

            $unescapeMatches[$index] = [
                $needle,
                $originalPosition,
            ];
        }

        return $unescapeMatches;
    }
}
