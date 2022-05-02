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
    
    public static function Compress($data)
    {
        $outputString = "cmp\x2020110113\x20\x20\x20\x00";
        $br = new BinaryReader($data);
        while ($br->canReadBytes(1)) {
            $byte = $br->readBytes(1);
            if ($byte == "\x00") {
                $nullCount = 1;
                while ($br->canReadBytes(1)){
                    $byte = $br->readBytes(1);
                    if ($byte != "\x00") {
                        $outputString .= "\x00";
                        $outputString .= hex2bin(sprintf('%02x', $nullCount));
                        $outputString .= $byte;
                        $nullCount = 0;
                        break;
                    } elseif ($nullCount == 255) {
                        $outputString .= "\x00";
                        $outputString .= hex2bin(sprintf('%02x', $nullCount));
                        $nullCount = 0;
                    }
                    
                    $nullCount++;
                }
                if ($br->isEof() && $nullCount > 0) {
                    $outputString .= "\x00";
                    $outputString .= hex2bin(sprintf('%02x', $nullCount));
                }
            } else {
                $outputString .= $byte;
            }
        }
        return $outputString;
    }
}
