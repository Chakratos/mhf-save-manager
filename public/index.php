<?php
use Pecee\SimpleRouter\SimpleRouter;
require_once '../bootstrap.php';
require_once '../app/routes.php';

SimpleRouter::setDefaultNamespace('\MHFSaveManager\Controllers');
SimpleRouter::start();
