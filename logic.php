<?php

ORM::configure($config['db']['dsn']);
ORM::configure('username', $config['db']['username']);
ORM::configure('password', $config['db']['password']);

$group = i($_COOKIE['group'], 0);

$tasks = ORM::forTable('task')->findMany();
