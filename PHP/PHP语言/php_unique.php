<?php
/**
 * 简单的获取唯一值的方法（有重复但是应付一般情况够用了）
 */

function create_unique() {
    $data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']
        .time() . rand();
    return sha1($data);
    //return md5(time().$data);
}
echo create_unique();
echo "<br>";
echo uniqid("php_",true);
echo "<br>";
//echo random_int(5,6);
//echo more_entropy('6',56);