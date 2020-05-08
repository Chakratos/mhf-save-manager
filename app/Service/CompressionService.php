<?php

namespace MHFSaveManager\Service;

use PhpBinaryReader\BinaryReader;

class CompressionService
{
    public static function Decompress($data)
    {
        $br = new BinaryReader($data);
        $header = $br->readBytes(16);
        if ($header != "cmp\x2020110113\x20\x20\x20\x00") {
            return fread($data, fstat($data)['size']);
        }
        
        $outputString = "";
        
        while ($br->canReadBytes(1)) {
            $byte = $br->readBytes(1);
            
            if ($byte == "\x00") {
                //bindec does not seem to work here
                $nullCount = hexdec(bin2hex($br->readBytes(1)));
                $outputString .= str_repeat("\x00",$nullCount);
            } else {
                $outputString .= $byte;
            }
        }
        
        return $outputString;
    }
}
