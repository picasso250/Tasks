<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
function init_var()
{
    $arr = explode('?', $_SERVER['REQUEST_URI']);
    $req_uri = i($_SERVER['REDIRECT_URL'], reset($arr));
    $arr = explode('/', trim($req_uri, '/'));

    // c is controller
    // a is action
    $GLOBALS['controller'] = i($arr[0]) ?: 'index';
    $GLOBALS['action'] = _req('a') ?: _req('action');
    $GLOBALS['target'] = i($arr[1]) ?: _req('target');
    $GLOBALS['argument'] = i($arr[2]);

    // we should use function here
    $GLOBALS['by_ajax'] = i($_REQUEST['is_ajax']) || (strtolower(i($_SERVER['HTTP_X_REQUESTED_WITH'])) == strtolower('XMLHttpRequest'));
    $GLOBALS['by_post'] = strtolower(i($_SERVER['REQUEST_METHOD'])) == 'post';

    $GLOBALS['page'] = array(
        'title'   => $GLOBALS['config']['site']['name'],
        'head'    => array(), // 在head里面的语句
        'scripts' => array(), // 页面底部的script
        'styles'  => array(), // head里面的css
        'append_divs' => array(), // 附加的对话框
    ); // 关于这个页面的变量
}

function init_env() 
{
    ob_start();
    session_start();
    date_default_timezone_set('PRC');
}
