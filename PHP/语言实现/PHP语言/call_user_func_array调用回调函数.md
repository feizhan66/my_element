# call_user_func_array

(PHP 4 >= 4.0.4, PHP 5, PHP 7)
call_user_func_array — 调用回调函数，并把一个数组参数作为回调函数的参数
```angular2html
mixed call_user_func_array ( callable $callback , array $param_arr )
```
把第一个参数作为回调函数（callback）调用，把参数数组作（param_arr）为回调函数的的参数传入。

## 参数
callback
被调用的回调函数。

param_arr
要被传入回调函数的数组，这个数组得是索引数组。

## 返回值
返回回调函数的结果。如果出错的话就返回FALSE

# 范例1
```angular2html
<?php
function foobar($arg, $arg2) {
    echo __FUNCTION__, " got $arg and $arg2\n";
}
class foo {
    function bar($arg, $arg2) {
        echo __METHOD__, " got $arg and $arg2\n";
    }
}


// Call the foobar() function with 2 arguments
call_user_func_array("foobar", array("one", "two"));

// Call the $foo->bar() method with 2 arguments
$foo = new foo;
call_user_func_array(array($foo, "bar"), array("three", "four"));
?>
```

## 使用命名空间
```angular2html
<?php

namespace Foobar;

class Foo {
    static public function test($name) {
        print "Hello {$name}!\n";
    }
}

// As of PHP 5.3.0
call_user_func_array(__NAMESPACE__ .'\Foo::test', array('Hannes'));

// As of PHP 5.3.0
call_user_func_array(array(__NAMESPACE__ .'\Foo', 'test'), array('Philip'));

?>
```

## 把完整的函数作为回调传入call_user_func_array()
```angular2html
<?php

$func = function($arg1, $arg2) {
    return $arg1 * $arg2;
};

var_dump(call_user_func_array($func, array(2, 4))); /* As of PHP 5.3.0 */

?>
```

## 传引用
```angular2html
<?php

function mega(&$a){
    $a = 55;
    echo "function mega \$a=$a\n";
}
$bar = 77;
call_user_func_array('mega',array(&$bar));
echo "global \$bar=$bar\n";

?>
```


