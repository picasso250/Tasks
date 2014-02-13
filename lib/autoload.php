<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

define('APP_ROOT', dirname(__DIR__));

// auto require when using class (model)
spl_autoload_register(function ($classname) {
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
    $model_file = APP_ROOT . 'model' . DIRECTORY_SEPARATOR . $filename;
    $lib_file = APP_ROOT . 'lib' . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $filename;
    if (file_exists($model_file)) 
        require_once $model_file;
    elseif (file_exists($lib_file))
        require_once $lib_file;
});
