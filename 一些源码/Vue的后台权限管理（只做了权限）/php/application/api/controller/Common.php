<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/19
 * Time: 11:28
 */

namespace app\api\controller;
use think\Controller;

class Common extends Controller
{
    public function __construct(){

        // 判断请求的方法，option的方法就直接返回
        $method = request()->method();
        if ($method == 'OPTIONS'){
            exit();
        }

        $exception_urls = array(
            'oapi/Order/wechat_pay_callback',
            'oapi/Order/wechat_pay_callback_test',
            'api/Wechat/callback'
        );
        $this_url = request()->module().'/'.request()->controller().'/'.request()->action();
        if (!in_array($this_url,$exception_urls)){
//            $this->verifySign();
        }
    }

    /**
     * 检验签名
     * 没报错就是正确
     * 测试阶段，可以绕过
     */
    function verifySign(){
        $params = input('param.');
        $need_sign = $params['need_sign'];
        if (request()->domain() != "https://mf.xhzer.com"){
            if (empty($need_sign))
            {//默认跳过
                return true;
            }
        }

        try{
            //文件上传的字段跳过检验，因为post拿不了文件数据
            unset($params['file']);
            $Signature = new \utils\signature\SignatureCommon();
            if (empty($params['user_tid'])){
                $Signature->verifySignWithNoLogin($params);
            }else{
                $Signature->verifySignWithLogin($params);
            }
        }catch (\Exception $exception){
            $error_data = $exception->getMessage();
            $error_data = json_decode($error_data,true);
            exit(json_encode(['status'=>$error_data['code'],'message'=>$error_data['message']],JSON_UNESCAPED_UNICODE));
        }
        return true;

    }

    /**
     * 参数处理
     * 自带有数据类型的转换（额外加了简单参数检查）
     * 使用自带的类型转换的话就要把它写在第一位
     *
     * /s强制转换为字符串类型
     * /d强制转换为整型类型
     * /b强制转换为布尔类型
     * /a强制转换为数组类型
     * /f强制转换为浮点类型
     *
     *
     */
    public function buildParam($paramExpression = array()){
        try{
            // 默认获取所有的参数
            $params = input('param.');
            if (empty($paramExpression)){

                foreach ($params as $params_key=>$params_value){
                    if (is_array($params_value)){
                        $paramExpression[$params_key] = $params_key.'/a';
                    }else{
                        $paramExpression[$params_key] = $params_key;
                    }
                }
            }

            //执行参数处理
            foreach ($paramExpression as $expression_key=>$expression_value){

                $paramExpression[$expression_key] = input("param.{$expression_value}");

                // 参数过滤
                $deal_params = explode('/',$expression_value);
                unset($deal_params[0]);

                if ($deal_params[1] == 'a')
                {//如果是转换成数组就不用了处理了
                    //return true;
                }else{
                    foreach ($deal_params as $params_key=>$params_value)
                    { // 自己额外添加的过滤方法
                        if ($params_value == 'not_null'){
                            $paramExpression[$expression_key] = $this->not_null($paramExpression[$expression_key],$expression_key);
                        }
                    }
                }
                unset($deal_params);

            }
            return $paramExpression;

        }catch (\Exception $exception){
            exit(json_encode(['code'=>'400','message'=>$exception->getMessage()]));
        }

    }

    /**
     * 自定义的参数检查
     * @param $param
     * @param $param_name
     * @return mixed
     */
    protected function not_null($param,$param_name){

        if ($param == ""){
            exit(json_encode(['code'=>'400','message'=>$param_name.' 参数非空']));
        }else{
            return $param;
        }
    }


    // 成功返回数据时候调用
    protected function returnSuccess($data = array(), $error = array(), $pagination = null, $token = null, $response_type = 'json')
    {
        // 下面的方法写在自动加载那里
        return ReturnDatas(200,'请求成功',$data,$error,$pagination,$token,$response_type);
    }
    // 失败返回数据时候调用
    protected function returnFailure($message= '请求失败',$data = array(), $error = array(), $pagination = null, $token = null, $response_type = 'json')
    {
        // 下面的方法写在自动加载那里
        return ReturnDatas(400,$message,$data,$error,$pagination,$token,$response_type);
    }
}