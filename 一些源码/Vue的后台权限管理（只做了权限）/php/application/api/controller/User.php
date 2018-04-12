<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/19
 * Time: 14:38
 */

namespace app\api\controller;
use think\Db;

class User extends Common
{
    /**
     * 获取用户信息
     */
    public function getUserInfo(){
        $params = array(
            'user_id'=>'user_id/not_null'
        );
        $params = $this->buildParam($params);
        try{

            // 获取某个用户的个人信息
            $user = Db::name('user_profile')
                ->where(['user_id'=>$params['user_id']])
                ->field('user_id,name as user_name,avatar,sex')
                ->find();
            if (empty($user)){
                throw new \Exception('找不到该用户');
            }

            if (empty($user['avatar'])){
                $user['avatar'] = config('default_image');
            }else{
                $user['avatar'] = config('oss_url').$user['avatar'];
            }

            // 获取某个用户的权限组
            $roles = Db::name('auth_role_access')->alias('ara')
                ->join('__AUTH_ROLE__ ar','ara.role_id=ar.id')
                ->where(['ara.user_id'=>$params['user_id']])
                ->field('ar.id as role_id,title,rules')
                ->select();

            // 权限处理
            $rules = [];
            foreach ($roles as $roles_key=>$roles_value){
                $rules = array_merge($rules,explode(',',$roles_value['rules']));//
                unset($roles[$roles_key]['rules']);
            }
            $rules = array_unique($rules);

            $user['roles'] = $roles;
            $user['rules'] = $rules;

            return $this->returnSuccess($user);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }

    /**
     * 用户列表
     */
    public function userList(){
        $params = array(
            'page'=>'page',
            'size'=>'size'
        );
        $params = $this->buildParam($params);
        try{

            $userList = Db::name('user')->alias('u')
                ->join('__USER_PROFILE__ up','u.id=up.user_id')
                ->where([])
                ->page($params['page'],$params['size'])
                ->field('u.id as user_id,u.account,u.mobile_phone,u.status,up.name as user_name,up.sex,up.avatar')
                ->select();

            $userCount = Db::name('user')
                ->where([])
                ->count();

            $data = [
                'count'=>$userCount,
                'items'=>$userList
            ];

            return $this->returnSuccess($data);
        }catch (\Exception $exception){
            return $this->returnFailure($exception->getMessage());
        }
    }
}