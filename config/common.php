<?php
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

if (isset($_SERVER['HTTP_APPNAME'])) { // on server
    define('ON_SERVER', TRUE);
    
    define('DEBUG', TRUE);
    
    define('UP_DOMAIN', 'xxxx');
} else {
    define('ON_SERVER', FALSE);
    
    define('DEBUG', TRUE);
    
    define('JS_VER',  time());
    define('CSS_VER', time());
}

define('ROOT', '/');

$config['site']['name'] = 'X tasks';

$config = array_merge(
    $config,
    include 'local.php'
);

if (ON_SERVER) {
    $config = array_merge(
        $config,
        include 'server.php'
    );
}

