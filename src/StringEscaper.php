<?php

namespace Finder;

class StringEscaper
{
    /**
     * @var array
     */
    private static $_ESCAPING_MAP = [
        '.'  => 'xmWWQL46SfV2pRBjc8cr',
        '+'  => '4Wd1YEljNHJp0ApwZZS9',
        '*'  => 'O5rkGE3iVyhVefWBK3rd',
        '?'  => '77xYE38w4WYffIq4tkOb',
        '['  => 'gGKnUIwXRQB72Xj7f3qR',
        '^'  => 'wRG56d9Nku2Y74IbzrLg',
        ']'  => 'QPss6pUfW1DjKbSYxQXH',
        '$'  => 'BZXxgvlaTVZXUEcC4Pfe',
        '('  => 'eL4Cz2AUkE2Mf21ZER0v',
        ')'  => 'XAK05tnZUdRLAmDhE1Np',
        '{'  => 'JTBnPVNekSfDkwUSObJE',
        '}'  => 'FFtntuSlKA0yFuRgZGyr',
        '='  => 'ijyxEcnNq2D394fT1c7H',
        '!'  => 'i5oQ8plOOQFBiJnlaEhg',
        '<'  => 'ZfqIi30MZQWkTqdsMo0h',
        '>'  => 'OeBJFBccd4wayBrCQiRI',
        '|'  => '4zpecTcPpqDrFbpl8Hfg',
        '€'  => '9eJb22Zs8ejjP3UTjvTz',
        '#'  => 'eXKg4mB7rc5jvtfshH2W',
        '`'  => 'ZAg3sjGmP6cCG6bXQ7lq',
        '\'' => '5hRgud0oe9ePWwScjYNm',
        '%'  => '06yqtACvGtf2Gn1ZgrhL',
        '_'  => '9iPMsYcvVdMlLvNWTFLc',
        ';'  => 'LStXLBoe95c1J1W5uIfD',
        '~'  => 'SiZJsIxKuhIZehmthgIV',
        '"'  => '32V4wJiTUueGjh6Ob9HG',
        '\\' => 'Tj94JSrTwHEWTon0ki7V',
        '/'  => 'HY2RnpkEokEhwwPn5ao6',
        '@'  => 'UCFJwfvaGoBzoWw7pXum',
        ':'  => 'XvqDgYb2iGoBay5ymeI5',
        '-'  => 'K5qqZgbeuVNxsJCqzRsE',
        ','  => 'VN5CsylH1PYDuixqavg0',
        '&'  => 'xc1MGvW39dqgx5LE6Lnw',
        '£'  => 'tJdPyUJ9WmebmRUsUr2o',
        '¥'  => '6WcUBGKHwcM5pdyFtnf5',
        '¢'  => 'D9RPKaXHe9Km9R4ixqLI',
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
            // exclude = from escaping because is used by base64_encode function
            if ($match[0] !== '=') {
                $string = str_replace($match[0], base64_encode($match[0]), $string);
            }
        }

        return $string;
    }
}
