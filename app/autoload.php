<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 9:55
 */
function autoLoad($path){
    if(preg_match('/\\\\/',$path)){
        $path = str_replace('\\',DIRECTORY_SEPARATOR,$path);
    }
    if(file_exists($path.'.php')){
        require_once "{$path}.php";
    }else{
        throw new \Exception("vendor/autoload.php - File {$path}.php not found");
    }
}
spl_autoload_register('autoLoad');