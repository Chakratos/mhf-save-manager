<?php

namespace MHFSaveManager\Service;


class PoogieOutfitService
{
    public static $localeArray = [];
    public static $fileName = 'PoogieOutfits.php';
    
    public static function getForLocale(): array
    {
        if (!empty(static::$localeArray)) {
            return static::$localeArray;
        }
    
        $names = require(LOCALE_DIR . static::$fileName);
        $fallbackNames = require(I18N_DIR . 'en_GB'. DIRECTORY_SEPARATOR . static::$fileName);
    
        if (!file_exists($names)) {
            $names = $fallbackNames;
        }
    
        foreach ($fallbackNames as $key => $fallbackName) {
            if (!isset($names[$key])) {
                $names[$key] = $fallbackName;
            }
        }
        
        static::$localeArray = $names;
        
        return static::$localeArray;
    }
}
