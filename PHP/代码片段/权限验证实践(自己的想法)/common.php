<?php
//设置api基础主机
function host_domain()
{
    return request()->domain();
}

//设置api图片资源主机
function host_img()
{
    return request()->domain();
}

//设置api文件资源主机
function host_file()
{
    return request()->domain();
}

//设置返回规范
function ReturnDatas($status, $message, $data = array(), $error = array(), $pagination = "", $token = "", $response_type = 'json')
{

    //现在是测试阶段
    $need_sign = input('param.need_sign');
    if ($need_sign){
        //执行签名
        $data['sign_tid'] = input('param.sign_tid');
        $SignatureCommon =new \app\common\controller\SignatureCommon();
        $data = $SignatureCommon->getSignValue($data); // 执行签名操作，如果签名失败则不会有参数返回
        if (!$data)
        {//签名失败
            $status = "5008";
            $message = "系统签名失败";
        }
    }


    $return = array();
    if ($status) {
        $return['status'] = (int)$status;
    } else {
        $return['status'] = 0;
    }

    if ($message) {
        $return['message'] = $message;
    }
    else
    {
        $return['message'] = '访问失败';
    }

    if (!empty($pagination))
    {
        $return['pagination'] = $pagination;
    }

    if (!empty($data)) {

        $return['data'] = $data;

    } else {
        $return['data'] = array();
    }

    if (!empty($error)) {
        $return['error'] = $error;
    } else {
        $return['error'] = array('code' => '');
    }


//    if ($token) {
//        $return['token'] = $token;
//    }

    header("token:{$data['token']}");
    header("Access-Control-Allow-Origin:*");

    if ($response_type == 'jsonp') {
        return jsonp($return);
    } else {
        return json($return);
    }
}
// 错误方法
function ReturnError($errorCode, $errorMsg)
{
    $error = new \stdClass();
    $error->code = $errorCode;
    $error->message = $errorMsg;
    return $error;
}
//分页的方法
function Pagination($total, $size = '10', $page = '0')
{
    $total = (int)$total;
    $size = (int)$size;
    $page = (int)$page;
    if ($total) {
        if ($total >= 0 && $size > 0 && $page+1 > 0) {
            $total_page = ceil($total / $size);
            return array(
                'size' => $size,
                'page' => $page,
                'total' => $total,
                'total_page' => $total_page
            );
        }
    }
    return false;
}
?>