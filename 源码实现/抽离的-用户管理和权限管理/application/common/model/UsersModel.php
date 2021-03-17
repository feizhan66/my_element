<?php

namespace app\common\model;

/**
 * @brief 用户信息模型
 **/
class UsersModel extends BaseModel
{
    /** 模型关系 **/
    public function profile()
    {
        return $this->hasOne('UserProfileModel','user_tid','tid');
    }   
}
