<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/11/28
 * Time: 15:39
 */

namespace app\common\controller;
//use app\common\controller\CONFIG;
use think\Db;

class SignatureCommon
{
    /**
     * 非登录状态的签名校验
     */
    public function verifySignWithNoLogin($params){
        //判断参数
        $sign_request_time = (string)$params['sign_request_time'];
        $sign_api_versions = $params['sign_api_versions'];
        $sign_platform_type = $params['sign_platform_type'];
        $sign_equipment_sn  = $params['sign_equipment_sn'];//必填
        $sign_value = $params['sign_value'];

        $sign_public_token = $params['sign_public_token'];//不允许有
        $sign_private_token = $params['sign_private_token'];//不允许有

        if (
            empty($sign_request_time) ||
            empty($sign_api_versions) ||
            empty($sign_platform_type) ||
            empty($sign_equipment_sn) ||
            empty($sign_value)
        ){//签名参数错误
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_PARAM_MISS,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_PARAM_MISS
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        if (!empty($sign_public_token) || !empty($sign_private_token))
        {//携带了危险参数(这不允许明文传输)
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_TAKE_DANGER_PARAM,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_TAKE_DANGER_PARAM
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }
        //首先判断是否超时(Api请求最多可延迟5分钟收到)
        if (abs(time() - (int)$sign_request_time) > 5*60)
        {//超时
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_OVER_TIME,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_OVER_TIME
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        //获取公匙(之后可能根据版本号和设备类型不同而选择不同公匙，之后再改进)
        $sign_public_token = config('sign_public_token');
        $params['sign_public_token'] = $sign_public_token;
        unset($params['sign_value']);//sign_value不参与签名


        foreach ($params as $params_key=>$params_value){
            $params[$params_key] = htmlspecialchars_decode($params_value);
        }

        //获取签名
        $signature = $this->getSignature($params);
        if ($signature != $sign_value)
        {//签名校验失败
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_GET_PRIVATE_FAILURE,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_GET_PRIVATE_FAILURE
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        return true;

    }

    /**
     * 登录态的签名校验
     */
    public function verifySignWithLogin($params){
        //判断参数
        $user_tid = $params['user_tid'];//根据这个获取登录信息和私Token

        $sign_request_time  = (string)$params['sign_request_time'];
        $sign_api_versions  = $params['sign_api_versions'];
        $sign_platform_type = $params['sign_platform_type'];
        $sign_value         = $params['sign_value'];
        $sign_equipment_sn  = $params['sign_equipment_sn'];

        $sign_public_token = $params['sign_public_token'];//不允许有
        $sign_private_token = $params['sign_private_token'];//不允许有

        if (
            empty($sign_request_time) ||
            empty($sign_api_versions) ||
            empty($sign_platform_type) ||
            empty($sign_value) ||
            empty($sign_equipment_sn) ||
            empty($user_tid)
        ) {//签名参数错误
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_PARAM_MISS,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_PARAM_MISS
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        if (!empty($sign_public_token) || !empty($sign_private_token))
        {//携带了危险参数(这不允许明文传输)
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_TAKE_DANGER_PARAM,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_TAKE_DANGER_PARAM
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }
        //首先判断是否超时(Api请求最多可延迟5分钟收到)
        if (abs(time() - (int)$sign_request_time) > 5*60)
        {//超时
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_OVER_TIME,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_OVER_TIME
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        $login_token_map = array();
        $login_token_map['user_tid'] = $user_tid;
        $login_token_map['is_effect'] = 1;
        $login_token_map['platform_type'] = $sign_platform_type;
        if (!empty($sign_equipment_sn)){
            $login_token_map['equipment_sn'] = $sign_equipment_sn;
        }

        //获取私匙(获取不到就是用户没登录或者登录过期)
        $login_log = Db::name('user_login_log')
            ->where($login_token_map)
            ->order('create_time desc')
            ->field('tid,login_token')
            ->find();

        if (empty($login_log))
        {//用户没登录/登录已过期
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_USER_LOGIN_PAST_DUE,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_USER_LOGIN_PAST_DUE
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }
        $params['sign_private_token'] = $login_log['login_token'];

        //获取公匙(之后可能根据版本号和设备类型不同而选择不同公匙，之后再改进)
        $sign_public_token = config('sign_public_token');
        $params['sign_public_token'] = $sign_public_token;

        unset($params['sign_value']);//sign_value不参与签名

        foreach ($params as $params_key=>$params_value){
            $params[$params_key] = htmlspecialchars_decode($params_value);
        }

        //获取签名
        $signature = $this->getSignature($params);
        if ($signature != $sign_value)
        {//签名校验失败
            $error_data = array(
                'code'=>CONFIG::ERROR_CODE_SIGNATURE_GET_PRIVATE_FAILURE,
                'message'=>CONFIG::ERROR_VALUE_SIGNATURE_GET_PRIVATE_FAILURE
            );
            $error_data = json_encode($error_data);
            throw new \Exception($error_data);
        }

        Db::name('user_login_log')->update([
            'tid'=>$login_log['tid'],
            'effect_time'=>time()+7*24*60*60,   // 7天
            'update_time'=>time()
        ]);

        return true;
    }

    /**
     * 签名检验的测试
     * (生成预签名校验相同的签名)
     */
    public function verifySignTest($params){
        $user_tid = input('param.user_tid');

        if (empty($params['sign_request_time'])){
            $params['sign_request_time'] = (string)time();
        }

        $params['sign_api_versions'] = input('param.sign_api_versions');

        $params['sign_platform_type'] = input('param.sign_platform_type');//这个先为空（返回要这个的原因是可能要选中不同的Key）

        $params['sign_public_token'] = config('sign_public_token');//

        if (!empty($user_tid)){

            $login_token = Db::name('user_login_log')
                ->where([
                    'user_tid'=>$user_tid,
                    'is_effect'=>1,
                    'platform_type'=>$params['sign_platform_type']
                ])
                ->order('create_time desc')
                ->value('login_token');
            $params['sign_private_token'] = $login_token;
        }

        foreach ($params as $params_key=>$params_value){
            $params[$params_key] = htmlspecialchars_decode($params_value);
        }

        $signature = $this->getSignature($params);
        unset($params['sign_public_token']);
        unset($params['sign_private_token']);
        $params['sign_value'] = $signature;

        return $params;

    }


    /**
     * 非登录态签名生成
     */
    public function buildSignWithNoLogin($params){

        $sign = array();

        $sign['sign_request_time'] = (string)time();

        $sign['sign_api_versions'] = input('param.sign_api_versions');

        $sign['sign_platform_type'] = input('param.sign_platform_type');//这个先为空（返回要这个的原因是可能要选中不同的Key）

        $sign['sign_public_token'] = config('sign_public_token');//

        //转义json
        $sign['params'] = json_encode($params,JSON_UNESCAPED_UNICODE);

        $signature = $this->getSignature($sign);
        $sign['sign_value'] = $signature;

        unset($sign['sign_public_token']);
        unset($sign['params']);

        return $sign;

    }

    /**
     * 登录状态签名生成
     * 登录状态还需要更新有效时间
     */
    public function buildSignWithLogin($params){

        $sign = array();

        $sign['sign_user_tid'] = input('param.user_tid');//这个是必须传过来的

        $sign['sign_request_time'] = (string)time();

        $sign['sign_api_versions'] = input('param.sign_api_versions');

        $sign['sign_platform_type'] = input('param.sign_platform_type');//这个先为空（返回要这个的原因是可能要选中不同的Key）

        $sign['sign_public_token'] = config('sign_public_token');//

        //获取私Token
        $login_token = Db::name('user_login_log')
            ->where([
                'user_tid'=>$params['user_tid'],
                'is_effect'=>1,
                'platform_type'=>$params['sign_platform_type']
            ])
            ->order('create_time desc')
            ->value('login_token');

        $sign['sign_private_token'] = $login_token;

        $sign['params'] = json_encode($params,JSON_UNESCAPED_UNICODE);

        $signature = $this->getSignature($sign);
        $sign['sign_value'] = $signature;
        unset($sign['sign_public_token']);
        unset($sign['sign_private_token']);
        unset($sign['params']);
        return $sign;
    }


    /**
     * ****************************************************************
     * 下面是本地调用的方法
     * ****************************************************************
     */

    /**
     * 执行签名
     * @param array $arrdata 签名数组
     * @param string $method 签名方法
     * @return bool|string 签名值
     */
    public function getSignature($arrdata, $method = "md5")
    {
        if (!function_exists($method)) {
            return false;
        }
        ksort($arrdata);
        $params = array();
        foreach ($arrdata as $key => $value) {
            $params[] = "{$key}={$value}";
        }
        file_put_contents('./text.txt',join('&', $params));
//        echo join('&', $params);
//        exit();
        return $method(join('&', $params));
    }


}