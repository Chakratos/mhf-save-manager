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
    
    protected static function numberConvertEndian($number, $byteSize)
    {
        $hexChars = $byteSize * 2;
        $data = dechex((float)$number);
        
        $data = str_pad($data, $hexChars, '0', STR_PAD_LEFT);
        
        $unpack = unpack("H*", strrev(pack("H*", $data)));
    
        return $unpack[1];
    }
    
    protected static function stringToHex($string)
    {
        $output = "";
        foreach (mb_str_split($string) as $char) {
            $char = self::uniord($char);
            if ($char > 255) {
                $char = self::numberConvertEndian($char,2);
            } else {
                $char = dechex($char);
            }
            $output .= sprintf("%02s",strtoupper($char));
        }
        
        return $output;
    }
    
    protected static function uniord($u) {
            $k = mb_convert_encoding($u, 'SJIS', 'UTF-8');
            $k1 = ord(substr($k, 0, 1));
            $k2 = ord(substr($k, 1, 1));
            return $k2 * 256 + $k1;
        }
}
