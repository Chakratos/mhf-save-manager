<?php


namespace MHFSaveManager\Controller;


use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\CompressionService;

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
        var_dump(SaveDataController::GetCurrentEquip($decompressed));
    }
}
