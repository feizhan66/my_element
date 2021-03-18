<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/7/24
 * Time: 9:37
 * 处理微信/小程序的用户信息
 */

namespace app\common\controller;

use app\common\model\UserOauthModel;

class WxUserController
{
    /**
     * 小程序
     * 小程序登陆、校验
     */
    public function WxXcxLogin($code)
    {
        if ($code) {
            $WxMsg = self::WxXcxCodeGetMsg($code);
//            dump($WxMsg);
            if ($WxMsg['status'] == 'success') {
                $open_id = $WxMsg['data']['openid'];
                $oauth_tid = UserOauthModel::wx_xiao_cheng_xu_tid;//小程序代号
                $user_msg = db('user_oauth')->where(['oauth_openid' => $open_id, 'oauth_tid' => $oauth_tid])->field('tid,user_tid,oauth_openid,oauth_unionid')->find();
                //该用户已经存在的情况
                if ($user_msg) {
                    //判断用户的注册状态
                    if (empty($user_msg['user_tid'])) {
                        //用户还没注册/关联
                        $oauth_tid = UserOauthModel::wx_login_not_register;//没注册的
                        $user_msg['user_status'] = $oauth_tid;
                    } else {
                        $oauth_tid = UserOauthModel::wx_login_user_succ;//微信登陆正常的
                        $user_msg['user_status'] = $oauth_tid;
                    }
                    return array('status' => 'success', 'data' => $user_msg);
                } else {
                    //还不存在的话就要插入
                    $oauth_name = UserOauthModel::wx_xiao_cheng_xu_name;
                    $oauth_tid = UserOauthModel::wx_xiao_cheng_xu_tid;

                    $userAddMsg = UserOauthModel::create(['oauth_name' => $oauth_name, 'oauth_tid' => $oauth_tid, 'oauth_openid' => $open_id]);
                    $upData = $userAddMsg->toArray();
                    $upData['user_status'] = UserOauthModel::wx_login_not_register;//还没注册

                    return array('status' => 'success', 'data' => $upData);
                }
            }
            return $WxMsg;
        }
        return array('status' => 'error', 'msg' => '请正确输入Code');
    }

    /**
     * 小程序
     * 根据小程序的Code获取微信用户ID
     * @return array session_key,expires_in,openid
     */
    public function WxXcxCodeGetMsg($code)
    {
        if (!empty($code)) {
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . config('wx_xcx_appid') . "&secret=" . config('wx_xcx_secret') . "&js_code=" . $code . "&grant_type=authorization_code";
            $curl = new CurlController();
            $value = $curl->curl($url, array(), 'GET', '', true);
            if ($value) {
                if ($value['status'] == 'succ') {
                    $re_data = json_decode($value['data'], true);
                    if ($re_data['openid']) {
                        return array('status' => 'success', 'msg' => '获取用户信息成功', 'data' => $re_data);
                    }
                    return array('status' => 'error', 'msg' => $re_data['errmsg']);
                }


            }
        }
        return array('status' => 'error','msg'=>'Code参数错误');
    }

}