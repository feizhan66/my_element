<?php
namespace app\manage\controller;

use think\Controller;
use think\Db;
use think\Session;
use app\manage\model\UsersModel;
use app\manage\model\UserProfileModel;
use app\manage\model\UserLoginLogModel;
use think\captcha\Captcha;

/**
 * @brief 用户登录与登出控制器
 **/
class LoginController extends Controller
{
    /**
     * @brief 登陆页面
     **/
    public function index()
    {
        return view();
    }

    /**
     * @brief 检查用户登录
     **/
    public function checkLogin()
    {
        if ( request()->isAjax() || request()->isPost() )
        {
            $verify = input('verify');
            if(!captcha_check($verify))
            {
                return json(['data'=>$verify,'status'=>0,'message'=>'验证码错误']);
            }
            else
            {
                //查询账户
                $account    = input('account');             // 获取账号
                $password   = input('password','','md5');   // 获取密码

                $filterMap = array();
                $filterMap['account|mobile_phone']  = $account;
                $filterMap['password']              = password_md5($password);

                $user = UsersModel::with(['profile'=>function($query){$query->field('user_tid,name,sex,birthday');}])
                        ->where($filterMap)
                        ->find();
                // 判断用户名或密码是否正确
                if(!$user)
                {
                    return json(['data'=>$user,'status'=>0,'message'=>'用户名或密码错误']);
                }
                else
                {
                    // 判断用户是否后台管理员
                    // 获取用户组信息
                    if ($user->roles)
                    {
                        // 显示用户角色
                        $roleTitles = [];
                        $roleTids = [];
                        foreach ($user->roles as $key => $role) 
                        {
                            $roleTids[] = $role->tid;
                            $roleTitles[] = $role->title;
                        }
                        // 用户角色设置
                        session('manage_role_ids', trim(implode(',', $roleTids),','));      // 用户组ID
                        session('manage_role_titles', trim(implode(',', $roleTitles),',')); // 用户角色名称
                    }
                    // 判断用户是否被锁定
                    if ($user->getData('status')==0)
                    {
                        return json(['data'=>$user,'status'=>0,'message'=>'用户被锁定，请联系恒动科技']);
                    }
                    // 设置Session
                    // 用户设置
                    session('manage_account_id', $user->tid);                       // 用户ID
                    session('manage_account_name', $user->profile->name);           // 用户昵称
                    session('manage_account_sex', $user->profile->sex);             // 用户性别
                    session('manage_account_birthday', $user->profile->birthday);   // 用户性别
                    // 系统设置
                    session('manage_system_name', '恒动后台管理系统');  // 系统名称

                    // 更改用户最后一次登录时间和IP
                    $userLog = new UserLoginLogModel();
                    $userLog->user_tid = $user['tid'];
                    $userLog->platform_type = '7';
                    $userLog->login_way= UserLoginLogModel::WAY_PLATFORM;
                    $userLog->is_effect = '1';
                    $userLog->create_time = time();
                    $userLog->effect_time = time() + 7*24*60*60;
                    $userLog->update_time = time();
                    $userLog->save();

                    return json(['data'=>$user,'status'=>1,'message'=>'登陆成功']);
                }
            }
        }
        else 
        {
            return json(['status'=>0,'message'=>'非法操作']);
        }
    }

    /**
     * @brief 用户登出
     **/
    public function logout()
    {
        // 清除SESSION
        Session::clear();
        // 跳转回登录页面
        $this->redirect('manage/Login/index');
    }

    /**
     * 验证码
     */
    public function captcha_image(){
        $config = [
            'codeSet'=>'0123456789',
            'useCurve'=>false,
            'useNoise'=>false,
            'reset'=>false,
            'length'=>4,
            'fontSize'=>45
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();

    }

    /**
     * @brief 验证码
     **/
    function captcha_src($id = "")
    {
        return \think\Url::build('/captcha' . ($id ? "/{$id}" : ''));
    }

}
