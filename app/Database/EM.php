<?php


namespace MHFSaveManager\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
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
        $config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        self::$entityManager = EntityManager::create($dbParams, $config);
    }
    
}
