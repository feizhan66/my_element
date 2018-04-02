<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/10/20
 * Time: 15:22
 */

namespace app\common\tools;

use app\common\tools\Curl;

class WeixinTools
{
    /**
     * 获取微信签名
     * GO
     */
    public function weixinSignature($url,$time,$nonceStr){
        //获取AccessToken
        $jsapi_ticket = $this->getJsapiTicket();

        //签名参数
        $sign_data = array(
            'noncestr'      =>$nonceStr,
            'jsapi_ticket'  =>$jsapi_ticket,
            'timestamp'     =>$time,
            'url'           =>trim($url),
        );

        //执行签名操作
        $signature = $this->getSignature($sign_data);

        return $signature;
    }

    /**
     * 获取AccessToken
     * GO
     */
    public function getAccessToken($token_file='./weixin_access_token'){
        // 考虑过期问题，将获取的access_token存储到某个文件中
        //filemtime()获取文件最后的修改时间
        $life_time = 7200;
        if(file_exists($token_file) && filemtime($token_file)>time()-$life_time){
            //存在有效accwss_token则返回当前
            return file_get_contents($token_file);
        }
        //目标URI
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".config('wx_gzh_id')."&secret=".config('wx_gzh_secret');
        //向该URL发送GET请求
        //注意发送GET/POST请求是不同的，如果不分清楚可能会失败
        //封装GET请求
        $result = $this->_requestGet($url);
        if (!$result) {
            return false;
        }
        //存在返回响应结果
        $result_obj = json_decode($result);
        //写入
        file_put_contents($token_file,$result_obj->access_token);
        return $result_obj->access_token;//这是对象不要用数组形式
    }



    /**
     * 获取ticket信息
     */
    public function getJsapiTicket($JsapiTicket_file = './weixin_jsapi_ticket'){
        //https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi

        $AccessToken = $this->getAccessToken();

        $life_time = 7200;
        if(file_exists($JsapiTicket_file) && filemtime($JsapiTicket_file)>time()-$life_time){
            //存在有效accwss_token则返回当前
            return file_get_contents($JsapiTicket_file);
        }
        //目标URI
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$AccessToken."&type=jsapi";
        //向该URL发送GET请求
        //注意发送GET/POST请求是不同的，如果不分清楚可能会失败
        //封装GET请求
        $result = $this->_requestGet($url);
        if (!$result) {
            return false;
        }
        //存在返回响应结果
        $result_obj = json_decode($result);
        //写入
        file_put_contents($JsapiTicket_file,$result_obj->ticket);
        return $result_obj->ticket;//这是对象不要用数组形式

    }

    /*
     * 发送GET请求援的方法
     * @param string $url URL
     * @param bool $ssl 是否为https协议，默认true
     * @return string 响应主体Content
    */
    private function _requestGet($url,$ssl=true){
        //使用curl
        $curl = curl_init();//初始化curl
        //设置curl选项
        curl_setopt($curl,CURLOPT_URL,$url);//拥有url传参
        //user_agent,请求代理信息
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl,CURLOPT_USERAGENT,$user_agent);
        //referer头,请求来源
        curl_setopt($curl,CURLOPT_AUTOREFERER,true);
        //ssl相关
        if($ssl){
            //不验证，相信微信服务器
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
            //检查服务器ssl证书中是否存在一个公用名（common name）
            //curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,1);
        }
        curl_setopt($curl,CURLOPT_HEADER,false);//是否处理响应头
        //curl_exec()是否返回响应结果
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        //发出请求
        $response = curl_exec($curl);
        if (false === $response){
            echo '<br>',curl_error($curl),'<br>';
            return false;
        }
        return $response;
    }


    /**
     * ************************************************************************
     * 微信分享->分享时获取操作
     * ************************************************************************
     */
    /**
     * 计算签名
     * @param array $arrdata 签名数组
     * @param string $method 签名方法
     * @return bool|string 签名值
     */
    public function getSignature($arrdata, $method = "sha1")
    {
        if (!function_exists($method)) {
            return false;
        }
        ksort($arrdata);
        $params = array();
        foreach ($arrdata as $key => $value) {
            $params[] = "{$key}={$value}";
        }
        return $method(join('&', $params));
    }

    /**
     * ************************************************************************
     * 获取公众号的用户信息（包括是否关注），这个跟网页授权获取信息有差异
     * ************************************************************************
     */
    /**
     * 获取公众号的用户信息
     * @param $access_token 系统的接口调用凭证
     * @param $openid 用户ID
     * todo 这条接口可以改造成批量获取微信关注用户，之后再改造
     * 注意：返回的是用户信息，包含了是否关注和关注的时间信息
     */
    public function getOfficialAccountsUserMessage($access_token,$openid){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";

        $Curl = new Curl();
        $data = $Curl->curl($url,array(),'GET',false,true);

        $data_array = json_decode($data['data'],true);
        if (!empty($data_array['errcode']))
        {//报错的话就抛出错误信息（json）
            throw new \Exception($data['data']);
        }
        return $data_array;


//        {
//            "subscribe": 1,
//           "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
//           "nickname": "Band",
//           "sex": 1,
//           "language": "zh_CN",
//           "city": "广州",
//           "province": "广东",
//           "country": "中国",
//           "headimgurl":  "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4
//        eMsv84eavHiaiceqxibJxCfHe/0",
//          "subscribe_time": 1382694957,
//          "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
//          "remark": "",
//          "groupid": 0,
//          "tagid_list":[128,2]
//        }

    }


    /**
     **************************************************************************
     * 网页授权->获取用户信息操作
     **************************************************************************
     */

    /**
     *
     * 网页授权
     *
     * 拉取微信用户信息
     *
     * 根据返回来的 code 获取 openid 和 access_token (注意：用户授权Token，跟系统的Token不一样)
     * 作用是根据这两个 openid 和 access_token 换取详细的用户信息
     *
     */
    public function getUserAccessTokenWithCode($code){
        if (!$code){
            throw new \Exception('参数错误');
        }
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config('wx_gzh_id')."&secret=".config('wx_gzh_secret')."&code={$code}&grant_type=authorization_code";

        $Curl = new Curl();
        $data = $Curl->curl($url,array(),'GET',false,true);

        $data_array = json_decode($data['data'],true);

        if (!$data_array['openid']){
            $exception_value = $data['data'];
            throw new \Exception($exception_value);
        }

        return $data_array;

        /**
         * { "access_token":"ACCESS_TOKEN",

        "expires_in":7200,

        "refresh_token":"REFRESH_TOKEN",

        "openid":"OPENID",

        "scope":"SCOPE" }
         */

    }

    /**
     * 拉取用户信息
     *
     * 先要获取到用户授权的access_token和openid
     *
     * 注意：这个参数跟网页全局的参数是不同的
     *
     */
    public function getUserMessage($accessToken,$openId){
        if (!$accessToken){
            throw new \Exception('参数错误');
        }

        // 检查参数是否有效，无效的话会抛异常
        $this->checkUserAuthParamIsEffect($accessToken,$openId);

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openId}&lang=zh_CN";

        $Curl = new Curl();
        $data = $Curl->curl($url,array(),'GET',false,true);

        $data_array = json_decode($data['data'],true);

        if (!$data_array['openid']){
            $exception_value = $data['data'];
            throw new \Exception($exception_value);
        }

        return $data_array;


        /**
         * {    "openid":" OPENID",

        " nickname": NICKNAME,

        "sex":"1",

        "province":"PROVINCE"

        "city":"CITY",

        "country":"COUNTRY",

        "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ

        4eMsv84eavHiaiceqxibJxCfHe/46",

        "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],

        "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"

        }
         */

    }

    /**
     * 检验用户授权参数是否有效
     * 先要获取到用户授权的 access_token 和 openid
     */
    public function checkUserAuthParamIsEffect($accessToken,$openId){
        $url = "https://api.weixin.qq.com/sns/auth?access_token={$accessToken}&openid={$openId}";

        $Curl = new Curl();
        $data = $Curl->curl($url,array(),'GET',false,true);

        $data_array = json_decode($data['data'],true);

        if ($data_array['errcode'] != 0){
            $exception_value = $data['data'];
            throw new \Exception($exception_value);
        }
        return true;
    }





















}