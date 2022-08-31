<?php

namespace MHFSaveManager\Service;


class UIService
{
    public static $localeArray = [];
    public static $fileName = 'UI.php';
    
    public static function getForLocale(): array
    {
        if (!empty(static::$localeArray)) {
            return static::$localeArray;
        }
        
        $names = LOCALE_DIR . static::$fileName;
        $fallbackNames = I18N_DIR . 'en_GB'. DIRECTORY_SEPARATOR . static::$fileName;
        
        if (!file_exists($names)) {
            $names = $fallbackNames;
        }
        
        $names = require($names);
        $fallbackNames = require($fallbackNames);
        
        foreach ($fallbackNames as $key => $fallbackName) {
            if (!isset($names[$key])) {
                $names[$key] = $fallbackName;
            }
        }
        
        static::$localeArray = $names;
        
        return static::$localeArray;
    }
}
