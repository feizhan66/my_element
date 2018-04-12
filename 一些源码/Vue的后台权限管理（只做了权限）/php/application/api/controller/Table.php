<?php
/**
 * Created by PhpStorm.
 * User: 小猴子
 * Date: 2018/3/19
 * Time: 15:43
 */

namespace app\api\controller;


class Table extends Common
{
    public function tableList()
    {
        $data = [
            'items' => [
                array(
                    'id' => rand(100, 1000),
                    'title' => 'title1',
                    'status' => 'dasd',
                    'author' => '黄新云',
                    'display_time' => date('Y-m-d H:i:s'),
                    'pageviews' => 2352
                ),
            ]
        ];

//        return json($items);
        return $this->returnSuccess($data);
    }
}