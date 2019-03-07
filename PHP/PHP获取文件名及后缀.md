获取文件名
```
$file = realpath(__DIR__.'/images/common/../addBtn.png');
```
方法一

```
$file = realpath(__DIR__.'/images/common/../addBtn.png');
$info = pathinfo($file);
$file_name =  basename($file,'.'.$info['extension']);
```

获取文件后缀

方法一

```
$file_name = array_pop(explode('.', $fpath));
```
方法二

```
function getFileSuffix($filename){
    return strrpos($filename, '.') ? substr($filename, strrpos($filename, '.')+1) : '';
}
```
