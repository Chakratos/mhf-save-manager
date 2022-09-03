<?php

use Pecee\SimpleRouter\SimpleRouter;
require_once '../bootstrap.php';
require_once '../app/routes.php';

session_start();

if (!isset($_SESSION['locale'])) {
    $_SESSION['locale'] = 'en_GB';
}

define("LOCALE_DIR", I18N_DIR . $_SESSION['locale'] . DIRECTORY_SEPARATOR);

SimpleRouter::setDefaultNamespace('\MHFSaveManager\Controllers');
SimpleRouter::start();
