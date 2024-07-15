<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Equip;
use MHFSaveManager\Model\Item;
use MHFSaveManager\Model\ItemPreset;
use PhpBinaryReader\BinaryReader;

/**
 *
 */
class SaveDataController extends AbstractController
{
    /**
     * @return array mapping of the binary fields
     */
    public static function GetSaveDataMap() {
        $version = "ZZ";
        if (defined('FORWARD_5_MODE') and FORWARD_5_MODE) {
            $version = "FW_5";
        } else if (defined('VERSION')) {
            $version = VERSION;
        }
        $map = SAVEDATA_MAP_DIR . $version . '.php';
        $defaultMap = SAVEDATA_MAP_DIR . 'ZZ.php';
        if (!file_exists($map)) {
            $map = $defaultMap;
        }
    
        $map = require($map);
        $defaultMap = require($defaultMap);
        
        foreach ($defaultMap as $key => $value) {
            if (!isset($map[$key])) {
                $map[$key]['addr'] = 0;
            }
        }
        return $map;
    }

    /**
     * @param array $saveDataMap
     * @param string $saveData
     * @return string
     */
    public static function GetGender(array $saveDataMap, string $saveData): string
    {
        $addr = $saveDataMap['gender']['addr'];

        if ($addr === 0) {
            return '?';
        }
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
    
        return $br->readBytes(1) == "\x01" ? 'Male' : 'Female';
    }
    
    public static function GetName(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['name']['addr'];
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
        
        return mb_convert_encoding(hex2bin(explode('00', bin2hex($br->readBytes(12)))[0]), 'UTF-8','SJIS');
    }
    
    public static function SetName(array $saveDataMap, string $saveData, string $name)
    {
        $addr = $saveDataMap['name']['addr'];

        $nameHex = str_pad(self::stringToHex($name), 24, "0");
        
        if (strlen($nameHex) > 24) {
            throw new \Exception('Name can only be 12 characters long!');
        }
        
        return self::writeToFile($saveData, dechex($addr), $nameHex);
    }
    
    public static function GetZenny(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['zenny']['addr'];

        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
    
        return $br->readUInt32();
    }
    
    public static function SetZenny(array $saveDataMap, string $saveData, $value)
    {
        $addr = $saveDataMap['zenny']['addr'];

        $value = min($value, 9999999);
        return self::writeToFile($saveData, dechex($addr), self::numberConvertEndian($value, 4));
    }

    public static function GetGzenny(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['gzenny']['addr'];

        if ($addr === 0) {
            return 0;
        }
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
        return $br->readUInt32();
    }
    
    public static function SetGzenny(array $saveDataMap, string $saveData, $value)
    {
        $addr = $saveDataMap['gzenny']['addr'];

        if ($addr === 0) {
            return $saveData;
        }

        $value = min($value, 9999999);
        $addr = dechex($addr);
        return self::writeToFile($saveData, $addr, self::numberConvertEndian($value, 4));
    }
    
    public static function GetCP(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['cp']['addr'];

        if ($addr === 0) {
            return 0;
        }
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
        return $br->readUInt32();
    }
    
    public static function SetCP(array $saveDataMap, string $saveData, $value)
    {
        $addr = $saveDataMap['cp']['addr'];

        if ($addr === 0) {
            return $saveData;
        }
        
        $value = min($value, 9999999);
        $addr = dechex($addr);
        return self::writeToFile($saveData, $addr, self::numberConvertEndian($value, 4));
    }
    
    /**
     * @param array $saveDataMap
     * @param string $saveData
     * @return Equip[]
     */
    public static function GetEquipmentBox(array $saveDataMap, string $saveData): array
    {
        $addr = $saveDataMap['equip_box']['addr'];

        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
        
        $equips = [];
        $i = 0;
        while(true) {
            $i++;
            $equip = new Equip($br->readBytes(16));
            if ($equip->getId() === "0000") {
                break;
            }
            $equip->setSlot($i);
            $equips[] = $equip;
        }
    
        return $equips;
    }
    
    public static function GetItembox(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['item_box']['addr'];

        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
    
        $items = [];
        $itemsToRead = defined('ITEMBOX_ITEMS_READ') ? ITEMBOX_ITEMS_READ : 4000;
        for($i = 0; $i < $itemsToRead; $i++) {
            try {
                $item = new Item($br->readBytes(8));
            } catch (\Exception $e) {
                break;
            }
            
            if ($item->getId() === "0000") {
                //continue;
            }
            $item->setSlot($i);
            $items[] = $item;
        }
        
        return $items;
    }
    
    public static function SetItemboxSlot(array $saveDataMap, $saveData, int $slot)
    {
        $addr = $saveDataMap['item_box']['addr'];

        $firstItemStart = $addr;
        $itemByteSize = 0x8;
        $offsetForItem = $slot * $itemByteSize + $firstItemStart;
        
        return self::writeToFile($saveData, dechex((float)$offsetForItem), sprintf("00000000%s%s", $_POST['item_id'], self::numberConvertEndian($_POST['item_quantity'], 2)));
    }
    
    public static function GetItemPouch(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['item_pouch']['addr'];
        $addr_ammo = $saveDataMap['ammo_pouch']['addr'];

        $br = new BinaryReader($saveData);
    
        $items = ['items' => [], 'ammo' => []];
        if($addr === 0) {
            return $items;
        }
        $br->setPosition($addr);
        for ($i = 0; $i < 20 ; $i++) {

            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                continue;
            }
            $item->setSlot($i);
            $items['items'][] = $item;
        }
    
        if($addr_ammo === 0) {
            return $items;
        }
        $br->setPosition($addr_ammo);
        for ($i = 0; $i < 10 ; $i++) {
            $item = new Item($br->readBytes(8));
            if ($item->getId() === "0000") {
                continue;
            }
            $item->setSlot($i);
            $items['ammo'][] = $item;
        }
        
        return $items;
    }
    
    public static function GetItemPresets(array $saveDataMap, string $saveData)
    {
        $addr_name = $saveDataMap['item_preset_name']['addr'];
        $addr_item = $saveDataMap['item_preset_item']['addr'];
        $addr_qty = $saveDataMap['item_preset_qty']['addr'];

        $br = new BinaryReader($saveData);
        $itemPresets = [];
        
        if ($addr_item === 0) {
            return $itemPresets;
        }
        
        if ($addr_name === 0) {
            $itemPresets = array(new ItemPreset("Item Set 1"), 
                new ItemPreset("Item Set 2"), 
                new ItemPreset("Item Set 3"), 
                new ItemPreset("Item Set 4"));
        } else {
            //getNames 20byte name
            $br->setPosition($addr_name);
            for ($i = 0; $i <= 24; $i++) {
                $tmpName = hex2bin(explode('00', bin2hex($br->readBytes(20)))[0]);
                if ($tmpName == "") {
                    continue;
                }
                
                $itemPresets[$i] = new ItemPreset($tmpName);
            }
        }
        
        $itemPresetsItemsLocation = $addr_item;
        $itemPresetsQuantityLocation = $addr_qty;
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
    
    public static function GetCurrentEquip(array $saveDataMap, string $saveData)
    {
        $addr = $saveDataMap['current_equip']['addr'];
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
        
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
    
    public static function GetKeyquestflag(array $saveDataMap, $saveData)
    {
        $addr = $saveDataMap['keyquest_flags']['addr'];
        if ($addr === 0) {
            return 0;
        }
    
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
    
        return bin2hex($br->readBytes(8));
    }
    
    public static function SetKeyquestflag(array $saveDataMap, $saveData, string $hexValue)
    {
        $addr = $saveDataMap['keyquest_flags']['addr'];
        if ($addr === 0) {
            return $saveData;
        }
    
        if (strlen($hexValue) != 16) {
            throw new \Exception('Key Quest Flag needs to be 8 Bytes');
        }
        
        return self::writeToFile($saveData, dechex($addr), $hexValue);
    }
    
    public static function SetStylevouchers(array $saveDataMap, $saveData, $value)
    {
        $addr = $saveDataMap['style_vouchers']['addr'];
        if ($addr === 0) {
            return $saveData;
        }
        $val = $saveDataMap['style_vouchers']['val'];

        $addr = dechex($addr);
        $val = $val;
    
        return self::writeToFile($saveData, $addr, $val);
    }
    
    public static function GetDailyguild(array $saveDataMap, $saveData)
    {
        $addr = $saveDataMap['daily_guild']['addr'];
        if ($addr === 0) {
            return 0;
        }
    
        $br = new BinaryReader($saveData);
        $br->setPosition($addr);
    
        return bin2hex($br->readBytes(2));
    }
    
    public static function SetDailyguild(array $saveDataMap, $saveData, $value)
    {
        $addr = $saveDataMap['daily_guild']['addr'];
        if ($addr === 0) {
            return $saveData;
        }
    
        return self::writeToFile($saveData, dechex($addr), "0000");
    }
}
