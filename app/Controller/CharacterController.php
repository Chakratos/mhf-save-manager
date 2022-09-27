<?php

namespace MHFSaveManager\Controller;

use MHFSaveManager\Database\EM;
use MHFSaveManager\Model\Character;
use MHFSaveManager\Service\CompressionService;
use MHFSaveManager\Service\DirectoryService;
use MHFSaveManager\Service\ItemsService;
use MHFSaveManager\Service\ResponseService;

class CharacterController
{
    public static function Index()
    {
        include_once ROOT_DIR . '/app/Views/character-table.php';
    }
    
    public static function Edit(Character $character)
    {
        $decompressed = CompressionService::Decompress($character->getSavedata());
        $currentGear = SaveDataController::GetCurrentEquip($decompressed);
        $name = SaveDataController::GetName($decompressed);
        $zenny = SaveDataController::GetZenny($decompressed);
        $gZenny = SaveDataController::GetGZenny($decompressed);
        $keyquestFlag = SaveDataController::GetKeyQuestFlag($decompressed);
        $itembox = SaveDataController::GetItembox($decompressed);
        $gcp = $character->getGcp();
        $npoints = $character->getNetcafePoints();
        $frontierPoints = $character->getFrontierPoints();
        $kouryou = $character->getKouryouPoint();
        $gachaTrial = $character->getGachaTrial();
        $gachaPrem = $character->getGachaPrem();
        
        include_once ROOT_DIR . '/app/Views/edit-character.php';
    }
    
    public static function WriteToSavedata(Character $character, string $function, $value)
    {
        $decompressed = CompressionService::Decompress($character->getSavedata());
        $savefile = SaveDataController::$function($decompressed, $value);
        $compressed = CompressionService::Compress($savefile);
        $handle = fopen('php://memory', 'br+');
        fwrite($handle, $compressed);
        rewind($handle);
        $character->setSavedata($handle);
        EM::getInstance()->flush();
    }
    
    public static function Backup(Character $character)
    {
        include_once ROOT_DIR . '/app/Views/backup-character.php';
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

    public static function CreateBackup(Character $character, string $binary, $decomp = false)
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
        $success = file_put_contents(sprintf('%s/%s%s_%s.bin', $savePath, $decomp ? "decompressed_" : "" ,date("Y-m-d_H-i-s"),
            $binary), $decomp ? CompressionService::Decompress($character->$binaryMethod()) : $character->$binaryMethod());
        
        if (!$success) {
            return false;
        }
        
        return true;
    }
    
    public static function EntryRename(Character $character, $binary)
    {
        $entryPath = sprintf('%s/storage/%s/%s/',ROOT_DIR, $binary, $character->getId());
        if (!file_exists($entryPath . $_POST['entry'])) {
            ResponseService::SendNotFound();
        }
        
        $newName = $_POST['newName'];
        
        if (!substr($newName, -strlen('.bin')) === '.bin') {
            ResponseService::SendUnprocessableEntity('Safety feature! Please end your Backup name with an ".bin"');
        }
        
        if (rename($entryPath . $_POST['entry'], $entryPath . $newName)) {
            ResponseService::SendOk();
        }
        
        ResponseService::SendServerError();
    }
    
    public static function EntryCompression(Character $character, string $binary, $decomp)
    {
        $savePath = sprintf('%s/storage/%s',ROOT_DIR, $binary);
        if (!is_dir($savePath)) {
            ResponseService::SendNotFound();
        }
        
        $savePath .= '/' . $character->getId();
        if (!is_dir($savePath)) {
            mkdir($savePath);
        }
    
        $entryPath = sprintf('%s/storage/%s/%s/%s',ROOT_DIR, $binary, $character->getId(), $_POST['entry']);
        
        if ($decomp) {
            $data = CompressionService::Decompress(file_get_contents($entryPath));
        } else {
            $data = CompressionService::Compress(file_get_contents($entryPath));
        }
        $success = file_put_contents(sprintf('%s/%scompressed_%s', $savePath, $decomp ? "de" : "", $_POST['entry']), $data);
        
        if (!$success) {
            ResponseService::SendServerError('Missing write permissions on file system!');
        }
    
        ResponseService::SendOk();
    }
    
    public static function EntryDelete(Character $character, string $binary)
    {
        $savePath = sprintf('%s/storage/%s',ROOT_DIR, $binary);
        if (!is_dir($savePath)) {
            ResponseService::SendNotFound();
        }
        
        $entryPath = sprintf('%s/storage/%s/%s/%s',ROOT_DIR, $binary, $character->getId(), $_POST['entry']);
        
        $success = unlink($entryPath);
        
        if (!$success) {
            ResponseService::SendServerError('Missing permissions on file system!');
        }
        
        ResponseService::SendOk();
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
                $files = DirectoryService::ScanDirByModified($path);
    
                if ($files === false) {
                    continue;
                }
                
                $tmp = array_values($files);
                
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
    
    public static function ResetLoginboost(Character $character)
    {
        $em = EM::getInstance();
        $em->getConnection()->prepare(sprintf('UPDATE login_boost_state
                                                      SET available = true, end_time = 0, week_count = 0
                                                      WHERE char_id = %s',
            $character->getId()
        ))->execute();
        $em->flush();
    
        ResponseService::SendOk();
    }
}
