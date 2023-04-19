<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Equip;
use MHFSaveManager\Model\Item;
use MHFSaveManager\Model\ItemPreset;
use PhpBinaryReader\BinaryReader;

class SaveDataController extends AbstractController
{
    public static function GetGender(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x50);
    
        return $br->readBytes(1) == "\x01" ? 'Male' : 'Female';
    }
    
    public static function GetName(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x58);
        
        return mb_convert_encoding(hex2bin(explode('00', bin2hex($br->readBytes(12)))[0]), 'UTF-8','SJIS');
    }
    
    public static function SetName(string $saveData, string $name)
    {
        $nameHex = str_pad(self::stringToHex($name), 24, "0");
        
        if (strlen($nameHex) > 24) {
            throw new \Exception('Name can only be 12 characters long!');
        }
        
        return self::writeToFile($saveData, "58", $nameHex);
    }
    
    public static function GetZenny(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0xb0);
    
        return $br->readUInt32();
    }
    
    public static function SetZenny(string $saveData, $value)
    {
        $value = min($value, 9999999);
        return self::writeToFile($saveData, "b0", self::numberConvertEndian($value, 4));
    }

    public static function GetGzenny(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x1FF64);
    
        return $br->readUInt32();
    }
    
    public static function SetGzenny(string $saveData, $value)
    {
        $value = min($value, 9999999);
        return self::writeToFile($saveData, "1FF64", self::numberConvertEndian($value, 4));
    }
    
    public static function GetCP(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x212E4);
        
        return $br->readUInt32();
    }
    
    public static function SetCP(string $saveData, $value)
    {
        $value = min($value, 9999999);
        return self::writeToFile($saveData, '212E4', self::numberConvertEndian($value, 4));
    }
    
    public static function GetEquipmentBox(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x120);
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
    
    public static function GetItembox(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x11a60);
    
        $items = [];
        $itemsToRead = defined('ITEMBOX_ITEMS_READ') ? ITEMBOX_ITEMS_READ : 4000;
        for($i = 0; $i < $itemsToRead; $i++) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                //continue;
            }
            $item->setSlot($i);
            $items[] = $item;
        }
        
        return $items;
    }
    
    public static function SetItemboxSlot($saveData, int $slot)
    {
        $firstItemStart = 0x11a60;
        $itemByteSize = 0x8;
        $offsetForItem = $slot * $itemByteSize + $firstItemStart;
        
        return self::writeToFile($saveData, dechex((float)$offsetForItem), sprintf("00000000%s%s", $_POST['item_id'], self::numberConvertEndian($_POST['item_quantity'], 2)));
    }
    
    public static function GetItemPouch(string $saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x23E74);
    
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
        $br->setPosition(0x23F68);
        for ($i = 0; $i <= 24; $i++) {
            $tmpName = hex2bin(explode('00', bin2hex($br->readBytes(20)))[0]);
            if ($tmpName == "") {
                continue;
            }
            
            $itemPresets[$i] = new ItemPreset($tmpName);
        }
        
        $itemPresetsItemsLocation = 0x24148;
        $itemPresetsQuantityLocation = 0x246E8;
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
        $br->setPosition(0x1F604);
        
        
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
        $br->setPosition(0x23D20);
    
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
    
    public static function GetDailyguild($saveData)
    {
        $br = new BinaryReader($saveData);
        $br->setPosition(0x21562);
    
        return bin2hex($br->readBytes(2));
    }
    
    public static function SetDailyguild($saveData, $value)
    {
        return self::writeToFile($saveData, "21562", "0000");
    }
}
