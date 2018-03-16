<?php
/**
 * 循环遍历数组，把多维数组里面的 null 转换为空字符串
 */



$arr = [
    'name'=>'',
    'huang'=>'dd',
    'xin'=>null,
    'yun'=>[
        'dd'=>'',
        'ff'=>null,
        'fff'=>[
            'hh'=>'ff'
        ]
    ]
];

function deals($arr){
    foreach ($arr as $arr_key=>$arr_value){
        if (is_array($arr_value)){
            $arr[$arr_key] = deals($arr_value);
        }
        if ($arr_value == null){
            $arr[$arr_key] = '';
        }
    }
    return $arr;
}

$dd = deals($arr);
var_dump($dd);
