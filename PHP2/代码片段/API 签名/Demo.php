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
            $Signature = new SignatureCommon();
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