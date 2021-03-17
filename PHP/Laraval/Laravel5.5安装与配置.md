# Laravel 5.5

服务器要求：
```$xslt

    PHP >= 7.0.0
    PHP OpenSSL 扩展
    PHP PDO 扩展
    PHP Mbstring 扩展
    PHP Tokenizer 扩展
    PHP XML 扩展

```

composer 安装 Laravel 安装器
```$xslt
composer global require "laravel/installer"
```

使用安装器新建项目
```$xslt
laravel new blog
```

如果之前已经安装过旧版本的 Laravel 安装器，需要更新后才能安装最新的 Laravel 5.5 框架应用：
```$xslt
composer global update
```

直接安装Laravel（不经过安装器）
```$xslt
composer create-project --prefer-dist laravel/laravel blog

```
安装其他版本Laravel
```$xslt
composer create-project --prefer-dist laravel/laravel blog 5.4.*。

```

本地开发服务器
```$xslt
php artisan serve
```

