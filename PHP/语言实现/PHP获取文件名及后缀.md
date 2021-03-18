# 获取文件名

```php
$file = realpath(__DIR__.'/images/common/../addBtn.png');
```

1. 方法一

```php
$file = realpath(__DIR__.'/images/common/../addBtn.png');
$info = pathinfo($file);
$file_name =  basename($file,'.'.$info['extension']);
```



# 获取文件后缀

1. 方法一

```php
$file_name = array_pop(explode('.', $fpath));
```

2. 方法二

```php
function getFileSuffix($filename){
    return strrpos($filename, '.') ? substr($filename, strrpos($filename, '.')+1) : '';
}
```
