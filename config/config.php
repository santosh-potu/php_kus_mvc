<?php

define('APP_PATH',dirname(__DIR__));
define('CONFIG_DIR',APP_PATH.DIRECTORY_SEPARATOR.'config');

//Inlcude environment configuration file
$environment_config_file = CONFIG_DIR.DIRECTORY_SEPARATOR.'env'.DIRECTORY_SEPARATOR.getenv("environment").'.env.php';

if(file_exists($environment_config_file)){
    require_once $environment_config_file;
}else{
    require_once CONFIG_DIR.DIRECTORY_SEPARATOR.'env'.DIRECTORY_SEPARATOR.'default.env.php';
}

//custom auto loader
//require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'auto_loader.php';
require APP_PATH. '/vendor/autoload.php';
require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'vars.inc.php';

//PDO constants
define('PDO_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);
