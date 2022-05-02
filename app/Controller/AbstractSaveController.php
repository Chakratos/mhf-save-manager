<?php


namespace MHFSaveManager\Controller;


abstract class AbstractSaveController
{
    protected static function writeToFile($saveData, string $hexOffset, string $hexValue)
    {
        $handle = $saveData;
        
        if (!is_resource($saveData)) {
            $handle = fopen('php://memory', 'br+');
            fwrite($handle, $saveData);
        }
        
        fseek($handle, hexdec($hexOffset));
        fwrite($handle, hex2bin($hexValue));
        rewind($handle);
    
        return $handle;
    }
}
