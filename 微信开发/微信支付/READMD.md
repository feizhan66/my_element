# 微信开发基础

[文档](https://www.kancloud.cn/zoujingli/wechat-php-sdk/212957)

- 先composer下载一个第三方包

```

// 使用命名行下载SDK文件
composer require zoujingli/wechat-php-sdk

//在项目合适的地方向SDK注入配置参数（字段见下面）
\Wechat\Loader::config($options);

// 实例SDK相关的操作对象
$pay = new \Wechat\WechatPay();

```


