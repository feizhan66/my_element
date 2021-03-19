```angular2html
<?php
$a=array("a"=>"Volvo","b"=>"BMW","c"=>"Toyota");
print_r(array_reverse($a));
?>
```
定义和用法
array_reverse() 函数以相反的元素顺序返回数组。
说明
array_reverse() 函数将原数组中的元素顺序翻转，创建新的数组并返回。
如果第二个参数指定为 true，则元素的键名保持不变，否则键名将丢失。