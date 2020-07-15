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
     * @param string $string
     *
     * @return array|bool|string[]|null
     */
    public static function split($string)
    {
        return mb_str_split($string);
    }
}