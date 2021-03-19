<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/11/16
 * Time: 14:49
 * 这个是独立的，不接受任何的权限限制
 */

namespace app\api\controller;
use app\common\controller\SignatureCommon;
use think\Db;

class SignatureController extends CommonController
{

    public function return_test(){
        $data = array('dad'=>'das');
        return $this->returnSuccess($data);
    }
    public function verify_test(){
        $params = input('param.');

        $SignatureCommon = new SignatureCommon();
        $v = $SignatureCommon->verifySign($params);
        dump($v);
    }

    /**
     * 申请公钥
     *
     * 注意：php的话解析这个用双引号，这样子的话 \n 就能解析为换行,单括号的话 \n 就被当成文本解析了
     */
    public function getPublicKey(){
        $Signature = new SignatureCommon();
        $getPublicKey = $Signature->getPublicKey();
        $data = array('public_key'=>$getPublicKey);
        return $this->returnSuccess($data);
    }

    /**
     * 同步Key(guid)
     * 发过来的是一串加密的字符串
     * 如果old_sign_tid非空的话就是代表更新的，为空的话就是代表首次创建
     *
     * param sign_old_tid   [选填]    前一个的TID，带上这个代表是更新
     * param sign_old_token [选填]    在sign_old_tid存在时必填
     *
     * param sign_token     [必填]    新的Token
     * param sign_platform  [必填]    平台
     * param sign_time   [必填]    操作时间
     *
     * 必须拥有上面全部的五个或者三个参数，并且转成json的形式发送过来(传过来的参数进行base64转码)
     *
     */
    public function synchronizeToken(){
        $params = input('param.');

        $token_value = $params['token_value'];

//        $sign_old_tid   = $params['sign_old_tid'];
//        $sign_old_token = $params['sign_old_token'];
//        $sign_token     = $params['sign_token'];
//        $sign_platform  = $params['sign_platform'];
//        $sign_time   = $params['sign_time'];        // 操作时间


        if (empty($token_value))
        { // 参数出错
            return ReturnDatas(CONFIG::ERROR_CODE_SIGNATURE_PARAM_MISS,CONFIG::ERROR_VALUE_SIGNATURE_PARAM_MISS);
        }

        Db::startTrans();
        try{
            // base64还原,这个是公钥加密过的内容
            $token_value = base64_decode($token_value);

            //私钥解公钥的内容
            $Signature = new SignatureCommon();
            $private_key = $Signature->getPrivateKey();

            // 判断秘钥是否有效
            $pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
            if (!$pi_key)
            {// 获取私钥失败

                $error = array(
                    'code'=>CONFIG::ERROR_CODE_SIGNATURE_GET_PRIVATE_FAILURE,
                    'message'=>CONFIG::ERROR_VALUE_SIGNATURE_GET_PRIVATE_FAILURE
                );
                throw new \Exception(json_encode($error));
            }
            // 利用私钥解密
            openssl_private_decrypt($token_value,$decrypted,$private_key);//私钥解密

            // $decrypted是一个json
            $decrypted = json_decode($decrypted,true);

            if (empty($decrypted) || !is_array($decrypted))
            {// 交换密钥失败
                $error = array(
                    'code'=>CONFIG::ERROR_CODE_SIGNATURE_GET_TOKEN_FAILURE,
                    'message'=>CONFIG::ERROR_VALUE_SIGNATURE_GET_TOKEN_FAILURE
                );

                throw new \Exception(json_encode($error));
            }

            $sign_old_tid   = $decrypted['sign_old_tid'];
            $sign_old_token = $decrypted['sign_old_token'];
            $sign_token     = $decrypted['sign_token'];
            $sign_platform  = $decrypted['sign_platform'];
            $sign_time   = $decrypted['sign_time'];

            // 检查参数
            if (empty($sign_token) || empty($sign_platform) || empty($sign_time)){
                $error = array(
                    'code'=>CONFIG::ERROR_CODE_SIGNATURE_PARAM_MISS,
                    'message'=>CONFIG::ERROR_VALUE_SIGNATURE_PARAM_MISS
                );
                throw new \Exception(json_encode($error));
            }

            // 检查过期
            if ($sign_time < time()-30*60)
            {// 半个钟,操作超时
                $error = array(
                    'code'=>CONFIG::ERROR_CODE_SIGNATURE_OVER_TIME,
                    'message'=>CONFIG::ERROR_VALUE_SIGNATURE_OVER_TIME
                );
                throw new \Exception(json_encode($error));
            }


            // 校验Token，要求非空
            $signature_token_tid = Db::name('signature')
                ->where(['sign_token'=>$sign_token])
                ->value('tid');
            if ($signature_token_tid){
                $error = array(
                    'code'=>CONFIG::ERROR_CODE_SIGNATURE_TOKEN_CONFLICT,
                    'message'=>CONFIG::ERROR_VALUE_SIGNATURE_TOKEN_CONFLICT
                );
                throw new \Exception(json_encode($error));
            }

            $signature_data = array();
            $user_status = false;       //用户状态

            if (!empty($sign_old_tid))
            {// 这个是更新 -- 主要是用户登录态的更新

                // 获取原来的（不需要校验sign的时间）
                $signature_message = Db::name('signature')
                    ->where([
                        'tid'       =>$sign_old_tid,
                        'sign_token'=>$sign_old_token,
                        'status'    =>1,
                    ])
                    ->find();
                if (!$signature_message)
                {// 更新签名失败

                    $error = array(
                        'code'=>CONFIG::ERROR_CODE_SIGNATURE_UPDATE_FAILURE,
                        'message'=>CONFIG::ERROR_VALUE_SIGNATURE_UPDATE_FAILURE
                    );
                    throw new \Exception(json_encode($error));

                }

                // 把原来的改为无效
                Db::name('signature')
                    ->update([
                        'tid'           => $sign_old_tid,
                        'status'        => 0,
                        'update_time'   => time()
                    ]);


                // 用户超过有效时间就不允许续签
                if ($signature_message['user_tid'] && $signature_message['effect_time'] > time())
                {//用户存在且正常登录中

                    $user_status = true;

                    // 插入用户信息及用户的有效时间
                    $signature_data['user_tid'] = $signature_message['user_tid'];
                    $signature_data['effect_time'] = time()+7*24*60*60;

                }
            }

            // 这个是保存
            $signature_data['platform']      = $sign_platform;
            $signature_data['sign_token']    = $sign_token;
            $signature_data['status']        = 1;
            $signature_data['create_time']   = time();
            $signature_data['update_time']   = time();

            $signature_tid = Db::name('signature')->insertGetId($signature_data);
            $return_date = array(
                'sign_tid' => $signature_tid,
                'sign_time' => $signature_data['create_time'],
                'user_tid'=>$signature_data['user_tid'] ? $signature_data['user_tid'] : -1
            );


            // 这个是处理成功
            if (empty($sign_old_tid))
            { // 这个是新建
                $success_data = array(
                    'code'=>CONFIG::SUCCESS_CODE_SIGNATURE_CREATE,
                    'message'=>CONFIG::SUCCESS_VALUE_SIGNATURE_CREATE
                );
            }
            else
            {// 更新
                if ($user_status)
                { // 带用户信息的
                    $success_data = array(
                        'code'=>CONFIG::SUCCESS_CODE_SIGNATURE_UPDATE_WITH_USER,
                        'message'=>CONFIG::SUCCESS_VALUE_SIGNATURE_UPDATE_WITH_USER
                    );
                }
                else
                {// 不带用户信息的
                    $success_data = array(
                        'code'=>CONFIG::SUCCESS_CODE_SIGNATURE_UPDATE,
                        'message'=>CONFIG::SUCCESS_VALUE_SIGNATURE_UPDATE
                    );
                }
            }

            // todo
//            Db::commit();
            return ReturnDatas($success_data['code'],$success_data['message'],$return_date);

        }catch (\Exception $exception){
            Db::rollback();
            $error_data = json_decode($exception->getMessage(),true);
            if ($error_data)
            {//输出的是错误数组
                return ReturnDatas($error_data['code'],$error_data['message']);
            }
            else
            {//输出的是错误信息
                return $this->returnFailure($exception->getMessage());
            }
        }



    }


    /**
     * *****************************************************************
     *
     * *****************************************************************
     */



}