<?php

use MHFSaveManager\Controller\BinaryController;
use MHFSaveManager\Controller\CharacterController;
use MHFSaveManager\Controller\SaveDataController;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\CompressionService;
use MHFSaveManager\Service\ResponseService;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function() {
    CharacterController::Index();
});

SimpleRouter::get('/character/{id}/reset', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::Reset($character);
});

/*
 * ------------- EDIT ROUTES -------------
*/

SimpleRouter::get('/character/{id}/edit', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::Edit($character);
});

SimpleRouter::post('/character/{id}/edit/setname/{name}', function($id, $name) {
    /** @var Character $character */
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    CharacterController::WriteToSavedata($character, "SetName", $name);
    $character->setName($name);
    EM::getInstance()->flush();
    ResponseService::SendOk();
});

SimpleRouter::post('/character/{id}/edit/{property}/{value}', function($id, $property, $value) {
    /** @var Character $character */
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    CharacterController::WriteToSavedata($character, "Set" . ucfirst(substr($property, 3)), $value);
    ResponseService::SendOk();
});



/*SimpleRouter::get('/character/{id}/edit/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character && in_array($binary, BinaryController::getBinaryTypes())) {
        ResponseService::SendNotFound();
    }
    
    $action = 'Edit' . ucfirst(strtolower($binary));

    BinaryController::$action($character);
});*/

/*
 * ------------- BACKUP ROUTES -------------
*/

SimpleRouter::get('/character/{id}', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::Backup($character);
});

SimpleRouter::get('/character/{id}/decompress', function($id) {
    /** @var Character $character */
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    file_put_contents(sprintf('%s\\tmp\\%s.bin', ROOT_DIR, $id), CompressionService::Decompress($character->getSavedata()));
    
    ResponseService::SendOk();
});

SimpleRouter::get('/character/{id}/compress', function($id) {
    /** @var Character $character */
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    file_put_contents(sprintf('%s\\tmp\\compressed_%s.bin', ROOT_DIR, $id), CompressionService::Compress(CompressionService::Decompress($character->getSavedata())));
    
    ResponseService::SendOk();
});

SimpleRouter::post('/character/{id}/backup/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    if ($binary === "all") {
        CharacterController::BackupAll($character);
        exit;
    }
    
    if (CharacterController::CreateBackup($character, $binary)) {
        ResponseService::SendOk();
    }
    ResponseService::SendServerError();
});

SimpleRouter::post('/character/{id}/backupdecomp/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    if (CharacterController::CreateBackup($character, $binary, true)) {
        ResponseService::SendOk();
    }
    ResponseService::SendServerError();
});

SimpleRouter::get('/character/{id}/backup/{binary}/{backup_file}', function($id, $binary, $backup_file) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character ||
        !file_exists($path = sprintf('%s/storage/%s/%s/%s',ROOT_DIR, $binary, $character->getId(), $backup_file)))
    {
        ResponseService::SendNotFound();
    }
    
    ResponseService::SendDownload($path);
}, ['defaultParameterRegex' => '[\w\-\.]+']);

SimpleRouter::post('/character/{id}/replace/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::ReplaceSavedata($character, $binary);
});

SimpleRouter::post('/character/{id}/compressentry/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::EntryCompression($character, $binary, $_POST['decomp']);
});

SimpleRouter::post('/character/{id}/upload', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);

    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    if ($_FILES["uploadBinary"]["error"] != UPLOAD_ERR_OK) {
        ResponseService::SendServerError();
    }
    
    /** @var Character $character */
    CharacterController::UploadSavedata($character);
});
