<?php

$id = _post('id');
$t = ORM::forTable('task')->where('id', $id)->findOne();
if (empty($t)) {
    echo "no id $id";
    exit();
}

foreach (_post() as $key => $value) {
    if (in_array($key, array('name', 'order_', 'indent', 'group'))) {
        $t->set($key, $value);
    }
}
$rs = $t->save();

echo json_encode(array('code' => $rs ? 0 : 1));
exit;
