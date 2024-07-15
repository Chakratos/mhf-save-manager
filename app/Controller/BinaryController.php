<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\CompressionService;
use PhpBinaryReader\BinaryReader;

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
            'skinhist',
            'minidata',
            'scenariodata',
            'savefavoritequest',
        ];
    }
    
    public static function EditSavedata(Character $character)
    {
        $decompressed = CompressionService::Decompress($character->getSavedata());
        $saveDataMap = SaveDataController::GetSaveDataMap();
        var_dump(SaveDataController::GetCurrentEquip($saveDataMap, $decompressed));
    }
    
    public static function EditDecomyset(Character $character)
    {
        $decompressed = CompressionService::Decompress($character->getDecomyset());
        $saveDataMap = SaveDataController::GetSaveDataMap();
        $br = new BinaryReader($saveDataMap, $decompressed);
        var_dump(SaveDataController::GetCurrentEquip($decompressed));
    }
}
