# parse_url 解析URL函数

parse_url — 解析 URL，返回其组成部分
```
mixed parse_url ( string $url [, int $component = -1 ] )
```

本函数解析一个 URL 并返回一个关联数组，包含在 URL 中出现的各种组成部分。

本函数不是用来验证给定 URL 的合法性的，只是将其分解为下面列出的部分。不完整的 URL 也被接受，parse_url()会尝试尽量正确地将其解析。

参数

 url：要解析的 URL。无效字符将使用 _ 来替换。

component：

指定 PHP_URL_SCHEME、 PHP_URL_HOST、 PHP_URL_PORT、 PHP_URL_USER、 PHP_URL_PASS、 PHP_URL_PATH、PHP_URL_QUERY 或 PHP_URL_FRAGMENT 的其中一个来获取 URL 中指定的部分的 string。 （除了指定为PHP_URL_PORT 后，将返回一个 integer 的值）。    

- 返回值

对严重不合格的 URL，parse_url() 可能会返回 FALSE。

如果省略了 component 参数，将返回一个关联数组 array，在目前至少会有一个元素在该数组中。数组中可能的键有以下几种：

scheme - 如 http
host
port
user
pass
path
query - 在问号 ? 之后
fragment - 在散列符号 # 之后
如果指定了 component 参数， parse_url() 返回一个 string （或在指定为 PHP_URL_PORT 时返回一个 integer）而不是array。如果 URL 中指定的组成部分不存在，将会返回 NULL。


Example #1 parse_url() 例子
```
<?php
$url = 'http://username:password@hostname/path?arg=value#anchor';

print_r(parse_url($url));

echo parse_url($url, PHP_URL_PATH);
?>

```

```
Array
(
    [scheme] => http
    [host] => hostname
    [user] => username
    [pass] => password
    [path] => /path
    [query] => arg=value
    [fragment] => anchor
)
/path
```

Example #2 parse_url() 解析丢失协议的例子

```
<?php
$url = '//www.example.com/path?googleguy=googley';

// 在 5.4.7 之前这会输出路径 "//www.example.com/path"
var_dump(parse_url($url));
?>
```

```
array(3) {
  ["host"]=>
  string(15) "www.example.com"
  ["path"]=>
  string(5) "/path"
  ["query"]=>
  string(17) "googleguy=googley"
}
```


- 注释

Note: 本函数不能用于相对 URL。

Note: parse_url() 是专门用来解析 URL 而不是 URI 的。不过为遵从 PHP 向后兼容的需要有个例外，对 file:// 协议允许三个斜线（file:///...）。其它任何协议都不能这样。