<?php

namespace app\manage\controller;

/**
 * @breif 错误控制器
 **/
class ErrorController
{
    /**
     * 空方法
     **/
    public function _empty($method)
    {
        return '当前操作名：' . $method;
    }

}
