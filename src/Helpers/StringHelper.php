<?php


namespace App\Helpers;


class StringHelper
{

    /**
     * Trim and replace new lines with <br>
     *
     * @param string $html
     * @return string
     */
    public static function cleanHtml(string $html): string
    {
        $html = trim($html);
        $html = preg_replace('~\R~', '<br />', $html);
        $html = str_replace('<br /><br />', '<br />', $html);

        return $html;
    }
}
