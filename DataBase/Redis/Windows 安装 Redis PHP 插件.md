# Windows 安装 Redis PHP 插件

Finish!

## 插件下载链接
https://windows.php.net/downloads/pecl/releases/redis/

## 插件选择
注意选择适合php版本的插件根据phpinfo来查看
1. 注意是vc多少的编译
2. 注意是多少位的系统
3. 注意PHP版本
4. 注意是线程安全版还是非线程安全版(xampp是线程安全版)

## 插件放置位置
放到C:\xampp\php\ext文件夹里面

## 配置ini
在php.ini加上
extension=php_mongodb.dll


