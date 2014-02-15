<?php

ORM::configure($config['db']['dsn']);
ORM::configure('username', $config['db']['username']);
ORM::configure('password', $config['db']['password']);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

$group = isset($_COOKIE['group']) ? $_COOKIE['group'] : 0;

$f = __DIR__."/controller/$action.php";
if (file_exists($f)) {
    include $f;
} else {
    echo "no file $f";
    exit();
}
