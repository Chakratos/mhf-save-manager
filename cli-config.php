<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'bootstrap.php';

$entityManager = \MHFSaveManager\database\EM::getInstance();

return ConsoleRunner::createHelperSet($entityManager);
