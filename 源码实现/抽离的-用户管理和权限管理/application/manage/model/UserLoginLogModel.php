<?php

namespace app\manage\model;

use app\common\model\BaseModel;

/**
 * @brief 用户日志模型
 **/
class UserLoginLogModel extends BaseModel
{
	// Constants
	// 登录平台定义
	const PLATFORM_WEB 		= 'web';		// 网站登录
	const PLATFORM_XCX 		= 'xcx';		// 小程序登录
	const PLATFORM_ISO 		= 'ios';		// iOS客户端登录
	const PLATFORM_ANDROID 	= 'android';	// Android客户端登录
	// 登录方式定义
	const WAY_PLATFORM		= 'platform';	// 恒动平台登录
	const WAY_WECHAT		= 'wechat';		// 微信平台登录
	const WAY_QQ			= 'qq';			// QQ平台登录
	const WAY_WEIBO			= 'weibo';		// 微博平台登录

    // 开启时间字段自动写入
    protected $autoWriteTimestamp = false; 

    // 自动填充数据
    protected $auto = ['login_ip'];

    /** 修改器 **/
    public function setLoginIpAttr($value)
    {
        return request()->ip();
    }

    /** 获取器 **/
    public function getPlatformTypeAttr($value)
    {
        switch ($value) {
            case "1":       return 'WEB前端';
            case "2":       return '小程序';
            case "3":       return '安卓客户版';
            case "4":       return '苹果客户版';
            case "5":       return '安卓商家版';
            case "6":       return '苹果商家版';
            case "7":       return 'WEB管理后台';
            default:                                    return '未知';
        }
    }
    public function getLoginWayAttr($value)
    {
        switch ($value) {
            case UserLoginLogModel::WAY_PLATFORM:       return '恒动账号';
            case UserLoginLogModel::WAY_WECHAT:         return '微信账号';
            case UserLoginLogModel::WAY_QQ:             return 'QQ账号';
            case UserLoginLogModel::WAY_WEIBO:          return '微博账号';
            default:                                    return '未知';
        }
    }
}
