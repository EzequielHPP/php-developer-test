<?php

if (!function_exists('__')) {
    /**
     * Translator
     * Fetches a translation file with the translations for a given key
     *
     * @param string $translationKey
     * @param array $parameters
     * @return string
     */
    function __(string $translationKey, array $parameters = []): string
    {
        $sep = DIRECTORY_SEPARATOR;
        $fileLocation = __DIR__ . $sep . 'Config' . $sep . 'Translations_'.LANGUAGE.'.php';
        if(!file_exists($fileLocation)){
            $fileLocation = __DIR__ . $sep . 'Config' . $sep . 'Translations_en.php';
        }
        $translationList = require($fileLocation);

        // If translations doesn't exist, print out the Key
        if (!array_key_exists($translationKey, $translationList)) {
            return $translationKey;
        }

        $value = $translationList[$translationKey];
        foreach ($parameters as $parameter => $replacement) {
            $value = str_replace(':'.$parameter, $replacement, $value);
        }
        return $value;
    }
}
