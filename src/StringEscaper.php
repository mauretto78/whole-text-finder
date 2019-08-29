<?php

namespace Finder;

class StringEscaper
{
    /**
     * @var array
     */
    private static $_ESCAPING_MAP = [
        '.' => 'xmWWQL46SfV2pRBjc8cr',
        '+' => '4Wd1YEljNHJp0ApwZZS9',
        '*' => 'O5rkGE3iVyhVefWBK3rd',
        '?' => '77xYE38w4WYffIq4tkOb',
        '[' => 'gGKnUIwXRQB72Xj7f3qR',
        '^' => 'wRG56d9Nku2Y74IbzrLg',
        ']' => 'QPss6pUfW1DjKbSYxQXH',
        '$' => 'BZXxgvlaTVZXUEcC4Pfe',
        '(' => 'eL4Cz2AUkE2Mf21ZER0v',
        ')' => 'XAK05tnZUdRLAmDhE1Np',
        '{' => 'JTBnPVNekSfDkwUSObJE',
        '}' => 'FFtntuSlKA0yFuRgZGyr',
        '=' => 'ijyxEcnNq2D394fT1c7H',
        '!' => 'i5oQ8plOOQFBiJnlaEhg',
        '<' => 'ZfqIi30MZQWkTqdsMo0h',
        '>' => 'OeBJFBccd4wayBrCQiRI',
        '|' => '4zpecTcPpqDrFbpl8Hfg',
        '€' => '9eJb22Zs8ejjP3UTjvTz',
        '#' => 'eXKg4mB7rc5jvtfshH2W',
    ];

    /**
     * @param string $string
     *
     * @return string
     */
    public static function escape($string)
    {
        return str_replace(array_keys(self::$_ESCAPING_MAP), self::$_ESCAPING_MAP, $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function unescape($string)
    {
        return str_replace(array_values(self::$_ESCAPING_MAP), array_keys(self::$_ESCAPING_MAP), $string);
    }
}
