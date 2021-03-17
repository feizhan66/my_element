<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/19
 * Time: 11:27
 */

namespace app\api\controller;
use think\Db;

class Login extends Common
{
    /**
     *
     */
    public function login(){

        $params = array(
            'mobile_phone'=>'mobile_phone/not_null',
            'password'=>'password/not_null'
        );
        $params = $this->buildParam($params);
        try{

            // 前端已经md5一次
            $params['password'] = password_md5($params['password']);

            $user = Db::name('user')
                ->where($params)
                ->field('id')
                ->find();
            if (empty($user)){
                throw new \Exception('找不到该用户');
            }

            $token = build_token();
            $data = array(
                'user_id'       => $user['id'],
                'platform_type' => '',
                'equipment_sn'  => time(),
                'login_way'     => 'platform',
                'login_ip'      => request()->ip(),
                'login_token'   => $token,
                'effect_time'   => time() + 7*24*60*60,
                'create_time'   => time(),
                'update_time'   => time()
            );
            Db::name('user_login_log')->insertGetId($data);

            $re_data = array(
                'user_id'   => $user['id'],
                'token'     => $token
            );

            return $this->returnSuccess($re_data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }

    }

    public function loginOut(){
        $params = array();
        $params = $this->buildParam($params);
        try{

            $data = array();
            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }
}