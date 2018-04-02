<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2017/11/23
 * Time: 9:06
 * 关于微信公众号的杂七杂八的内容都放这里
 */

namespace app\api\controller;
use think\Controller;
use think\Db;
use app\common\controller\WeixinCommon;
use app\api\controller\ActivityController;


class WeChatController extends Controller
{

    /**
     * 获取用户信息
     * 微信的code回调页面
     *
     * 操作：保存微信用户信息到数据库，设置session
     *
     */
    public function dealWeixinUserMessage(){
        $param = input('param.');


        $code = $param['code'];
        $jump_url = $param['jump_url'];

        if (!empty($jump_url)){
            $jump_url = base64_decode($jump_url);
        }else{
            $jump_url = url('index/app_download/download');
        }

        $weixin = new WeixinCommon();
        try{
            //根据Code获取微信用户信息
            $user_message = $weixin->getUserMessage($code);
            // 保存微信用户信息
            // 判断这个用户是否已经登录
            $weixin_user = Db::name('weixin_user')
                ->where(['openid'=>$user_message['openid']])
                ->find();

            if (!$weixin_user)
            {//不存在的话就插入
                $weixin_user_tid = Db::name('weixin_user')->insertGetId($user_message);
            }else{
                $weixin_user_tid = $weixin_user['tid'];
            }

            //设置session
            session('weixin_unionid',$user_message['unionid']);

            session('weixin_openid',$user_message['openid']);

            session('weixin_user_tid',$weixin_user_tid);

        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
//        dump($param);
//        dump($_SESSION);
//        exit();
        $this->redirect($jump_url);

    }

    /**
     * 微信公众号消息入口
     * (微信调)
     */
    public function WeChatOfficialAccountMessage(){
        define("TOKEN", "weixin");

        if (!isset($_GET['echostr'])) {
            $this->responseMsg();
        }else{
            $this->valid();
        }
    }

    /**
     * 微信公众号菜单Demo
     * 调用此接口，就能修改微信公众号里面的菜单
     */
    public function weChatMenu(){
        $data = array(
            'button'=>array(
                array(
                    'name'=>'Pa姐教你',
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>'历史消息',
                            'url'=>'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI0MjkyODQ5OQ==&scene=124#wechat_redirect'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>'使用指南',
                            'url'=>'http://mp.weixin.qq.com/s/MchUJ9vSlXY6HQNHlpo5gQ'
                        )
                    )
                ),
                array(
                    'name'=>'恒动圈',
                    'sub_button'=>array(
                        array(
                            'type'=>'miniprogram',
                            'name'=>'打开小程序',
                            'url'=>'http://mp.weixin.qq.com',
                            'appid'=>'wx7fa3e2d2659658f1',
                            'pagepath'=>'pages/index/index'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>'下载客户版',
                            'url'=>'https://hdquan.net/index/app_download/download_user'
                        ),
                        array(
                            'type'=>'view',
                            'name'=>'下载商家版',
                            'url'=>'https://hdquan.net/index/app_download/download'
                        )
                    )
                ),
                array(
                    'name'=>'企业约赛',
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>'桥南街商会运动会助威',
                            'url'=>'https://hdquan.net/index/activity/index'
                        )
                    )
                )

            )
        );

//        $data = json_encode($data);
        //echo($data);

        $tools = new \app\common\tools\WeixinTools();
        $getAccessToken = $tools->getAccessToken();
//        dump($getAccessToken);
//        exit();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$getAccessToken}";
        $curl = new \app\common\tools\Curl();
        $dd = $curl->curl($url,$data,"POST",false,true,true);
        dump($dd);

    }

    /**
     * *****************************************************************
     * 下面是微信消息的处理方法
     * *****************************************************************
     */


    public function valid()
    {

        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){   //调用 -> checkSignature()官方验证消息真实性方法
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()    //checkSignature()官方验证消息真实性方法
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);  //对数组 $tmpArr 中的元素按数字进行升序排序：
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );//哈希

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"]; //$GLOBALS["HTTP_RAW_POST_DATA"] 获取text/xml等数据（与POST作用差不多）
        if (!empty($postStr)){
            //simplexml_load_string转换形式良好的 XML 字符串为 SimpleXMLElement 对象，然后输出对象的键和元素，就是XML转换为数组
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);//制定删除首部和尾部返回的string

            //用户发送的消息类型判断
            switch ($RX_TYPE)
            {
                case "text":    //文本消息
                    //$result = $this->receiveText($postObj);
                    break;
                case "image":   //图片消息
                    //$result = $this->receiveImage($postObj);
                    break;
                case "voice":   //语音消息
                    //$result = $this->receiveVoice($postObj);
                    break;
                case "video":   //视频消息
                    //$result = $this->receiveVideo($postObj);
                    break;
                case "location"://位置消息
                    //$result = $this->receiveLocation($postObj);
                    break;
                case "link":    //链接消息
                    //$result = $this->receiveLink($postObj);
                    break;
                case "event":   //事件类型
                    //事件类型，subscribe(订阅)、unsubscribe(取消订阅)
                    $result = $this->receiveEvent($postObj);
                    break;
                default:
                    //$result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
//            echo $result;
            echo "";
        }else {
            echo "";
            exit;
        }
}

    /**
     * 接收事件类型信息
     * 事件类型有多种，一种是直接操作->Event事件类型，subscribe(订阅)、unsubscribe(取消订阅)
     * 扫描带参数二维码->...
     */
    public function receiveEvent($object){
        //关注事件(subscribe),取消关注事件(unsubscribe)
        $Event = $object->Event;

        switch ($Event)
        {
            case "subscribe":
                //关注事件
                $activity = new ActivityController();
                $result = $activity->weChatUserAttentionSendRedPacket($object->FromUserName);

                return $result;
                break;
            case "unsubscribe":
                //取关事件
                break;
            default:
                //
                break;
        }
    }

    /*
     * 接收文本消息
     */
    private function receiveText($object)
    {

        $content = "你发送的是文本，内容为：".$object->Content;
        //$res = $this->send_myself($object);
        $result = $this->transmitText($object, $content);

        return $result;
    }

    /**
     * 发送到自己的服务器
     */
    public function send_myself($object){
        /*
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://hxy995116474.xicp.net/phpStorm/myself/index.php/home/diary/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$object);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $ret = curl_exec($ch);
        curl_close($ch);
       return $ret;
       */
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "http://feizhan.me/myself/index.php/home/diary/diary_go_weixin/");
        //curl_setopt($ch, CURLOPT_URL, "http://hxy995116474.xicp.net/phpStorm/LifeSteward/public/api/Causerie/causerie/");
        curl_setopt($ch, CURLOPT_URL, "http://feizhan.me/public/api/Causerie/causerie/");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$object);
        #curl_setopt($ch, CURLOPT_TIMEOUT_MS, 30);
        #curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 10000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        return $response ;
    }

    /*
     * 接收图片消息
     */
    private function receiveImage($object)
    {
        $content = "你发送的是图片，地址为：".$object->PicUrl;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收语音消息
     */
    private function receiveVoice($object)
    {
        $content = "你发送的是语音，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收视频消息
     */
    private function receiveVideo($object)
    {
        $content = "你发送的是视频，媒体ID为：".$object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收位置消息
     */
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收链接消息
     */
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 回复文本消息
     */
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);// sprintf把格式数据写成串（函数指令）

        return $result;
    }





}