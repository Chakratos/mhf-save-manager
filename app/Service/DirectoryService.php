<?php


namespace MHFSaveManager\Service;


class DirectoryService
{
    /** https://stackoverflow.com/a/11923516 */
    public static function ScanDirByModified($dir) {
        $ignored = array('.', '..', '.gitkeep');
        
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        
        arsort($files);
        $files = array_keys($files);
        
        return ($files) ? $files : false;
    }
    
    
}
