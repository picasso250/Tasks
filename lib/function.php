<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @version 7.6 add _req() function group
 */

/* short names(may be we need no that) */

function i(&$param, $or='') {
    return isset($param)? $param : $or;
}

function h($str) {
    return htmlspecialchars($str);
}

/* $_GET, $_POST, $_REQUEST helpers or shortens */

function _req($para, $default = '') 
{
    return isset($_REQUEST[$para]) && $_REQUEST[$para] ? trim($_REQUEST[$para]) : $default;
}

function _post($vars)
{
    $ret = make_array_by_name_list_from_source(func_get_args(), $_POST);
    return (1 === func_num_args()) ? reset($ret) : $ret;
}

function _get($vars)
{
    $ret = make_array_by_name_list_from_source(func_get_args(), $_GET);
    return (1 === func_num_args()) ? reset($ret) : $ret;
}

function make_array_by_name_list_from_source($namelist, &$source_arr)
{
    // what if $namelist is an empty array
    $default = '';
    return array_map(function ($name) use($source_arr, $default) {
        if (isset($source_arr[$name])) {
            // value can be array also, not just string types
            $value = $source_arr[$name];
            return is_array($value) ? $value : trim($value);
        } else {
            return $default;
        }
    }, $namelist);
}

/* html node */

function js_node($src='', $code='') {
    $src_str = $src? ' src="' . ROOT . 'static/js/'.$src.'.js?v='. JS_VER .'"' : '';
    return '<script type="text/javascript"'.$src_str.'>'.$code.'</script>';
}

function css_node($src='', $type='css') {
    $rel = 'rel="stylesheet'.($type!='css'?'/'.$type:'').'"';
    $href = 'href="'.ROOT.'static/css/'.$src.'.'.$type.'?v='. CSS_VER .'"';
    $type = 'type="text/css"';
    return "<link $rel $type $href />";
}

function js_var($var_name, $arr) {
    return js_node('', $var_name.'='.json_encode($arr));
}

function _css($file) {
    return "static/css/$file.css";
}

function _js($file) {
    return "static/js/$file.js";
}

/** translate Y-m-d to xx之前 or 今天XX
 *
 * @param type $date_time_str 形如 Y-m-d H:i:s （sql中获得的DateTime类型即可）
 */
function friendly_time($date_time_str) {
    $date_time = new DateTime($date_time_str);
    $nowtime = new DateTime();
    $diff = $nowtime->diff($date_time);
    if ($diff->y==0 && $diff->m==0 && $diff->d==0) { // 同一天
        if ($diff->h<1) // 一个小时以内
            if ($diff->i==0) // 一分钟以内
                return '刚刚';
            else
                return $diff->i.'分钟前'; // minutes
        else
            return '今天'.end(explode(' ', $date_time_str));
    } else {
        return $date_time_str;
    }
}

/* debug helpers */

// little function to help us print_r() or var_dump() things
function d($var, $var_dump=0) {
    $debug = defined('DEBUG') ? DEBUG : 1;

    if (!$debug) 
        return;

    $is_cli = (PHP_SAPI === 'cli');                              // is cli mode
    $is_ajax = isset($GLOBALS['is_ajax']) && $GLOBALS['is_ajax']; // compitible for low version
    $by_ajax = isset($GLOBALS['by_ajax']) && $GLOBALS['by_ajax']; // ajax
    $html_mode = !($is_cli || $is_ajax || $by_ajax);            // will display in html?

    if ($html_mode) 
        echo '<p><pre>';
    echo PHP_EOL;
    if ($var_dump) {
        var_dump($var);
    } elseif (is_array($var) || is_object($var)) {
        print_r($var);
    } else {
        var_dump($var);
    }
    if ($html_mode) 
        echo '</p></pre>';
    echo PHP_EOL;
}

/* image upload helpers */

/**
 * what is this?
 * @param type $file_content
 * @param type $crop
 * @param type $width
 * @param type $height
 * @param type $new_width
 * @param type $new_height
 * @return type
 * @throws Exception
 */
function image_resize ($file_content, $crop, $width, $height, $new_width, $new_height) {
    if ($new_width < 1 || $new_height < 1) {
        throw new Exception('specified size too small');
    } else if ($width<$new_width || $height<$new_height) {
        throw new Exception('too small');
    } else {
        $dst = imagecreatetruecolor($new_width, $new_height);
        $src_x = 0;
        $src_y = 0;
        if ($crop) {
            $ratio = $width / $height;
            $new_ratio = $new_width / $new_height;
            if ($ratio > $new_ratio) {
                $width = ceil($new_ratio * $height);
            } else if ($ratio < $new_ratio) {
                $height = ceil($width / $new_ratio);
            }
        }
        imagecopyresampled($dst, $file_content, 0, 0, $src_x, $src_y, $new_width, $new_height, $width, $height);
        return $dst;
    }
}

/**
 * main function
 * @param type $image like $_FILE['xx']
 * @param type $opt resize crop width height
 * @return string url of the final img
 * @throws Exception
 */
function make_image($image, $opt=array()) {
    
    // deault option
    $opt = array_merge(array(
        'crop' => 0,
        'resize' => 0,
        'width' => 50,
        'height' => 50,
        'list' => null,
    ), $opt);
    
    $arr = explode('/', $image['type']);
    $file_type = reset($arr);
    $image_type = end($arr);
    if ($file_type == 'image') {
        
        $extention = file_ext($image['name']);
        
        $tmp_img = $image['tmp_name'];
        
        $resize = $opt['resize'];
        $ret_list = $opt['list'];
        if ($ret_list) {
            $ret = array();
            foreach ($ret_list as $opt_) {
                if ($resize) {
                    image_file_resize($tmp_img, $image_type, $opt_['crop'], $opt_['width'], $opt_['height']);
                }
                $content = file_get_contents($tmp_img);
                $file_name = uniqid() . '.' . $extention;
                $ret[] = write_upload($content, $file_name);
            }
            return $ret;
        } else {
            if ($resize) {
                image_file_resize($tmp_img, $image_type, $opt['crop'], $opt['width'], $opt['height']);
            }
            $content = file_get_contents($tmp_img);
            $file_name = uniqid() . '.' . $extention;
            return write_upload($content, $file_name);
        }
    } else { // maybe throw??
        return '';
    }
}

function image_file_resize($tmp_img_file, $image_type, $crop, $new_width, $new_height) {
    list($width, $height) = getimagesize($tmp_img_file);
    switch ($image_type) {
        case 'jpg':
        case 'jpeg':
        case 'pjpeg': // yes, this strange type is for ie
            $src = imagecreatefromjpeg($tmp_img_file);
            $dst = image_resize($src, $crop, $width, $height, $new_width, $new_height);
            imagejpeg($dst, $tmp_img_file);
            break;
        case 'png':
        case 'x-png': // for ie
            $src = imagecreatefrompng($tmp_img_file);
            $dst = image_resize($src, $crop, $width, $height, $new_width, $new_height);
            imagepng($dst, $tmp_img_file);
            break;
        case 'gif': // ??
            $src = imagecreatefromgif($tmp_img_file);
            $dst = image_resize($src, $crop, $width, $height, $new_width, $new_height);
            imagegif($dst, $tmp_img_file);
            break;
        default :
            break;
    }
}

// write file content to dst
function write_upload($content, $file_name) {
    if (ON_SERVER) {
        $up_domain = UP_DOMAIN;
        $s = new SaeStorage();
        $s->write($up_domain , $file_name , $content);
        return $s->getUrl($up_domain ,$file_name);
    } else {
        $root = 'data/';
        if (!file_exists($root)) {
            mkdir($root);
        }
        $dst_root = $root .'upload/';
        if (!file_exists($dst_root)) {
            mkdir($dst_root);
        }
        $year_month_folder = date('Ym');
        $path = $year_month_folder;
        if (!file_exists($dst_root.$path)) {
            mkdir($dst_root.$path);
        }
        $date_folder = date('d');
        $path .= '/'.$date_folder;
        if (!file_exists($dst_root.$path)) {
            mkdir($dst_root.$path);
        }
        $path .= '/'.$file_name;
        file_put_contents($dst_root.$path, $content);
        return ROOT . 'data/upload/' . $path;
    }
}

function file_ext($file_name) {
    $arr = explode('.', $file_name);
    if (count($arr) < 2) {
        throw new Exception('bad file name: ' . $image['name']);
    }
    return end($arr);
}

// usage: 
//     $url could be empty, which will go to index, 
//     could be out link, such "http://google.com"
//     also could be absulote path, such as "/root/login"
//     the begining "/" could be omitted
function redirect($url='') {
    // 1. out link ==> directly
    // 2. inner link (without root) ==> add ROOT first
    // 3. inner link (with root) ==> directly
    if (strpos($url, 'http') !== 0 && strpos($url, '/') !== 0) { // inner link relatively
        $url = ROOT . $url;
    }
    header('Location:'.$url);
    exit();
}

function sae_log($msg){
    sae_set_display_errors(false);//关闭信息输出
    sae_debug($msg);//记录日志
    sae_set_display_errors(true);//记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
}

function is_mobile() {
    static $mobile_browser = null;
    if ($mobile_browser !== null) {
        return $mobile_browser > 0;
    }
    
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
 
    $mobile_browser = '0';
 
    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
 
    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
 
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
 
    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
 
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
    $mobile_agents = array(
                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                        'wapr','webc','winw','winw','xda','xda-'
                        );
 
    if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;
 
    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;
 
    // Pre-final check to reset everything if the user is on Windows
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        $mobile_browser=0;
 
    // But WP7 is also Windows, with a slightly different characteristic
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
        $mobile_browser++;
 
    if($mobile_browser>0)
        return true;
    else
        return false;
}

// 或许是该改变了，这个检测不存在就，抛出错
// 不检测，直接不适用这个函数，在master那里直接写
function smart_view($view, $default = 'default') 
{
    $GLOBALS['view_looking_for'] = $view;
    if (is_mobile() && ($m = FrameFile::view('mobile/' . $view)) && file_exists($m))
        return $m;
    if (($file = FrameFile::view($view)) && file_exists($file))
        return FrameFile::view($view);
    if (is_mobile() && ($m = FrameFile::view('mobile/' . $default)) && file_exists($m))
        return $m;
    return FrameFile::view($default);
}

function safe_array_map($call, $arr)
{
    if ($arr === false)
        return array();
    return array_map($call, $arr);
}

function build_nav($str)
{
    $str = trim($str);
    $arr = array();
    $lines = explode(PHP_EOL, $str);
    $top_key = '';
    foreach ($lines as $line) {
        if (empty($line)) 
            continue;
        if (strpos($line, ' ') === 0) { // sub
            if (empty($top_key)) {
                throw new Exception('no top key, that means you did not put a top level first, please remove the leading spaces');
            }
            $line = trim($line);

            $arr_ = explode(' ', $line);
            array_shift($arr_); // remove leading char
            $count = count($arr_);
            if ($count < 1)
                throw new Exception("line: $line, must with leading + or -");
            if ($count < 2) {
                $arr_[] = '';
            }
            list($name, $link) = $arr_;

            $arr[$top_key]['sub'][] = array(
                'name' => $name,
                'link' => $link);

            // default
            $default = strpos($line, '+') === 0;
            if ($default) {
                $arr[$top_key]['default'] = $link;
            }
        } else { // top
            list($title, $name) = explode(' ', $line);
            $top_key = trim($name);
            if (empty($name)) {
                throw new Exception('you must provide a name');
            }
            $arr[trim($name)] = array('title' => trim($title));
        }
    }
    return $arr;
}
