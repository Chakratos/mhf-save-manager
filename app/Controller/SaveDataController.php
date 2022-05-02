<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Equip;
use MHFSaveManager\Model\Item;
use MHFSaveManager\Model\ItemPreset;
use PhpBinaryReader\BinaryReader;

class SaveDataController extends AbstractSaveController
{
    public static function GetGender(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("50"));
    
        return $br->readBytes(1) == "\x01" ? 'Male' : 'Female';
    }
    
    public static function GetName(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("58"));
        
        return hex2bin(explode('00', bin2hex($br->readBytes(12)))[0]);
    }
    
    public static function SetName(string $saveData, string $name)
    {
        if (strlen($name) > 12) {
            throw new \Exception('Name can only be 12 characters long!');
        }
        $nameHex = str_pad(self::stringToHex($name), 24, "0");
        return self::writeToFile($saveData, "58", $nameHex);
    }
    
    public static function GetZenny(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("b0"));
    
        return $br->readUInt32();
    }
    
    public static function SetZenny(string $saveData, $value)
    {
        $value = min($value, 9999999);
        return self::writeToFile($saveData, "b0", self::numberConvertEndian($value));
    }

    public static function GetGzenny(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("1FF64"));
    
        return $br->readUInt32();
    }
    
    public static function SetGzenny(string $saveData, $value)
    {
        $value = min($value, 9999999);
        return self::writeToFile($saveData, "1FF64", self::numberConvertEndian($value));
    }
    
    public static function GetEquipmentBox(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("120"));
        $equips = [];
        while(true) {
            $equip = new Equip($br->readBytes(16));
            if ($equip->getId() === "0000") {
                break;
            }
            $equips[] = $equip;
        }
    
        return $equips;
    }
    
    public static function GetItemBox(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("11a60"));
    
        $items = [];
        while(true) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                break;
            }
            $items[] = $item;
        }
        
        return $items;
    }
    
    public static function GetItemPouch(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("23E74"));
    
        $items = ['items' => [], 'ammo' => []];
        for ($i = 0; $i <= 20 ; $i++) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                continue;
            }
            $items['items'][] = $item;
        }
    
        for ($i = 0; $i <= 10 ; $i++) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                continue;
            }
            $items['ammo'][] = $item;
        }
        
        return $items;
    }
    
    public static function GetItemPresets(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $itemPresets = [];
        
        //getNames 20byte name
        $br->setPosition(hexdec("23F68"));
        for ($i = 0; $i <= 24; $i++) {
            $tmpName = hex2bin(explode('00', bin2hex($br->readBytes(20)))[0]);
            if ($tmpName == "") {
                continue;
            }
            
            $itemPresets[$i] = new ItemPreset($tmpName);
        }
        
        $itemPresetsItemsLocation = hexdec("24148");
        $itemPresetsQuantityLocation = hexdec("246E8");
        foreach(array_keys($itemPresets) as $itemPresetCount) {
            //getItems 2byte ID's
            $br->setPosition($itemPresetsItemsLocation + ((30 * 2) * $itemPresetCount));
            for ($itemCount = 0; $itemCount <= 30; $itemCount++) {
                $item = new Item($br->readBytes(2));
                if ($item->getId() === "0000") {
                    continue;
                }
                
                $itemPresets[$itemPresetCount]->addItem($item, $itemCount);
            }
            //getItemQuantity 1byte
            $br->setPosition($itemPresetsQuantityLocation + (30 * $itemPresetCount));
            for ($itemCount = 0; $itemCount <= 30; $itemCount++) {
                $quantity = hexdec(bin2hex($br->readBytes(1)));
                if ($quantity === "0") {
                    continue;
                }
        
                $itemPresets[$itemPresetCount]->setItemQuantity($itemCount, $quantity);
            }
        }
        
        return $itemPresets;
    }
    
    public static function GetCurrentEquip(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("1F604"));
        
        
        $tmpEquip = [];
        for ($i = 0; $i <= 5; $i++) {
            $equip = new Equip($br->readBytes(16));
            if ($equip->getId() === "0000") {
                //continue;
            }
            $tmpEquip[] = $equip;
        }
        
        return [$tmpEquip[0], $tmpEquip[2], $tmpEquip[3], $tmpEquip[4], $tmpEquip[5], $tmpEquip[1]]; //Sorting gear like it would be in game
    }
    
    public static function GetKeyquestflag($saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(hexdec("23D20"));
    
        return bin2hex($br->readBytes(8));
    }
    
    public static function SetKeyquestflag($saveData, string $hexValue)
    {
        if (strlen($hexValue) != 16) {
            throw new \Exception('Key Quest Flag needs to be 8 Bytes');
        }
        
        return self::writeToFile($saveData, "23D20", $hexValue);
    }
    
    public static function SetStylevouchers($saveData, $value)
    {
        return self::writeToFile($saveData, "20104", "030000F4");
    }
}
