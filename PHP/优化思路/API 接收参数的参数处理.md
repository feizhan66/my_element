# API 接收参数的参数处理

```php

/**
     * 参数处理
     * 自带有数据类型的转换（额外加了简单参数检查）
     * 使用自带的类型转换的话就要把它写在第一位
     *
     * /s强制转换为字符串类型
     * /d强制转换为整型类型
     * /b强制转换为布尔类型
     * /a强制转换为数组类型
     * /f强制转换为浮点类型
     *
     *
     */
    public function buildParam($paramExpression = array()){
        try{
            // 默认获取所有的参数
            $params = input('param.');
            if (empty($paramExpression)){

                foreach ($params as $params_key=>$params_value){
                    if (is_array($params_value)){
                        $paramExpression[$params_key] = $params_key.'/a';
                    }else{
                        $paramExpression[$params_key] = $params_key;
                    }
                }
            }

            //执行参数处理
            foreach ($paramExpression as $expression_key=>$expression_value){

                $paramExpression[$expression_key] = input("param.{$expression_value}");

                // 参数过滤
                $deal_params = explode('/',$expression_value);
                unset($deal_params[0]);

                if ($deal_params[1] == 'a')
                {//如果是转换成数组就不用了处理了
                    //return true;
                }else{
                    foreach ($deal_params as $params_key=>$params_value)
                    { // 自己额外添加的过滤方法
                        if ($params_value == 'not_null'){
                            $paramExpression[$expression_key] = $this->not_null($paramExpression[$expression_key],$expression_key);
                        }
                    }
                }
                unset($deal_params);

            }
            return $paramExpression;

        }catch (\Exception $exception){
            exit(json_encode(['code'=>'400','message'=>$exception->getMessage()]));
        }

    }

    /**
     * 自定义的参数检查
     * @param $param
     * @param $param_name
     * @return mixed
     */
    protected function not_null($param,$param_name){

        if ($param == ""){
            exit(json_encode(['code'=>'400','message'=>$param_name.' 参数非空']));
        }else{
            return $param;
        }
    }

```

## 使用：

1. 在需要接收参数的地方直接引入这个类处理，返回的值就能够获取相对应的参数
2. 返回的是数组，代表键与获取到的值
3. 这个只允许接收普通参数，不能接收文件

```php



$array = array(
	'name'=>'name'
);
$array = $this->buildParam($array);

```

