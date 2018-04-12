<?php
namespace app\index\controller;

class Index
{
    public function index()
    {

        $a = new \utils\signature\SignatureCommon();
        $f = $a->buildSignWithLogin([]);
        dump($f);
        echo "demo";
    }
}
