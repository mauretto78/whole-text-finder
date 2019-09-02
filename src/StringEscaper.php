<?php

namespace Finder;

class StringEscaper
{
    /**
     * Used to identify the base64 encoded strings
     *
     * @var string
     */
    private static $_ESCAPE_DELIMITER = 'q5F5GptN';

    /**
     * Used to encode base64 converted chars
     * Ex: "@" is encoded as QA==, and then QA== is encoded to QA4g5nlcR44g5nlcR4
     *
     * @var array
     */
    private static $_ESCAPING_MAP = [
        '+'  => 'wMTsdbMQ',
        '='  => '4g5nlcR4',
    ];

    /**
     * @param string $string
     *
     * @return string
     */
    public static function escape($string)
    {
        return str_replace(array_keys(self::$_ESCAPING_MAP), self::$_ESCAPING_MAP, self::escapeNotBoundaries($string));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private static function escapeNotBoundaries($string)
    {
        preg_match_all('/[^\w+\s「」]/u', $string, $notBoundaryMatches, PREG_OFFSET_CAPTURE);

        foreach ($notBoundaryMatches[0] as $match) {
            // exclude "=" from base64 escaping
            if ($match[0] !== '=') {
                $string = str_replace($match[0], self::$_ESCAPE_DELIMITER.base64_encode($match[0]).self::$_ESCAPE_DELIMITER, $string);
            }
        }

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function unescape($string)
    {
        $firstUnescapedString = str_replace(self::$_ESCAPING_MAP, array_keys(self::$_ESCAPING_MAP), $string);

        preg_match_all("/".self::$_ESCAPE_DELIMITER."(.*?)".self::$_ESCAPE_DELIMITER."/u", $firstUnescapedString, $matches, PREG_OFFSET_CAPTURE);

        //
        // $unescapeMap will be used to decode the string to original value.
        //
        // Example:
        //
        // array(3) {
        //   ["xyzQA==xyz"]=>
        //   string(1) "@"
        //   ["xyzIw==xyz"]=>
        //   string(1) "#"
        //   ["xyzLg==xyz"]=>
        //   string(1) "."
        // }
        //
        $unescapeMap = [];

        foreach ($matches[0] as $k => $item) {
            $unescapeMap[$item[0]] = base64_decode($matches[1][$k][0]);
        }

        return str_replace(array_keys($unescapeMap), $unescapeMap, $firstUnescapedString);
    }
}
