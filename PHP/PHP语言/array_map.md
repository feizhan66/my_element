# array_map 

简单来说就是用数组里面的数据分别调用一次自定义的数组

array_map() 函数将用户自定义函数作用到数组中的每个值上，并返回用户自定义函数作用后的带有新值的数组。

回调函数接受的参数数目应该和传递给 array_map() 函数的数组数目一致。

```
<?php
function myfunction($v)
{
  return($v*$v);
}

$a=array(1,2,3,4,5);
print_r(array_map("myfunction",$a));
?>
```














