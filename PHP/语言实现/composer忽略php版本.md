执行composer install遇到错误：Your requirements could not be resolved to an installable set of packages. 这是因为不匹配composer.json要求的版本。

提示我的PHP 7版本太高，不符合composer.json需要的版本，但是在PHP 7下应该也是可以运行的，composer可以设置忽略版本匹配，命令是：


```php
composer install --ignore-platform-reqs
```

或
```php
composer update --ignore-platform-reqs
```





