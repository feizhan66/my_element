<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/11/16
 * Time: 14:36
 * 签名的方法实现
 */

namespace app\common\controller;
use think\Db;
use think\Controller;

define('PRIVATE_KEY', EXTEND_PATH . 'signature/cert/private_key_2048.txt');
define('PUBLIC_KEY', EXTEND_PATH . 'signature/cert/public_key_2048.txt');

class SignatureCommon extends Controller
{

    /**
     * 获取公钥
     */
    public function getPublicKey(){
        return file_get_contents(PUBLIC_KEY);
    }

    /**
     * 获取私钥
     */
    public function getPrivateKey(){
        return file_get_contents(PRIVATE_KEY);
    }

    /**
     * 获取签名后的参数
     * @param $data
     * @return bool
     */
    public function getSignValue($data){
        $sign_tid = $data['sign_tid'];
        if (empty($sign_tid)){
            return false;
        }

        $sign_token = Db::name('signature')
            ->where([
                'tid'=>$sign_tid,
                'status'=>1
            ])
            ->value('sign_token');
        if (empty($sign_token)){
            return false;
        }

        $data['sign_time'] = time();
        $data['sign_token'] = $sign_token;

        $sign_value = $this->getSignature($data,'md5');


        unset($data['sign_token']);
        $data['sign_value'] = $sign_value;

        return $data;

    }


    /**
     * 验签
     * @param $data
     * @return bool
     */
    public function verifySign($data){
        $sign_tid = $data['sign_tid'];
        $sign_time = $data['sign_time'];
        $sign_value = $data['sign_value'];

        if (empty($sign_tid) || empty($sign_time) || empty($sign_value)){
            return false;
        }
        //判断是否过期
        if (time()-$sign_time> 30*60 ){
            return false;
        }
        //
        $sign_token = Db::name('signature')
            ->where([
                'tid'=>$sign_tid,
                'status'=>1
            ])
            ->value('sign_token');
        if (empty($sign_token)){
            return false;
        }
        $data['sign_token'] = $sign_token;
        unset($data['sign_value']);

        $signature = $this->getSignature($data,'md5');
        if ($signature == $sign_value){
            return true;
        }
        return false;

    }

    /**
     * *********************************************************
     *
     * **********************************************************
     */

    /**
     * 执行签名
     * @param array $arrdata 签名数组
     * @param string $method 签名方法
     * @return bool|string 签名值
     */
    public function getSignature($arrdata, $method = "sha1")
    {
        if (!function_exists($method)) {
            return false;
        }
        ksort($arrdata);
        $params = array();
        foreach ($arrdata as $key => $value) {
            $params[] = "{$key}={$value}";
        }
        return $method(join('&', $params));
    }

    /**
     * 产生随机字符串
     * @param int $length
     * @param string $str
     * @return string
     */
    public function createNoncestr($length = 32, $str = "")
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }



}