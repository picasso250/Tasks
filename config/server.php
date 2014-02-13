<?php
/**
 * @file    config
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:20:27 PM
 * config of server
 */

define('JS_VER',  '20120926c');
define('CSS_VER', '20120926f');

return array(
    'db' => array(
        'slave'  => array('host' => SAE_MYSQL_HOST_S),
        'dsn' => 'mysql:host='.SAE_MYSQL_HOST_M.';port='.SAE_MYSQL_PORT.';dbname='.SAE_MYSQL_DB,
        'username' => SAE_MYSQL_USER,
        'password' => SAE_MYSQL_PASS
    ),
);
