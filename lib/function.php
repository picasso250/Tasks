<?php
function _get($key = null, $or = null)
{
    if ($key === null)
        return $_GET;
    return isset($_GET[$key]) ? ($_GET[$key]) : $or;
}
function _post($key = null, $or = null)
{
    if ($key === null)
        return $_POST;
    return isset($_POST[$key]) ? ($_POST[$key]) : $or;
}
function _req($key = null, $or = null)
{
    if ($key === null)
        return $_REQUEST;
    return isset($_REQUEST[$key]) ? ($_REQUEST[$key]) : $or;
}
 
function is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}
