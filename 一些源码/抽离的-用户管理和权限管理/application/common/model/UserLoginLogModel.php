<?php

namespace app\common\model;

use app\common\model\BaseModel;

/**
 * @brief 用户日志模型
 **/
class UserLoginLogModel extends BaseModel
{
	// Constants
	// 登录平台定义

	// 登录方式定义
	const WAY_PLATFORM		= 'platform';	// 恒动平台登录
	const WAY_WECHAT		= 'wechat';		// 微信平台登录
	const WAY_QQ			= 'qq';			// QQ平台登录
	const WAY_WEIBO			= 'weibo';		// 微博平台登录

    // 开启时间字段自动写入
    protected $autoWriteTimestamp = false; 
    // 数据类型转换
    protected $type = [
        'login_time' => 'timestamp:Y-m-d H:i:s',
    ];
    // 自动填充数据
    protected $auto = ['login_ip','login_time'];

    /** 修改器 **/
    public function setLoginIpAttr($value)
    {
        return request()->ip();
    }
    public function setLoginTimeAttr($value) 
    {
    	return time();
    }

    /** 获取器 **/
    public function getDeviceTypeAttr($value)
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
