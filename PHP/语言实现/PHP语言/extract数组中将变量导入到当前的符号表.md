```angular2html
extract(array,extract_rules,prefix)
```
extract() 函数从数组中将变量导入到当前的符号表。

该函数使用数组键名作为变量名，使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。

该函数返回成功设置的变量数目。

例子：
```angular2html
$query = [];

$array = [
    'query'=>[
        'a'=>'Cat',
        'b'=>'Dog',
        'c'=>'Horse'
    ]
]
extract($array);
print_r($query)

结果：
[
        'a'=>'Cat',
        'b'=>'Dog',
        'c'=>'Horse'
    ]

```
理解：把数组里面的键作为一个新的变量，可以直接使用
