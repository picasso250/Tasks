<?php
defined('IN_APP') or exit('?');

Pdb::setConfig($config['db']);

$group = i($_COOKIE['group'], 0);

$tasks = Task::read(compact('group'));
