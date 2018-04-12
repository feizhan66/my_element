<?php

/**
 * 密码md5加密方法
 */
function password_md5($string)
{
    return md5(md5($string) . 'hdquan.net');
}
/** 生成token **/
function build_token()
{
    return md5(md5('hdquan') . md5('time' . time()));
}


function get_full_url()
{
    return $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

/**
 * @desc 根据两点间的经纬度计算距离
 * @param float $lat 纬度值
 * @param float $lng 经度值
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6367000; //approximate radius of earth in meters
    /*
    Convert these degrees to radians
    to work with the formula
    */
    $lat1 = ($lat1 * pi()) / 180;
    $lng1 = ($lng1 * pi()) / 180;
    $lat2 = ($lat2 * pi()) / 180;
    $lng2 = ($lng2 * pi()) / 180;
    /*
    Using the
    Haversine formula
     
    http://en.wikipedia.org/wiki/Haversine_formula
     
    calculate the distance
    */
    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return round($calculatedDistance);
}


?>