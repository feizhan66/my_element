<?php
$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCCyPUh2FgtJsboGJyAhtkjMyUxEVLQ6wV5EfkenchSBzilGlHg3OKhmEZZiAuOZraEVJ/zlZi4aI30WBU1RStLTh0Kj6sIy45+BWEYsrZIR6nVDp6EVAiRxknbb4KX6FvcVjyObp5cT7eJj5IsrsWAmFrRzppHfCCTN+Kwlwu73mVdn2GH3f2m2uRNldZVa6nrYjQgbWaComtqgFhH/8meZXlwy4WdKqOc9klUupqYnrnNle0aInWBhKVkfFHpw1UeebsLoO3XiiHzkEsONqffpkrrslXOW43PbsKMBnmJD8IYnWScqKqQSn+IaxYr7Nvfuy067tJbZ2r+mxCCq195AgMBAAECggEAeQnc/EbKTHc/zNvCM50ZZl9WQ1QiDiIEfakporEqDOiL/xkdv/sNb7qLGR80esUKk+vx4LCJl9mDzyiZ8CQkzlvrurN9+fTR2kXGN+Jlmv1f60PNZvCSwb7+6awI8+fi5EeXYcZ0n0BTv2b1RI83UC0wmE4aMKBrUXR+Qyp3fJUjC4OD8cqpGKAjp5tWR7amjBYwhoXUpjdnxgEz0hucbe+t87TWq2tGlyhW1BIeblp6PoppCgivLkfRJiPXZ6DDqyC3Mze56fe9dMEJ/AWs1rREG3ziSku+78R64DDbFyly03Cocyh1uhWJaVl89s6YhxuZaEXgGKcFQ2kJVvrn5QKBgQC4+A2c2bd2n2eZZG7BJBuwo1+n2Nlijk+soFR5NKMx//LnpBKCvRIZK8O2xHY9FufSqy+bwo3NyYWlFs2GJxZUqAjEsBIAScmn0NKtVwAf5Lq9ZVHGihBaENLVKh9CO4uWPPlGaauHumTtunUN7hF2mdOALHe3o/gIN2BrNroB/wKBgQC1Ai52A1OWpQSH8HraI+Hf+H4T5r6iuspLFcku2JyL9pNw6P55dKpzkGFvcxXLuqX2adDfMvIm4Y2tTY5kHlDKTX13i8sLEyZHgpqj1eHdKDmad3pg+AQ87TzrjVGaQxFVbsHAjw5WBse37CTY41QSxY1RAL4R9vk21IXrVMeuhwKBgQCJruL7ITimTOuhy5eBny4ZYtLeLtVJvmLiPYoDmsHrgvi9omzA8poZMHGDh2P3/yfaseBDUiOZzer0QzADLu85XscAGYucuVAo4ZEgxETseKbkOhoP7k9Tq3g0giE4fPhfgc2PszKiWoWsS4G8N7y6CrDblL4cbSpAe3AC/n6g4wKBgA/AU9izK2f1jjJiK96ltrctwZLrxnUUuhvUloA8G0tWtrfhnptlGpwZ2VDAfAoRgPWzeZiir03Q3OpS0GxH8xHXsm5fvNiG3xLj+578Mr5zDKgzc3PSwVOn9WAuGQbKhUyg6b1e9Ylo56JKq14wUhWcGVMONHwNuNwbnFfBNesrAoGAYXY5dCKdQLWoWbT04AZ/6QsYzolE8MLeFEaf1/gWjNAygAJyCaQ03LT5wDbNLPDExMM1TuaYgBcszSUciln0xHGX9OGaphMM9QL5RU79Y8QhpRfqBwKQq78lBEODm8Ypa2wMpOsXFstgutIoFawfBI0sWNaKHyrImqgREuzlexY=
-----END RSA PRIVATE KEY-----';

$public_key = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgsj1IdhYLSbG6BicgIbZ
IzMlMRFS0OsFeRH5Hp3IUgc4pRpR4NzioZhGWYgLjma2hFSf85WYuGiN9FgVNUUr
S04dCo+rCMuOfgVhGLK2SEep1Q6ehFQIkcZJ22+Cl+hb3FY8jm6eXE+3iY+SLK7F
gJha0c6aR3wgkzfisJcLu95lXZ9hh939ptrkTZXWVWup62I0IG1mgqJraoBYR//JnmV5cMuFnSqjnPZJVLqamJ65zZXtGiJ1gYSlZHxR6cNVHnm7C6Dt14oh85BLDjan
36ZK67JVzluNz27CjAZ5iQ/CGJ1knKiqkEp/iGsWK+zb37stOu7SW2dq/psQgqtf
eQIDAQAB
-----END PUBLIC KEY-----";

//$dd = fopen('./aa.txt','w+');
//fwrite($dd,$public_key);
//file_put_contents('./aa.txt',$public_key);

//echo $private_key;
$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
print_r($pi_key);echo "<br>";
print_r($pu_key);echo "<br>";


//        $sign_old_tid   = $params['sign_old_tid'];
//        $sign_old_token = $params['sign_old_token'];
//        $sign_token     = $params['sign_token'];
//        $sign_platform  = $params['sign_platform'];
//        $operate_time   = $params['operate_time'];        // 操作时间

$token_value = array(
    'sign_old_tid'=>'1',
    'sign_old_token'=>'aassssasssddd',
    'sign_token'=>'aassssasssddd3',
    'sign_platform'=>'1',
    'sign_time'=>time()
);

$data = json_encode($token_value);//原始数据
//$data = $token_value;//原始数据
$encrypted = "";
$decrypted = "";

echo "source data:",$data,"<br>";

echo "private key encrypt:<br>";

openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密
$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
echo $encrypted,"<br>";

echo "public key decrypt:<br>";

openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来
echo $decrypted,"<br>";

echo "---------------------------------------<br>";
echo "public key encrypt:<br>";

openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
$encrypted = base64_encode($encrypted);
echo $encrypted,"<br>";

echo "private key decrypt:<br>";
openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
echo $decrypted,"<br>";