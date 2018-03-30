# 


```
    /**
     * 微信企业红包发送
     * （内部调用）
     */
    private function sendWeixinCompanyRedPacket($openid,$total_amount,$mch_billno){

//        $openid         = "ocylLwZOeNONXWkrFwZIws81Sa0A";
//        $total_amount   = "100";//红包总金额
//        $mch_billno     = "201711201806114";//商户订单号
        $sendname       = "恒动圈";//商户名称
        $wishing        = "助威桥南商会运动会，18888大红包等你来拿";//红包祝福语
        $act_name       = "助威桥南商会运动会";//活动名称
        $remark         = "备注";

        // 实例支付接口
        $pay = & load_wechat('Pay','gzh');
        // 获取支付通知
        $notifyInfo = $pay->sendRedPack($openid, $total_amount, $mch_billno, $sendname, $wishing, $act_name, $remark, $total_num = 1, $scene_id = null, $risk_info = '', $consume_mch_id = null);
        //$notifyInfo = "66";

        return $notifyInfo;

    }

```