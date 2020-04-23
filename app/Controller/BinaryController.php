<?php


namespace MHFSaveManager\Controller;


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
}
