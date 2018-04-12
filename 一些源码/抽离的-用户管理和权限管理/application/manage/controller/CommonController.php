<?php

namespace app\manage\controller;

use think\Controller;
use think\Request;

/**
 * @breif 基础控制器
 **/
class CommonController extends Controller
{
    /**
     * @breif 构造方法
     **/
    public function _initialize()
    {
        $not_session = array();
        //session不存在时，不允许直接访问
        if (!session('manage_account_id')) {
            $this->redirect('manage/Login/index');
        }

        $request = Request::instance();
        // session存在时，不需要验证的权限
        $not_check = array();
        $not_check = array_merge($not_session, $not_check);
        // 当前操作的请求  [模块名/方法名]
        if (in_array($request->module() . '/' . $request->controller() . '/' . $request->action(), $not_check)) {/*这里是临时开放权限*/
            return true;
        }
        //下面代码动态判断权限
        $auth = new UserAuth();

        if (!$auth->check($request->module() . '/' . $request->controller() . '/' . $request->action(), session('manage_account_id'))
            && session('manage_account_id') != 1 && session('manage_account_id') != 10
        ) {
            if (request()->isAjax() || request()->isPost()) {
                exit(json_encode(['status' => 0, 'message' => '您没有操作权限！']));
            } else {
                $this->error('您没有操作权限！');
            }
        }

    }

    public function authErrorJson()
    {
        return json_encode(['status' => 0, 'message' => '您没有操作权限！']);
    }

    /**
     * 空方法
     **/
    public function _empty($method)
    {
        if (request()->isAjax() || request()->isPost()) {
            return '当前操作名:' . $method . ' [Ajax Or Post]';
        } else {
            return '当前操作名:' . $method . ' [Html]';
        }
    }

    /**
     * 检查参数
     * @param  params  string|array    需要验证的参数列表,支持逗号分隔的权限规则或索引数组
     * @return         boolean         通过验证返回true;失败返回false
     */
    protected function checkParam($params)
    {
        if (is_string($params)) {
            $params = trim($params, ',');
            if (strpos($params, ',') !== false) {
                $params = explode(',', $params);
            } else {
                $params = array($params);
            }
        }

        foreach ($params as $key => $value) {
            if (input('?' . $value) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * 校验管理者的权限
     * --开发中
     * 逻辑：查询管理员对应的场馆首先是必须要有权限访问(由于这个权限的校验已经在前面已经校验过，所以这里不必再进行权限的校验)
     * 注意：一个用户只允许管理一个场馆
     * @return int/bool
     */
    protected function checkStadiumAdminAuth()
    {
        $user_id = session('manage_account_id');
        $stadium_tid = db('sport_stadium_user')->where(['user_tid' => $user_id])->value('stadium_tid');
        if ($stadium_tid) {
            return $stadium_tid;
        } else {
            return false;
        }
    }

}
