<?php

namespace MHFSaveManager\Controller;

use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\ResponseService;

class CharacterController
{
    public static function Index()
    {
        include_once ROOT_DIR . '/app/Views/character-table.php';
    }
    
    public static function Edit()
    {
        include_once ROOT_DIR . '/app/Views/edit-character.php';
    }
    
    public static function Reset(Character $character)
    {
        $character->setIsNewCharacter(true);
        EM::getInstance()->flush();
        ResponseService::SendOk();
    }
    
    public static function ReplaceSavedata(Character $character)
    {
        $resource = fopen($_FILES["replace"]["tmp_name"], "r");
        if ($resource === false) {
            ResponseService::SendServerError();
        }
        $character->setSavedata($resource);
        EM::getInstance()->flush();
        ResponseService::SendOk();
    }
    
    public static function CreateBackup(Character $character)
    {
        $savePath = ROOT_DIR . '/storage/savedata/' . $character->getId();
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }
        
        $success = file_put_contents(sprintf('%s/%s_%s.bin', $savePath, date("Y-m-d_H-i-s"), $character->getLastLogin()), $character->getSavedata());
        if ($success) {
            ResponseService::SendOk();
        }
        
        ResponseService::SendServerError();
    }
}
