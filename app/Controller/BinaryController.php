<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\ItemsService;
use PhpBinaryReader\BinaryReader;
use PhpBinaryReader\Endian;

class BinaryController
{
    public static function getBinaryTypes(): array
    {
        return [
            'savedata',
            'decomyset',
            'hunternavi',
            'otomoairou',
            'partner',
            'platebox',
            'platedata',
            'platemyset',
            'rengokudata',
            'savemercenary',
        ];
    }
    
    public static function EditSavedata(Character $character)
    {
        $cur = "00";
        $savedata = $character->getSavedata();
        $br = new BinaryReader($savedata);
        $br->setPosition(hexdec("13"));

        $gender = $br->readUInt8() ? 'Female' : 'Male';
        printf('Gender: %s <br>', $gender);
        if ($gender == 'Female') {
            //Female extra byte 00
            $br->readBytes(1);
        }
        
        //Unknown Bytes 5-6
        while ($cur != 'ff') {
            $cur = bin2hex($br->readBytes(1));
        }
        
        $name = hex2bin(explode('00', bin2hex($br->readBytes(12)))[0]);
        printf('Name: %s <br>', $name);
        
        $br->readBytes(2);
        
        $money = unpack('v', $br->readBytes(3))[1];
        printf('Zenny: %sz <br>', $money);
        
        //Unknown Bytes
        $br->readBytes(41);
        
        //Equipment Box
        //Equipment = 3 byte ? & 2 byte ID
        /*
         * Weapon: 3byte? + 2byte ID + 1byte?
         * Armour: 3byte? +  2byte ID + 1byte  if > 0 then upgrade level elseif 00 = trennungszeichen
         */
        
        
        while ($cur != "ff00ff") {
            $cur = bin2hex($br->readBytes(3));
        }
        
        $cur = bin2hex($br->readBytes(1));
        
        while ($cur == "ff" || $cur == "00") {
            $cur = bin2hex($br->readBytes(1));
        }
        
        $items = [];
        while (true) {
            $itemID = strtoupper(bin2hex($br->readBytes(2)));
            $stackSizeExceeded = $br->readUInt8();
            $itemQuantity = 0;
            
            $tmpQuantity = bin2hex($br->readBytes(1));
            
            if ($stackSizeExceeded == 1 && $tmpQuantity == "00") {
                $br->setPosition($br->getPosition() - 2);
                $itemQuantity = $br->readUInt16();
            } else {
                $br->setPosition($br->getPosition() - 1);
                if ($stackSizeExceeded >= 3) {
                    $br->setPosition($br->getPosition() - 1);
                    $itemQuantity = $br->readUInt16();
                } else {
                    $itemQuantity = $br->readUInt16();
                }
            }
            
            
            
            printf('%s x %s | %s <br>', ItemsService::$items[$itemID], $itemQuantity, $stackSizeExceeded);
            $next = bin2hex($br->readBytes(1));
            
            
            
            if ($next == "00") {
                //random additional byte happened
                $next = bin2hex($br->readBytes(1));
            }
            if ($next == "05") {
                //Next Item will be different
            } elseif ($next == "04") {
                //Next Item will be same
            } elseif ($next == "0D") {
                //Next Item is empty slot?
                // if 15 then 2 slots space?
            }
            
            if ($next == "ff") {
                //If its end of Itembox
                break;
            }
        }

        var_dump(true);
    }
}
