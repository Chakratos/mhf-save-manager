<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Character;
use MHFSaveManager\Model\Equip;
use MHFSaveManager\Model\Item;
use MHFSaveManager\Service\CompressionService;
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
        $decompressed = CompressionService::Decompress($character->getSavedata());
        
        
        $br = new BinaryReader($decompressed);
        $br->setPosition(hexdec("50"));
        
        $gender = $br->readBytes(1) == "\x01" ? 'Male' : 'Female';
        printf('Gender: %s <br>', $gender);

        $br->setPosition(hexdec("58"));
        $name = hex2bin(explode('00', bin2hex($br->readBytes(12)))[0]);
        printf('Name: %s <br>', $name);
        
        $br->setPosition(hexdec("b0"));
        
        $money = $br->readUInt32();
        printf('Zenny: %sz <br>', $money);
        
        
        $br->setPosition(hexdec("120"));
        $equips = [];
        while(true) {
            $equip = new Equip($br->readBytes(16));
            if ($equip->getId() === "0000") {
                break;
            }
            $equips[] = $equip;
        }
        foreach ($equips as $equip) {
            printf("%s <br>", $equip);
        }

        $br->setPosition(hexdec("11a60"));
        
        $items = [];
        while(true) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                break;
            }
            $items[] = $item;
        }
        foreach ($items as $item) {
            printf("%s <br>", $item);
        }
    }
}
