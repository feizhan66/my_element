<?php

namespace app\api\controller;

class CONFIG
{
    // API接口状态集合
    const API_STATUS_SUCCESS        = 200;  //请求成功
    const API_STATUS_FAILURE        = 400;  //请求失败
    const API_STATUS_AUTHORIZATION  = 401;  //授权失败

    const API_STATUS_SUCCESS_MESSAGE        = '请求成功';
    const API_STATUS_FAILURE_MESSAGE        = '请求失败';
    const API_STATUS_AUTHORIZATION_MESSAGE  = '授权失败';

    // API接口错误代码
    const ERROR_CODE_PARAM_MISS             = 1;    // 缺少参数
    const ERROR_CODE_FAILURE                = 2;    // 获取数据失败
    const ERROR_CODE_API_EXPIRED            = 11;   // API接口请求超时
    const ERROR_CODE_API_TOKEN_FAILURE      = 12;   // 校验码(token)错误
    const ERROR_CODE_USE_LOGIN_EXPIRED      = 21;   // 用户登录授权超时
    const ERROR_CODE_CONTROLLER_NOT_FIND    = 51;   // 控制器不存在
    const ERROR_CODE_ACTION_NOT_FIND        = 52;   // 函数/方法不存在
    const ERROR_CODE_WX_USER_NOT_REGISTER   = 53;   // 该微信用户尚未注册
    const ERROR_CODE_WX_LOGIN_ERROR         = 54;   // 微信登陆失败



    // 恒动币使用说明
    const COIN_USE_DESC_CREATE_ORDER        = '订单抵扣';
    const COIN_USE_DESC_CANCEL_ORDER        = '订单退回';

    // 验签错误代码
    const ERROR_CODE_SIGNATURE_PARAM_MISS   = 5001;         // 签名参数错误
    const ERROR_VALUE_SIGNATURE_PARAM_MISS  = "签名参数错误"; // 签名参数错误

    const ERROR_CODE_SIGNATURE_GET_PRIVATE_FAILURE   = 5002;            // 签名私钥获取失败
    const ERROR_VALUE_SIGNATURE_GET_PRIVATE_FAILURE  = "系统校验签名出错"; // 签名私钥获取失败

    const ERROR_CODE_SIGNATURE_GET_TOKEN_FAILURE      = 5003;             // KEY交换失败
    const ERROR_VALUE_SIGNATURE_GET_TOKEN_FAILURE     = "Token交换失败";      // KEY交换失败

    const ERROR_CODE_SIGNATURE_UPDATE_FAILURE       = 5004;             // 签名更新失败
    const ERROR_VALUE_SIGNATURE_UPDATE_FAILURE      = "签名更新失败";     // 签名更新失败

    const ERROR_CODE_SIGNATURE_USER_LOGIN_PAST_DUE       = 5005;             // 用户登录已过期
    const ERROR_VALUE_SIGNATURE_USER_LOGIN_PAST_DUE      = "用户登录已过期";     // 签名更新失败

    const ERROR_CODE_SIGNATURE_TOKEN_CONFLICT       = 5006;//Token冲突(数据库已存在)
    const ERROR_VALUE_SIGNATURE_TOKEN_CONFLICT      = "Token冲突";//Token冲突(数据库已存在)

    const ERROR_CODE_SIGNATURE_OVER_TIME       = 5007;         //操作超时
    const ERROR_VALUE_SIGNATURE_OVER_TIME      = "操作超时";    //操作超时

    const ERROR_CODE_SIGNATURE_FAILURE = 5008;
    const ERROR_VALUE_SIGNATURE_FAILURE = "系统签名失败";


    // 成功代码
    const SUCCESS_CODE_SIGNATURE_CREATE     = 2001;         // 签名创建成功
    const SUCCESS_VALUE_SIGNATURE_CREATE    = "签名创建成功"; // 签名创建成功

    const SUCCESS_CODE_SIGNATURE_UPDATE     = 2002;                     // 签名创建成功
    const SUCCESS_VALUE_SIGNATURE_UPDATE    = "签名更新成功(不带用户信息)"; // 签名创建成功

    const SUCCESS_CODE_SIGNATURE_UPDATE_WITH_USER     = 2003;                   // 签名创建成功
    const SUCCESS_VALUE_SIGNATURE_UPDATE_WITH_USER    = "签名更新成功(带用户信息)"; // 签名创建成功



}

?>