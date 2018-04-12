<?php

namespace app\manage\model;

use app\common\model\BaseModel;
use app\manage\model\UsersModel;

/**
 * @brief 用户信息模型
 **/
class UserProfileModel extends BaseModel
{
    // 数据类型转换
//    protected $type = [
//        'birthday' => 'timestamp:Y-m-d',
//    ];

	/** 模型关系 **/
    public function user()
    {
        return $this->belongsTo('UsersModel','user_tid','tid');
    }   
    
	/** 获取器 **/
	public function getSexAttr($value)
    {
        $sex = array(0 => '未知',
                     1 => '男',
                     2 => '女');
        return $sex[$value];
    } 
    public function getRelationshipAttr($value) 
    {
        $relationship = array(0 => '保密', 1 => '单身', 2 => '已婚' );
        return $relationship[$value];
    }
}
