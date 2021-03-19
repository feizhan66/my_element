<?php

namespace app\manage\controller;

use think\Db;
use app\manage\model\UsersModel;
use app\manage\model\UserProfileModel;
use app\manage\model\UserLevelLogModel;
use app\manage\model\UserCoinLogModel;
use app\common\model\UserLoginLogModel;
use app\manage\model\AuthRoleModel;

/**
 * @breif 用户控制器
 **/
class UsersController extends CommonController
{
	/**
	 * @breif 用户列表
	 **/
	public function userList()
	{
		if ( request()->isAjax() || request()->isPost() )
        {
			// 显示字段
        	$field = 'tid,account,mobile_phone,identity,status';
            // 筛选条件
            $filterMap = array();
            $filterMap['status'] = ['>=',0];
            $search = input('search');
            if ($search)
            {// 模糊搜索
                $filterMap['account|mobile_phone'] = ['like','%'.$search.'%'];
            }
            // 排序
            $order = input('sort').' '.input('order');
            // 分页
            $limit = input('offset').','.input('limit');

            $list = UsersModel::with(['profile'=>function($query){$query->field('user_tid,name');}])
                    ->withCount('loginLog')
                    ->field($field)
                    ->where($filterMap)
                    ->order($order)
                    ->limit($limit)
                    ->select();
            $list = $list->toArray();

            foreach ($list as $key => $value)
            {
                // 显示用户成长明细
                $list[$key]['level_count'] = '<a href="javascript:;" onClick="levelLog('.$value['tid'].')" >'.$value['level_count'].'</a>';
                // 显示恒币消费明细
                $list[$key]['coin_count'] = '<a href="javascript:;" onClick="coinLog('.$value['tid'].')" >'.$value['coin_count'].'</a>';
                // 显示用户登录日志
                $list[$key]['login_log_count'] = '<a href="javascript:;" onClick="loginLog('.$value['tid'].')" >'.$value['login_log_count'].'</a>';
                // 显示用户角色
                $roleTitles = [];
                $roleTids = [];
                foreach ($value['roles'] as $roleKey => $roleValue) 
                {
                    $roleTids[] = $roleValue['tid'];
                    $roleTitles[] = $roleValue['title'];
                }
                $roleTitlesString = trim(implode(',', $roleTitles),',');

                $list[$key]['roles'] = '<a href="javascript:;" onClick="userRoles('.$value['tid'].",'".trim(implode(',', $roleTids),',')."'".')" >';
                $list[$key]['roles'].= empty($roleTitlesString)?'未设置':$roleTitlesString;
                $list[$key]['roles'].= '</a>';
                // 相关操作
                $list[$key]['manage'] = '<a href="javascript:;" title="用户信息" '
                						.'onClick="userInfo('.$value['tid'].')" '
                						.'style="padding-left:5px;"><i class="glyphicon glyphicon-info-sign system_icon_color"></i></a>';
            }
            $result['rows'] = $list;
            $result['total'] = UsersModel::where($filterMap)->count();
            return json($result);
        }
        else
        {
            return view();
        }
	}

    /**
     * @breif 添加用户
     **/
    public function userAdd()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            $user = new UsersModel();
            $user->account      = input('account');
            $user->mobile_phone = input('mobile_phone');
            $user->password     = password_md5(input('password','','md5'));
            $profile = new UserProfileModel();
            $profile->name      = input('name');
            $profile->sex       = input('sex');
            $profile->birthday  = input('birthday');
            $user->profile      = $profile;

            $result = $user->together('profile')->save();

            if($result)
            {
                return json(['status'=>1,'message'=>'添加用户成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'添加用户失败']);
            }
        }
        else
        {
            return view();
        }
    }

    /**
     * @breif 检查账号是否可用
     **/
    public function checkAccount()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            //检查账号是否已注册
            $where['account'] = input('param');
            $result = UsersModel::field('tid')->where($where)->find();
            if(empty($result))
            {
                return json(['status'=>'y','info'=>'该账号可以使用！']);
            }
            else
            {
                return json(['status'=>'n','info'=>'该账号已被注册！']);
            }
        }
        else
        {
            return json(['status'=>'n','message'=>'非法操作']);
        }
    }

    /**
     * @breif 检查手机时候可用
     **/
    public function checkMobilePhone()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            //检查账号是否已注册
            $where['mobile_phone'] = input('param');
            $result = UsersModel::field('tid')->where($where)->find();
            if(empty($result))
            {
                return json(['status'=>'y','info'=>'该手机号可以使用！']);
            }
            else
            {
                return json(['status'=>'n','info'=>'该手机号已被注册！']);
            }
        }
        else
        {
            return json(['status'=>'n','message'=>'非法操作']);
        }
    }

    /**
     * @breif 个人信息
     **/
    public function userInfo()
    {
        $user = UsersModel::with('profile')->find(input('tid'));

        $info = array(
            '账号'=>$user->account,
            '手机'=>$user->mobile_phone,
            '名称'=>$user->profile->name,
            '性别'=>$user->profile->sex,
            '生日'=>$user->profile->birthday,
            '感情状态'=>$user->profile->relationship,
        );
        $this->assign('info',$info);
        return view();
    }

    /**
     * @breif 修改密码
     **/
    public function changePassword()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            $user = UsersModel::field('tid,password')->find(input('session.manage_account_id'));

            $oldPSW = password_md5(input('oldpassword','','md5'));
            $newPSW = password_md5(input('newpassword','','md5'));

            if ( $oldPSW == $user['password'] )
            {
                $data = array();
                $data['tid']            = $user->tid;
                $data['password']       = $newPSW;

                $result = UsersModel::update($data);
                if ( $result )
                {
                    return json(['status'=>1,'message'=>'修改密码成功']);
                }
                else
                {
                    return json(['status'=>0,'message'=>'修改密码失败']);
                }
            }
            else
            {
                return json(['status'=>0,'message'=>'原密码错误!']);
            }
        }
        else
        {
            return view();
        }
    }

    /**
     * @breif 更改用户状态
     **/
    public function userStatus()
    {
        // 管理员-更改状态
        if ( request()->isAjax() || request()->isPost() )
        {
            $tid = input('tid');
            if($tid == 1)
            {
                return json(['status'=>0,'message'=>'不允许更改超级用户状态']);
            }
            $result = UsersModel::update(['tid'=>$tid, 'status'=>input('status')]);
            if($result)
            {
                return json(['status'=>1,'message'=>'更改用户状态成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'更改用户状态失败']);
            }
        }
        else
        {
            return json(['status'=>0,'message'=>'操作出错']);
        }
    }

    /**
     * @breif 用户角色管理
     **/
    public function userRoles()
    {
        if ( request()->isAjax() || request()->isPost() ) 
        {
            if ($this->checkParam('user_tid,role_tids')===false) 
            {
                return json(['status'=>0,'message'=>'参数有误']);
            }

            $user_tid = input('user_tid');
            $role_tids = input('role_tids/a');

            $user = UsersModel::get($user_tid);
            // 启动事务
            Db::startTrans();
            $result = true;
            try{
                // 清空中间表数据
                $user->roles()->detach();
                // 批量增加关联数据
                $user->roles()->saveAll($role_tids);
                // 提交事务
                Db::commit();    
            } catch (\Exception $e) {
                $result = false;
                // 回滚事务
                Db::rollback();
            }
            
            if($result)
            {
                return json(['status'=>1,'message'=>'关联用户角色成功']);
            }
            else
            {
                return json(['status'=>0,'message'=>'关联用户角色失败']);
            }
        }
        else 
        {
            $roles = AuthRoleModel::field('tid,title,description')
                ->where('status',1)
                ->order('sort asc')
                ->select();

            $this->assign('roles',$roles);

            $this->assign('user_tid', input('tid'));
            $this->assign('select_roles', input('roles'));
            return view();
        }
    }

    /**
     * @breif 用户成长记录
     **/
    public function levelLog()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            // 显示字段
            $field = 'tid,count,description,create_time';
            // 筛选条件
            $filterMap = array();
            $filterMap['user_tid'] = input('tid');
            // 排序
            $order = input('sort').' '.input('order');
            // 分页
            $limit = input('offset').','.input('limit');

            $list = UserLevelLogModel::field($field)
                    ->where($filterMap)
                    ->order($order)
                    ->limit($limit)
                    ->select();
            $list = $list->toArray();

            $result['rows'] = $list;
            $result['total'] = UserLevelLogModel::where($filterMap)->count();
            return json($result);
        }
        else
        {
            $this->assign('tid', input('tid'));
            return view();
        }
    }

    /**
     * @breif 恒币消费明细
     **/
    public function coinLog()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            // 显示字段
            $field = 'tid,count,description,create_time';
            // 筛选条件
            $filterMap = array();
            $filterMap['user_tid'] = input('tid');
            // 排序
            $order = input('sort').' '.input('order');
            // 分页
            $limit = input('offset').','.input('limit');

            $list = UserCoinLogModel::field($field)
                    ->where($filterMap)
                    ->order($order)
                    ->limit($limit)
                    ->select();
            $list = $list->toArray();

            $result['rows'] = $list;
            $result['total'] = UserCoinLogModel::where($filterMap)->count();
            return json($result);
        }
        else
        {
            $this->assign('tid', input('tid'));
            return view();
        }
    }

    /**
     * @breif 用户登录日志
     **/
    public function loginLog()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            // 显示字段
            $field = 'tid,platform_type,login_way,login_ip,create_time';
            // 筛选条件
            $filterMap = array();
            $filterMap['user_tid'] = input('tid');
            // 排序
            $order = input('sort').' '.input('order');
            // 分页
            $limit = input('offset').','.input('limit');

            $list = UserLoginLogModel::field($field)
                    ->where($filterMap)
                    ->order($order)
                    ->limit($limit)
                    ->select();
            $list = $list->toArray();

            $result['rows'] = $list;
            $result['total'] = UserLoginLogModel::where($filterMap)->count();
            return json($result);
        }
        else
        {
            $this->assign('tid', input('tid'));
            return view();
        }
    }
}

?>