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
     * @param $string
     *
     * @return string
     */
    public static function stripTags($string)
    {
        $tags = [
            'a',
            'abbr',
            'acronym',
            'address',
            'applet',
            'area',
            'article',
            'aside',
            'audio',
            'b',
            'base',
            'basefont',
            'bdi',
            'bdo',
            'big',
            'blockquote',
            'body',
            'br',
            'button',
            'bx',
            'canvas',
            'caption',
            'center',
            'cite',
            'code',
            'colgroup',
            'data',
            'datalist',
            'dd',
            'del',
            'details',
            'dfn',
            'dialog',
            'dir',
            'div',
            'dl',
            'dt',
            'embed',
            'ex',
            'fieldset',
            'figcaption',
            'figure',
            'font',
            'footer',
            'form',
            'frame',
            'frameset',
            'g',
            'h1',
            'head',
            'header',
            'hr',
            'html',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'kbd',
            'label',
            'legend',
            'li',
            'link',
            'main',
            'map',
            'mark',
            'meta',
            'meter',
            'nav',
            'noframes',
            'noscript',
            'object',
            'ol',
            'optgroup',
            'option',
            'output',
            'p',
            'param',
            'ph',
            'picture',
            'pre',
            'progress',
            'q',
            'rp',
            'rt',
            'ruby',
            's',
            'samp',
            'script',
            'section',
            'select',
            'small',
            'source',
            'span',
            'strong',
            'style',
            'sub',
            'summary',
            'sup',
            'svg',
            'table',
            'tbody',
            'td',
            'template',
            'textarea',
            'tfoot',
            'th',
            'thead',
            'time',
            'title',
            'tr',
            'track',
            'u',
            'ul',
            'var',
            'video',
            'wbr',
        ];

        foreach ($tags as $tag){
            $regex = '/<'.$tag.'>|<'.$tag.' (.*)>|<\/'.$tag.'>|<'.$tag.'\/>/sU';

            $string = preg_replace ($regex, ' ', $string);
            $string = trim(preg_replace('/ {2,}/', ' ', $string));
        }

        return $string;
    }

    /**
     * @param string $input
     *
     * @return bool
     */
    private static function isValidHtml($input)
    {



        $k = 333;
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