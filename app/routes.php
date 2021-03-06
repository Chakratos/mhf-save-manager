<?php

use MHFSaveManager\Controller\BinaryController;
use MHFSaveManager\Controller\CharacterController;
use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\CompressionService;
use MHFSaveManager\Service\ResponseService;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function() {
    CharacterController::Index();
});

SimpleRouter::get('/character/{id}', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::Edit($character);
});

SimpleRouter::get('/character/{id}/edit/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character && in_array($binary, BinaryController::getBinaryTypes())) {
        ResponseService::SendNotFound();
    }
    
    $action = 'Edit' . ucfirst(strtolower($binary));
    /** @var Character $character */
    BinaryController::$action($character);
});

SimpleRouter::get('/character/{id}/reset', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::Reset($character);
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

SimpleRouter::get('/character/{id}/backup/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character ||
        !isset($_GET['backup_file']) ||
        !file_exists($path = sprintf('%s/storage/%s/%s/%s',ROOT_DIR, $binary, $character->getId(), $_GET['backup_file'])))
    {
        ResponseService::SendNotFound();
    }
    
    ResponseService::SendDownload($path);
});

SimpleRouter::post('/character/{id}/replace/{binary}', function($id, $binary) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    /** @var Character $character */
    CharacterController::ReplaceSavedata($character, $binary);
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
