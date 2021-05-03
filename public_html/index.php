<?php
//start out put buffering for web specially
define('OB_START',ob_start());

require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

$app = Kus\Application::getInstance();
$db = $app->getDbConnection();

$router = $app->getRouter();
$router->route();

$app->flushOb();
