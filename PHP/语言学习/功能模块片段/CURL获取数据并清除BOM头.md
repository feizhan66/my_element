# CURL获取数据并清除BOM头

```
/**
 * curl获取数据(清除了BOM头)
 * 返回的是字符串
 */
function curlGetData($url,$methods = "GET",$params = "")
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $methods);//请求的方法post,get
    curl_setopt($ch, CURLOPT_POSTFIELDS,$params);//参数
    #curl_setopt($ch, CURLOPT_TIMEOUT_MS, 30);
    #curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 10000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);//获取到该网站返回的信息
    $curl_errno = curl_errno($ch);//返回最后一次的错误号
    $curl_error = curl_error($ch);//返回错误信息
    curl_close($ch);
    $result = trim($response, "\xEF\xBB\xBF");//清除可能存在的BOM
    return $result;
}

```