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
            'skinhist'
        ];
    }
    
    public static function EditSavedata(Character $character)
    {
        $decompressed = CompressionService::Decompress($character->getSavedata());
        var_dump(SaveDataController::GetCurrentEquip($decompressed));
    }
    
    public static function EditDecomyset(Character $character)
    {
        $decompressed = CompressionService::Decompress($character->getDecomyset());
        $br = new BinaryReader($decompressed);
        var_dump(SaveDataController::GetCurrentEquip($decompressed));
    }
}
