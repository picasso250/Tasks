<?php

$t = ORM::forTable('task')->create();

foreach (_post() as $key => $value) {
    if (in_array($key, array('name', 'order_', 'indent', 'group'))) {
        $t->set($key, $value);
    }
}
$rs = $t->save();

echo json_encode(array('code' => $rs ? 0 : 1, 'data' => array('id' => $t->id)));
exit;
