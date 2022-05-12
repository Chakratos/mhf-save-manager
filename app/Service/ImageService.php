<?php


namespace MHFSaveManager\Service;


class ImageService
{
    public static function GetImageForItem($name)
    {
        $itemVariations = [
            ['Scale', 'Fin', 'Mantle',],
            ['Webbing',],
            ['Bone',],
            ['Claw', 'talon', 'Horn', 'Fang'],
            ['Hide', 'Pelt',],
            ['Tail',],
            ['Gem', 'Orb', 'Ruby', 'Jasper'],
            ['Fish', 'Tuna', 'Arowana'],
            ['Sphere',],
            ['Jewel',],
            ['Mane',],
            ['Whetstone',],
            ['Shroom'],
            ['Meat', 'Steak'],
            ['Shl',],
            ['Ore', 'Crystal', 'Stone'],
            ['Potion', 'Drink', 'Juice', 'Serum'],
            ['Trap',],
            ['Bug', 'Larva', 'Drome'],
            ['Husk', 'Nut', 'Berry'],
            ['Herb', 'Grass'],
            ['Tkt',],
            ['Normal', 'Pierce', 'Pellet', 'Clust', 'Crag', 'S lv', 'Water S', 'Dragon S', 'Thunder S', 'Flaming S', 'Freeze S', 'Demon S', 'Armor S'],
            ['Bomb', 'Barrel'],
            ['Sac',],
            ['Ball',],
            ['Deco',],
            ['Coin',],
            ['Coating',],
            ['Book',],
            ['Deco',],
        ];
        
        foreach ($itemVariations as $itemVariation) {
            foreach ($itemVariation as $value) {
                if (strpos(strtolower($name), strtolower($value)) !== false) {
                    return $itemVariation[0];
                }
            }
        }
        
        return 'Unk';
    }
}
