<?php

$tasks = ORM::forTable('task')
    ->orderByAsc('order_')
    ->orderByAsc('id')
    ->findMany();

include dirname(__DIR__).'/view.html';
