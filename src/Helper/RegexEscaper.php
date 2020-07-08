<?php

namespace Matecat\Finder\Helper;

class RegexEscaper
{
    /**
     * @param string $needle
     *
     * @return string
     */
    public static function escapeWholeTextPattern($needle)
    {
        $escapedNeedle = self::escapeRegularPattern($needle);
        $splittedNeedle = Strings::split($escapedNeedle);

        $final = '';

        foreach ($splittedNeedle as $index => $letter) {
            if ($index === self::getFirstBounduaryPosition($splittedNeedle)) {
                $final .= "\\b";
            }

            $final .= $letter;

            if ($index === self::getLastBounduaryPosition($splittedNeedle)) {
                $final .= "\\b";
            }
        }

        return $final;
    }

    /**
     * @param array $splittedNeedle
     *
     * @return int
     */
    private static function getFirstBounduaryPosition($splittedNeedle)
    {
        for ($i=0; $i < count($splittedNeedle); $i++) {
            if (self::isBoundary($splittedNeedle[$i])) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @param array $splittedNeedle
     *
     * @return int
     */
    private static function getLastBounduaryPosition($splittedNeedle)
    {
        for ($i=(count($splittedNeedle)-1); $i >= 0; $i--) {
            if (self::isBoundary($splittedNeedle[$i])) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * @param string $letter
     *
     * @return bool
     */
    private static function isBoundary($letter)
    {
        return (preg_match("/[\w]/iu", $letter) > 0) ? true : false;
    }

    /**
     * @param string $needle
     *
     * @return string
     */
    public static function escapeRegularPattern($needle)
    {
        $needle = preg_quote($needle);

        return str_replace("/", "\/", $needle);
    }
}
