<?php

namespace app\manage\model;

use app\common\model\BaseModel;
use app\manage\model\UserCoinLogModel;

/**
 * @brief 用户模型
 **/
class UsersModel extends BaseModel
{
    // 追加读取属性
    protected $append = ['roles', 'coin_count', 'level_count'];

	/** 模型关系 **/
    // 用户角色
    public function roles()
    {
        return $this->belongsToMany('AuthRoleModel','auth_role_access','role_tid','user_tid')
                    ->field('tid,title');
    }
    // 用户信息
    public function profile()
    {
        return $this->hasOne('UserProfileModel','user_tid','tid');
    }

    // 用户日志  
    public function loginLog()
    {
    	return $this->hasMany('UserLoginLogModel','user_tid','tid');
    }

	/** 获取器 **/
	public function getStatusAttr($value)
    {
        $status = array(0 => '<span class="label label-danger" >已停用</span>',
                        1 => '<span class="label label-primary">已启用</span>');
        $toValue = $value ? 0:1;
        $result = '<a href="javascript:;" onClick="userStatus('.$this->getData('tid').','.$toValue.')" >';
        $result.= $status[$value];
        $result.= '</a>';
        return $result;
    } 
    /** 获取器 **/
    public function getCoinCountAttr($value)
    {
        //$totalCount = UserCoinLogModel::where('user_tid',$this->getData('tid'))->sum('count');
    	return $totalCount ? $totalCount:0;
    }
    public function getLevelCountAttr($value)
    {
        //$totalCount = UserLevelLogModel::where('user_tid',$this->getData('tid'))->sum('count');
        return $totalCount ? $totalCount:0;
    }
}
