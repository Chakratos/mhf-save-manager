<?php

use MHFSaveManager\Controller\CharacterController;
use MHFSaveManager\Database\EM;
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
    
    CharacterController::Reset($character);
});

SimpleRouter::post('/character/{id}/backup', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    CharacterController::CreateBackup($character);
});

SimpleRouter::post('/character/{id}/replace', function($id) {
    $character = EM::getInstance()->getRepository('MHF:Character')->find($id);
    if (!$character) {
        ResponseService::SendNotFound();
    }
    
    if ($_FILES["replace"]["error"] != UPLOAD_ERR_OK) {
        ResponseService::SendServerError();
    }
    
    CharacterController::ReplaceSavedata($character);
});
