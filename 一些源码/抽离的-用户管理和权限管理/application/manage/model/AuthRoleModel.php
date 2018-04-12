<?php

namespace app\manage\model;

use app\common\model\BaseModel;

/**
 * @brief 用户角色模型
 **/
class AuthRoleModel extends BaseModel
{
	/** 获取器 **/
	public function getStatusAttr($value)
    {
        $status = array(0 => '<span class="label label-danger" >已停用</span>',
                        1 => '<span class="label label-primary">已启用</span>');
        $toValue = $value ? 0:1;
        $result = '<a href="javascript:;" onClick="roleStatus('.$this->getData('tid').','.$toValue.')" >';
        $result.= $status[$value];
        $result.= '</a>';
        return $result;
    } 
}
