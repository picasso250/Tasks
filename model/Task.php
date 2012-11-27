<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Task extends Model
{
    public static $table = 'task';

    public function done()
    {
        $this->edit('done', 1);
    }
}
