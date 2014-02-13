<?php
/**
 * @file    common
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 30, 2012 10:38:22 AM
 */

if (isset($_SERVER['HTTP_APPNAME'])) { // on server
    define('ON_SERVER', TRUE);
    
    define('DEBUG', TRUE);
    
    define('UP_DOMAIN', 'xxxx');
} else {
    define('ON_SERVER', FALSE);
    
    define('DEBUG', TRUE);
    
    define('JS_VER',  time());
    define('CSS_VER', time());
}

define('ROOT', '/');

define('DEFAULT_LOGIN_REDIRECT_URL', ROOT); // 登录后的默认导向页面

$config['site']['name'] = 'EnMond';

$config['db'] = array(
    'dsn' => 'mysql:host=localhost;dbname=google',
    'username' => 'root',
    'password' => ''
);

if (ON_SERVER) {
    // 会覆盖之前的配置
    $config['db'] = array(
        'master' => array('host' => SAE_MYSQL_HOST_M),
        'slave'  => array('host' => SAE_MYSQL_HOST_S),
        'port'   => SAE_MYSQL_PORT,
        'dbname' => SAE_MYSQL_DB,
        'username' => SAE_MYSQL_USER,
        'password' => SAE_MYSQL_PASS
    );
    include 'server.php';
}

// 数据库名
define('cart_product', 'cart_product');
define('customer_address', 'customer_address');

// error info
$config['error']['info'] = array(
    'PASSWORD_EMPTY' => 'plz enter password',
    'REPASSWORD_EMPTY' => 'plz reEnter your password to confirm',
    'NEW_PASSWORD_EMPTY' => '请输入新密码',
    'PASSWORD_NOT_SAME' => 'sorry, password not the same, plz reEnter',
    'USERNAME_EMPTY' => 'username empty',
    'USERNAME_OR_PASSWORD_INCORRECT' => '用户名或者密码不正确',
    'PASSWORD_INCORRECT' => '密码不正确',
    'USER_ALREADY_EXISTS' => 'username already exists, choose another one',
    'REALNAME_EMPTY' => '请填写真实姓名',
    'PHONE_EMPTY' => '请填写手机号码',
    'EMAIL_EMPTY' => '请填写您的电子邮箱', );

// pages need login
$config['controllers_need_login'] = array(
    'index',
    'cart',
    'my',
    'order',
    'product',
    'user',
    'factory',
    'statistics',
    'setting');

$config['gender'] = array(
    'male' => '男',
    'female' => '女');
$config['customer_state'] = array(
    'ToBeAdopted' => '等待审核',
    'Adopted' => '审核通过',
    'Ban' => '拒绝访问');

$config['setting_name_map'] = array(
    'labor_expense' => '工费',
    'wear_tear' => '损耗',
    'st_expense' => '辅石工费',
    'st_price' => '辅石价格',
    'weight_ratio' => '铂金和K金重量比');

$config['material_type_map'] = array(
    'PT950' => 'PT950',
    'AU750' => 'AU750');

$config['product_material_map'] = array(
    'PT950',
    'AU750',
    '黄18K金',
    '白18K金',
    '红18K金',);
$config['material_type_name_map'] = array(
    'PT950' => 'PT950',
    'AU750' => 'AU750',
    '黄18K金' => 'AU750',
    '白18K金' => 'AU750',
    '红18K金' => 'AU750');

$config['order_states'] = array( // remove s??
    //'InCart' => '...',
    'ToBeConfirmed' => '待确认',
    'InFactory' => '已交工厂',
    'FactoryDone' => '工厂完工',
    'Done' => '完成');

$config['order_next_action'] = array(
    'InCart' => '',
    'ToBeConfirmed' => 'confirm',
    'InFactory' => 'factoryDone',
    'FactoryDone' => 'done',
    'Done' => '');

$config['next_button_map'] = array(
    'InCart' => '',
    'ToBeConfirmed' => '确认',
    'InFactory' => '完工',
    'FactoryDone' => '',
    'Done' => '');

$config['account_type'] = array(
    'supplement' => '充值',
    'consume' => '消费');

$config['st_type'] = array(
    'me' => '英格用料',
    'factory' => '工厂用料');

$config['account_sort'] = array(
    'DESC' => '时间降序',
    'ASC' => '时间升序');



// navs structure
// array(
//     'my' => array(
//         'title' => '我的资料',
//         'defalut' => 'info',
//         'children' => array( // or sub
//             'info' => array(
//                 'title' => ))),
//     'order' => array(),
//     'product' => array());

// 普通用户的导航
$config['navs']['customer'] = '
我的订单 order
 - 待确认 tobeconfirmed
 - 已交工厂 infactory
 - 工厂完工 done
 + 全部订单 all
我的资料 my 
 + 个人资料 info
 - 修改密码 password
';

// 管理员的导航
$config['navs']['admin'] = '
订单管理 order
 - 未结清 unpay
 - 待确认 tobeconfirmed
 - 已交工厂 infactory
 - 工厂完工 done
 - 已取消 cancel
 + 全部订单 all
货品管理 product
 + 货品列表 
 - 单品上传 post
用户管理 user
 + 用户列表 
 - 新增用户 add
工厂管理 factory
 + 工厂列表
 - 新增工厂 add
数据统计 statistics
 - 历史金价 gold_price
 + 销量统计 sale
系统设置 setting
 + 全局设置
 - 修改密码 password
';

// 总管理员的导航 
// 其实本有更好的办法，操，你怎么这么傻呢王霄池
$config['navs']['superadmin'] = '
管理员 admin
 + 管理员列表 
 - 新增管理员 add
系统设置 setting
 + 修改密码 password
';
