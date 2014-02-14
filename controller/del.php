<?php

$id = _post('id');
$t = ORM::forTable('task')->where('id', $id)->findOne();
if (empty($t)) {
    echo "no id $id";
    exit();
}

$rs = $t->delete();

echo json_encode(array('code' => $rs ? 0 : 1));
exit;

