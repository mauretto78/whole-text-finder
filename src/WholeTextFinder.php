<?php

namespace Matecat\Finder;

class WholeTextFinder
{
    /**
     * @param string $haystack
     * @param string $needle
     * @param bool   $skipHtmlEntities
     * @param bool   $exactMatch
     * @param bool   $caseSensitive
     * @param bool   $preserveNbsps
     *
     * @return array
     */
    public static function find($haystack, $needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false, $preserveNbsps = false)
    {
        $pattern = self::getSearchPattern($needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps);
        $haystack = ($skipHtmlEntities) ? html_entity_decode($haystack, ENT_COMPAT, 'UTF-8') : $haystack;
        $haystack = (false === $preserveNbsps) ? self::cutNbsps($haystack) : $haystack;

        preg_match_all($pattern, $haystack, $matches, PREG_OFFSET_CAPTURE);

        return $matches[0];
    }


    /**
     * @param string $needle
     * @param bool   $skipHtmlEntities
     * @param bool   $exactMatch
     * @param bool   $caseSensitive
     * @param bool   $preserveNbsps
     *
     * @return string
     */
    private static function getSearchPattern($needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false, $preserveNbsps = false)
    {
        $needle = (false === $preserveNbsps) ? self::cutNbsps($needle) : $needle;

        $pattern = '/';
        $pattern .= ($exactMatch) ? WholeTextRegexEscaper::escapeWholeTextPattern($needle) : WholeTextRegexEscaper::escapeRegularPattern($needle);
        $pattern .= '/';
        $pattern .= (false === $caseSensitive) ? 'i' : '';
        $pattern .= ($skipHtmlEntities) ? 'u' : '';

        return $pattern;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private static function cutNbsps($string)
    {
        return str_replace(['&nbsp;', ' '], ' ', $string);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param string $replacement
     * @param bool $skipHtmlEntities
     * @param bool $exactMatch
     * @param bool $caseSensitive
     * @param bool $preserveNbsps
     *
     * @return array
     */
    public static function findAndReplace($haystack, $needle, $replacement, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false, $preserveNbsps = false)
    {
        $pattern = self::getSearchPattern($needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps);
        $haystack = ($skipHtmlEntities) ? html_entity_decode($haystack, ENT_COMPAT, 'UTF-8') : $haystack;
        $haystack = (false === $preserveNbsps) ? self::cutNbsps($haystack) : $haystack;

        $replacement = preg_replace($pattern, $replacement, $haystack);

        return [
            'replacement' => $replacement,
            'occurrencies' => self::find($haystack, $needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps),
        ];
    }
}
