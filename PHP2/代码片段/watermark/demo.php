<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2018/2/4
 * Time: 17:03
 */

// 状态：能运行

$bigImgPath = './base_image.jpg';
$img = imagecreatefromstring(file_get_contents($bigImgPath));

$font = 'Microsoft_Accor_black_Light_1.0.ttc';//字体
$black = imagecolorallocate($img, 0, 0, 0);//字体颜色 RGB

//$fontSize = 13;   //字体大小
//$circleSize = 0; //旋转角度
//$left = 51;      //左边距
//$top = 327;       //顶边距


$datas = array(
    [ // 考号
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'51',
        'top'=>'327',
        'text'=>'1340126117'
    ],
    [ // 姓名
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'160',
        'top'=>'327',
        'text'=>'黄新云'
    ],
    [ // 色彩
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'265',
        'top'=>'327',
        'text'=>'100'
    ],
    [ // 速写
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'361',
        'top'=>'327',
        'text'=>'100'
    ],
    [ // 素描
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'451',
        'top'=>'327',
        'text'=>'100'
    ],
    [ // 总分
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'545',
        'top'=>'327',
        'text'=>'300'
    ],
    [ // 专业排名
        'fontSize'=>'13',
        'circleSize'=>'0',
        'left'=>'650',
        'top'=>'327',
        'text'=>'1'
    ]
);

foreach ($datas as $data_key=>$data_value){
//    var_dump($data_value);exit();
    imagefttext($img, $data_value['fontSize'], $data_value['circleSize'], $data_value['left'], $data_value['top'], $black, $font, $data_value['text']);
}



//var_dump($img);exit();
list($bgWidth, $bgHight, $bgType) = getimagesize($bigImgPath);
switch ($bgType) {
    case 1: //gif
        header('Content-Type:image/gif');
        imagegif($img);
        break;
    case 2: //jpg
        header('Content-Type:image/jpg');
        imagejpeg($img);
        break;
    case 3: //jpg
        header('Content-Type:image/png');
        imagepng($img);
        break;
    default:
        break;
}
imagedestroy($img);













