<?php

namespace app\common\model;

use think\Model;

/**
 * @brief 基础数据模型
 **/
class BaseModel extends Model
{
	// 设置模型返回数据类型为数据集
    protected $resultSetType = 'collection';
    // 开启时间字段自动写入
    protected $autoWriteTimestamp = true; 
    // 定义时间字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
}
