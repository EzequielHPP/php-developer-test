<?php


namespace App\Helpers;


class DomConverter
{
    /**
     * Convert given Dom child into paragraph object
     * @param $child
     * @return array
     */
    public static function convertParagraph($child): array
    {
        return self::appendStandardAttributes('paragraph', $child);
    }
    /**
     * Convert given Dom child into break line object
     * @param $child
     * @return array
     */
    public static function convertBreakline($child): array
    {
        return self::appendStandardAttributes('break', $child);
    }

    /**
     * Convert given Dom child into  span object
     * @param $child
     * @return array
     */
    public static function convertText($child): array
    {
        return self::appendStandardAttributes('text', $child);
    }

    /**
     * Convert given Dom child into a header object
     *
     * @param $child
     * @return array
     */
    public static function convertHeaderTag($child): array
    {
        $letters = [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six'
        ];
        $fullName = 'heading' . $letters[(int)substr($child->getTag()->name(), -1)];
        return self::appendStandardAttributes($fullName, $child);
    }

    /**
     * Convert given Dom child into a bold object
     *
     * @param $child
     * @return array
     */
    public static function convertBoldTag($child): array
    {
        return self::appendStandardAttributes('bold', $child);
    }

    /**
     * Convert given Dom child into a div object
     *
     * @param $child
     * @return array
     */
    public static function convertDivTag($child): array
    {
        return self::appendStandardAttributes('div', $child);
    }

    /**
     * Convert given Dom child into a Iframe object
     *
     * @param $child
     * @return array
     */
    public static function convertIframeTag($child): array
    {
        $attributes = [
            'src' => 'src',
            'frameborder' => 'frameborder',
            'height' => 'height',
            'width' => 'width'
        ];
        return self::appendStandardAttributes('iframe', $child, $attributes);
    }

    /**
     * Convert given Dom child into a image object
     *
     * @param $image
     * @return array
     */
    public static function convertImageTag($image): array
    {
        $output = [
            'type' => 'image'
        ];
        $attributes = [
            'src' => 'src',
            'alt' => 'altText',
            'height' => 'height',
            'width' => 'width',
            'title' => 'title',
        ];
        return self::appendStandardAttributes('image', $image, $attributes);
    }

    /**
     * Append class and style if present on the child
     *
     * @param string $type
     * @param $child
     * @return array
     */
    private static function appendStandardAttributes(string $type, $child, array $extraAttributes = []): array
    {
        $output = [
            'type' => $type,
            'content' => StringHelper::cleanHtml($child->innerHtml)
        ];
        $attributes = [
            'class' => 'class',
            'style' => 'style'
        ];
        if (!empty($extraAttributes)) {
            $attributes = array_merge($attributes, $extraAttributes);
        }
        self::checkAndAppendAttributes($attributes, $child, $output);
        return $output;
    }

    private static function checkAndAppendAttributes(array $list, $child, &$output): void
    {
        foreach ($list as $key => $attribute) {
            // clean content
            if (!empty($child->getAttribute($key))) {
                $output[$attribute] = $child->getAttribute($key);
            }
        }
    }
}
