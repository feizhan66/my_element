<?php

namespace app\manage\model;

use app\common\model\BaseModel;
use traits\model\SoftDelete;

/**
 * @brief 成长任务模型
 **/
class UserLevelTaskModel extends BaseModel
{
	// 使用软删除功能
	use SoftDelete;
    protected $deleteTime = 'delete_time';

    /** 获取器 **/
    public function getTypeAttr($value) 
    {
    	$types = array(1 => '成长任务',
    			 	   2 => '日常任务');
    	return $types[$value];
    }
	public function getStatusAttr($value)
    {
        $status = array(0 => '<span class="label label-danger" >已停用</span>',
                        1 => '<span class="label label-primary">已启用</span>');
        $toValue = $value ? 0:1;
        $result = '<a href="javascript:;" onClick="taskStatus('.$this->getData('tid').','.$toValue.')" >';
        $result.= $status[$value];
        $result.= '</a>';
        return $result;
    } 
}
