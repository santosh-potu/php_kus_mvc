<?php

spl_autoload_register('app_autoloader');

/**
 * Autoload handler 
 * 
 * @param String $class
 */
function app_autoloader($class) {

    $class_file_path = explode("\\", $class);    
    $class_file = array_pop($class_file_path). '.php';
    $class_dir_path = "";

    $exceptional_directories = array(
        'Kus' => 'classes'
    );

    foreach ($class_file_path as $dir_ele) {
        if (isset($exceptional_directories[$dir_ele])) {
            $dir_ele = $exceptional_directories[$dir_ele];
        }
        $class_dir_path .= $dir_ele. DIRECTORY_SEPARATOR;
    }
    
    $abs_file_path = APP_PATH . DIRECTORY_SEPARATOR . $class_dir_path . $class_file;
   
    if (file_exists($abs_file_path)) {
        require_once $abs_file_path;
    }else{
        throw new Exception("File: {$abs_file_path} not exists");
    }
}
