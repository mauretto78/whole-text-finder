<?php

namespace Matecat\Finder\Helper;

class Strings
{
    /**
     * @param string $string
     *
     * @return string
     */
    public static function cutNbsps($string)
    {
        return str_replace(['&nbsp;', ' '], ' ', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function htmlEntityDecode($string)
    {
        return html_entity_decode($string, ENT_QUOTES|ENT_XHTML, 'UTF-8');
    }

    /**
     * This function strips selected tags from $string
     *
     * @param $string
     *
     * @return string
     */
    public static function stripTags($string)
    {
        $tags = self::tagsTobeStripped();

        foreach ($tags as $tag){
            $regex = '/<'.$tag.'>|<'.$tag.' (.*)>|<\/'.$tag.'>|<'.$tag.'\/>/sU';

            $string = preg_replace ($regex, ' ', $string);
            $string = trim(preg_replace('/ {2,}/', ' ', $string));
        }

        return $string;
    }

    /**
     * @return array
     */
    private static function tagsTobeStripped()
    {
        return [
            'g',
            'bx',
            'ex',
        ];
    }

    /**
     * @param string $string
     *
     * @return array|bool|string[]|null
     */
    public static function split($string)
    {
        return mb_str_split($string);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public static function token($length = 8)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    public static function isMultibyte($string)
    {
        return ((strlen($string) - mb_strlen($string)) > 0);
    }
}