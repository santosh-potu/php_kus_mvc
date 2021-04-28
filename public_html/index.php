<?php

require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

$app = Kus\Application::getInstance();
$db = $app->getDbConnection();

$router  = Kus\Router::getInstance();
$url = $_SERVER['REQUEST_URI'];

$parsedurl = explode("/",$url);

$router->route();

