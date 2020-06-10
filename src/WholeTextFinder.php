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
        $patternAndHaystack = self::getPatternAndHaystack($haystack, $needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps);

        preg_match_all($patternAndHaystack['pattern'], $patternAndHaystack['haystack'], $matches, PREG_OFFSET_CAPTURE);

        return $matches[0];
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param bool $skipHtmlEntities
     * @param bool $exactMatch
     * @param bool $caseSensitive
     * @param bool $preserveNbsps
     *
     * @return array
     */
    private static function getPatternAndHaystack($haystack, $needle, $skipHtmlEntities = true, $exactMatch = false, $caseSensitive = false, $preserveNbsps = false)
    {
        $pattern = self::getSearchPattern($needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps);
        $haystack = ($skipHtmlEntities) ? html_entity_decode($haystack, ENT_COMPAT, 'UTF-8') : $haystack;
        $haystack = (false === $preserveNbsps) ? self::cutNbsps($haystack) : $haystack;

        return [
            'pattern' => $pattern,
            'haystack' => $haystack,
        ];
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
        $patternAndHaystack = self::getPatternAndHaystack($haystack, $needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps);

        $pattern = $patternAndHaystack['pattern'];
        $haystack = $patternAndHaystack['haystack'];

        $tags = WholeTextTag::extract($patternAndHaystack['haystack']);

        $haystack = self::replaceTagsWithPlaceholder($tags, $haystack);
        $replacement = preg_replace($pattern, $replacement, $haystack);
        $replacement = self::replacePlaceholderWithTags($tags, $replacement);

        return [
            'replacement' => $replacement,
            'occurrencies' => self::find($haystack, $needle, $skipHtmlEntities, $exactMatch, $caseSensitive, $preserveNbsps),
        ];
    }

    /**
     * @param array $tags
     * @param string $haystack
     *
     * @return string
     */
    private static function replaceTagsWithPlaceholder($tags, $haystack)
    {
        if (count($tags) > 0) {
            $counter = 0;
            foreach ($tags as $matches) {
                foreach ($matches as $match) {
                    $haystack = str_replace($match, self::getPlaceholder($counter), $haystack);
                    $counter++;
                }
            }
        }

        return $haystack;
    }

    /**
     * @param array $tags
     * @param string $replacement
     *
     * @return string
     */
    private static function replacePlaceholderWithTags($tags, $replacement)
    {
        if (count($tags) > 0) {
            $counter = 0;
            foreach ($tags as $matches) {
                foreach ($matches as $match) {
                    $replacement = str_replace(self::getPlaceholder($counter), $match, $replacement);
                    $counter++;
                }
            }
        }

        return $replacement;
    }

    /**
     * @param int $counter
     *
     * @return string
     */
    private static function getPlaceholder($counter)
    {
        return "{{{{XXXXXXXXXXX_".$counter."}}}}";
    }
}
