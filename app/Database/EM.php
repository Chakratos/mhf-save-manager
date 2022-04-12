<?php


namespace MHFSaveManager\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EM
{
    private static $entityManager;
    
    public static function getInstance(): EntityManager
    {
        if (!self::$entityManager) {
            self::_createInstance();
        }
        
        return self::$entityManager;
    }
    
    private static function _createInstance()
    {
        $paths = array(ROOT_DIR . "/app/model");
        $isDevMode = true;
        
        $dbParams = [
            'dbname' => DBNAME,
            'user' => DBUSER,
            'password' => DBPASS,
            'host' => DBHOST,
            'driver' => DBDRIVER,
            'port' => DBPORT,
        ];
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
        $config->addEntityNamespace('MHF', 'MHFSaveManager\model');
        self::$entityManager = EntityManager::create($dbParams, $config);
    }
    
}
