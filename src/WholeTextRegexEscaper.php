<?php

namespace Matecat\Finder;

class WholeTextRegexEscaper
{
    /**
     * @param string $needle
     *
     * @return string
     */
    public static function obtain($needle)
    {
        $escapedNeedle = preg_quote($needle);
        $escapedNeedle = str_replace("/", "\/", $escapedNeedle);

        $splittedNeedle = mb_str_split($escapedNeedle);

        $first = '';
        for ($i=0; $i < count($splittedNeedle); $i++) {
            if (self::isBoundary($splittedNeedle[$i])) {
                $first = $i;
                break;
            }
        }

        $last = '';
        for ($i=(count($splittedNeedle)-1); $i >= 0; $i--) {
            if (self::isBoundary($splittedNeedle[$i])) {
                $last = $i;
                break;
            }
        }

        $final = '';

        foreach ($splittedNeedle as $index => $letter) {
            if ($index === $first) {
                $final .= "\\b";
            }

            $final .= $letter;

            if ($index === $last) {
                $final .= "\\b";
            }
        }

        return $final;
    }

    /**
     * @param string $letter
     *
     * @return bool
     */
    private static function isBoundary($letter)
    {
        return preg_match("/[A-Za-z0-9_]/", $letter);
    }
}
