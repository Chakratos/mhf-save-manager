<?php


namespace MHFSaveManager\Controller;


abstract class AbstractSaveController
{
    protected static function writeToFile($saveData, string $hexOffset, string $hexValue)
    {
        $handle = $saveData;
        $hexValue = strlen($hexValue) == 1 ? '0'.$hexValue : $hexValue;
        if (!is_resource($saveData)) {
            $handle = fopen('php://memory', 'br+');
            fwrite($handle, $saveData);
        }
        
        fseek($handle, hexdec($hexOffset));
        fwrite($handle, hex2bin($hexValue));
        rewind($handle);
    
        return $handle;
    }
    
    protected static function numberConvertEndian($number)
    {
        $data = dechex((float)$number);
    
        if (strlen($data) <= 2) {
            return $number;
        }
    
        $unpack = unpack("H*", strrev(pack("H*", $data)));
    
        return $unpack[1];
    }
    
    protected static function stringToHex($string)
    {
        return implode("",array_map(fn($x) => sprintf("%02s",strtoupper(dechex(ord($x)))),str_split($string)));
    }
}
