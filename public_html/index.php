<?php

require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

$app = Kus\Application::getInstance();
$db = $app->getDbConnection();

$router = $app->getRouter();
$router->route();

