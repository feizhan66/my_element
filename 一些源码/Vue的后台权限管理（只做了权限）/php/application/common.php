<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------


// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,x-token,content-type');


// 应用公共文件

// 应用公共文件
error_reporting(E_ERROR | E_PARSE);//这是自己加的，作用是不要这么强的验证


/**
 * 执行自动加载方法
 */
autoload_function(ROOT_PATH.'application/common/function');
/**
 * 自动加载方法
 */
function autoload_function($path)
{
    $dir  = array();
    $file = array();
    recursion_dir($path,$dir,$file);
    foreach ($file as $key => $value) {
        if (file_exists($value)) {
            require_once($value);
        }
    }
    if(is_file(ROOT_PATH . 'data/install.lock')){
        // 加载主题里的方法
        $where['collection'] = 'indextheme';
        $theme_path = Db::name('KeyValue')->where($where)->value('value');
        if (file_exists(ROOT_PATH.'themes/'.$theme_path.'/functions.php')) {
            require_once(ROOT_PATH.'themes/'.$theme_path.'/functions.php');
        }
    }
}


/*
* 获取文件&文件夹列表(支持文件夹层级)
* path : 文件夹 $dir ——返回的文件夹array files ——返回的文件array
* $deepest 是否完整递归；$deep 递归层级
*/
function recursion_dir($path,&$dir,&$file,$deepest=-1,$deep=0){
    $path = rtrim($path,'/').'/';
    if (!is_array($file)) $file=array();
    if (!is_array($dir)) $dir=array();
    if (!$dh = opendir($path)) return false;
    while(($val=readdir($dh)) !== false){
        if ($val=='.' || $val=='..') continue;
        $value = strval($path.$val);
        if (is_file($value)){
            $file[] = $value;
        }else if(is_dir($value)){
            $dir[]=$value;
            if ($deepest==-1 || $deep<$deepest){
                recursion_dir($value."/",$dir,$file,$deepest,$deep+1);
            }
        }
    }
    closedir($dh);
    return true;
}


//设置返回规范
function ReturnDatas($status, $message, $data = array(), $error = array(), $pagination = "", $token = "", $response_type = 'json')
{

    $return = array();
    if ($status) {
        $return['code'] = (int)$status;
    } else {
        $return['code'] = 400;
    }

    if ($message) {
        $return['message'] = $message;
    }
    else
    {
        $return['message'] = '访问失败';
    }

    if (!empty($pagination))
    {
        $return['pagination'] = $pagination;
    }

//    if (!empty($data)) {
//
//        $return['data'] = $data;
//
//    } else {
//        $return['data'] = array();
//    }
    // 过滤掉 null值
    $return['data'] = deal_null_to_string($data);
    if (empty($return['data'])){
        unset($return['data']);
    }

    if (!empty($sign)){
        $return['sign'] = $sign;
    }else{
        $return['sign'] = array();
    }

    if (!empty($error)) {
        $return['error'] = $error;
    } else {
        $return['error'] = array();
    }


//    if ($token) {
//        $return['token'] = $token;
//    }

    header("token:{$data['token']}");


    // 指定允许其他域名访问
    header('Access-Control-Allow-Origin:*');
// 响应类型
    header('Access-Control-Allow-Methods:*');
// 响应头设置
    header('Access-Control-Allow-Headers:x-requested-with,x-token,content-type');


    if ($response_type == 'jsonp') {
        return jsonp($return);
    } else {
        return json($return);
    }
}

// 处理null,把null编程字符串
function deal_null_to_string($arr){
    foreach ($arr as $arr_key=>$arr_value){
        if (is_array($arr_value)){
            $arr[$arr_key] = deal_null_to_string($arr_value);
        }
        if ($arr_value === null){
            $arr[$arr_key] = '';
        }
    }
    return $arr;
}



/**
 * 密码md5加密方法
 */
function password_md5($string)
{
    return md5(md5($string) . 'huang_xin_yun');
}

/** 生成token **/
function build_token()
{
    return md5(md5('huang_xin_yun') . md5('time' . time()));
}








