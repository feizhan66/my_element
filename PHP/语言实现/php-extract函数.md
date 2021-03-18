将键值 "Cat"、"Dog" 和 "Horse" 赋值给变量 $a、$b 和 $c：

```php
<?php
$a = "Original";
$my_array = array("a" => "Cat","b" => "Dog", "c" => "Horse");
extract($my_array);
echo "\$a = $a; \$b = $b; \$c = $c";
?>
```
