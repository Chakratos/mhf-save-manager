<?php

namespace MHFSaveManager\Controller;

use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\DirectoryService;
use MHFSaveManager\Service\ResponseService;

class CharacterController
{
    public static function Index()
    {
        include_once ROOT_DIR . '/app/Views/character-table.php';
    }
    
    public static function Edit(Character $character)
    {
        include_once ROOT_DIR . '/app/Views/edit-character.php';
    }
    
    public static function Reset(Character $character)
    {
        $character->setIsNewCharacter(!$character->isNewCharacter());
        EM::getInstance()->flush();
        ResponseService::SendOk();
    }
    
    public static function ReplaceSavedata(Character $character, string $binary)
    {
        if (!isset($_POST['replace'])) {
            ResponseService::SendServerError('No Backup selected!');
        }
        
        $path = sprintf('%s/storage/%s/%s/%s',ROOT_DIR, $binary, $character->getId(), $_POST['replace']);
        if (!file_exists($path)) {
            ResponseService::SendNotFound('Could not find selected backup!');
        }
        $resource = fopen($path, "r");
        $action = sprintf('set%s', ucfirst($binary));
        
        $character->$action($resource);
        EM::getInstance()->flush();
        ResponseService::SendOk();
    }
    
    public static function BackupAll(Character $character)
    {
        foreach (BinaryController::getBinaryTypes() as $binaryType) {
            self::CreateBackup($character, $binaryType);
        }
    }

    public static function CreateBackup(Character $character, string $binary)
    {
        $savePath = sprintf('%s/storage/%s',ROOT_DIR, $binary);
        if (!is_dir($savePath)) {
            ResponseService::SendNotFound();
        }
        
        $savePath .= '/' . $character->getId();
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }
        
        $binaryMethod = "get" . ucfirst($binary);
        $test = $character->$binaryMethod();
        $success = file_put_contents(sprintf('%s/%s_%s.bin', $savePath, date("Y-m-d_H-i-s"),
            $binary), $character->$binaryMethod());
        
        if (!$success) {
            return false;
        }
        
        return true;
    }
    
    public static function UploadSavedata(Character $character)
    {
        $savePath = sprintf('%s/storage/%s/%s',
            ROOT_DIR,
            $_POST['binaryName'],
            $character->getId()
        );
        
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }
        
        $tmp = explode('.', $_FILES['uploadBinary']['name']);
        if (strtolower(end($tmp)) !== 'bin') {
            ResponseService::SendServerError('Only .bin files are allowed!');
        }
        
        move_uploaded_file($_FILES["uploadBinary"]["tmp_name"], $savePath . '/' . $_FILES["uploadBinary"]["name"]);
        
        ResponseService::SendOk();
        
    }
    
    public static function GetBackups(Character $character): array
    {
        $binaries = BinaryController::getBinaryTypes();
        $storagePath = sprintf('%s/storage', ROOT_DIR);
        
        $BinaryBackupFiles = [];
        
        foreach ($binaries as $binary) {
            $BinaryBackupFiles[$binary] = [];
            $path = sprintf('%s/%s/%s', $storagePath, $binary, $character->getId());
            if (is_dir($path)) {
                $tmp = array_values(DirectoryService::ScanDirByModified($path));
                
                if (count($tmp) === 0) {
                    continue;
                }
                
                foreach ($tmp as $item) {
                    if (strpos($item, '.bin')) {
                        $BinaryBackupFiles[$binary][] = $item;
                    }
                }
            }
        }
        
        return $BinaryBackupFiles;
    }
}
