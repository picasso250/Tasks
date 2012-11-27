<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 * 由王霄池纯粹手写而成
 */

// 打开错误提示，在 SAE 上 ini_set 将不起作用
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('IN_APP', 1);
define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

require 'config/common.php';

// if not debug, mute all error reportings
if (!(defined('DEBUG') ? DEBUG : 0)) {
    ini_set('display_errors', 0);
    error_reporting(0);
}

require 'lib/function.php';
include 'lib/autoload.php';

// 变量初始化
require 'init.php';
init_var();
init_env();

require 'logic.php';

inlcude 'view.html';
