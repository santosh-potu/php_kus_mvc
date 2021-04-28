<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('display_errors', 'On');

require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'auto_loader.php';
require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'vars.inc.php';
require_once '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'queryhelper.class.php';




//Db credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'poc_connect');

//PDO constants
define('PDO_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);
