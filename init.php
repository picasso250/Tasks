<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
function init_var()
{
    $GLOBALS['action'] = _req('action') ?: 'index';
}

function init_env() 
{
    ob_start();
    session_start();
    date_default_timezone_set('PRC');
}
