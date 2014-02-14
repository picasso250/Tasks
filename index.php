<?php

error_reporting(E_ALL);

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/config/common.php';

require __DIR__.'/lib/function.php';
include __DIR__.'/lib/autoload.php';

// 变量初始化
require 'init.php';
init_var();
init_env();

require 'logic.php';

