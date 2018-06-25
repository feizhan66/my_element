```angular2html
<?php
echo number_format("5000000")."<br>";
echo number_format("5000000",2)."<br>";
echo number_format("5000000",2,",",".");
?>
```

定义和用法
number_format() 函数通过千位分组来格式化数字。
注释：该函数支持一个、两个或四个参数（不是三个）。

number_format(number,decimals,decimalpoint,separator)

