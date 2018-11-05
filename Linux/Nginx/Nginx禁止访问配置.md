# 禁止IP访问

假如你的Nginx根目录设在“/home/user/www”,你想阻止别人通过“http://IP地址/blog”或“http://IP地址/forum”来访问你的站点，最简单的方法就是禁止IP访问

一、 打开Nginx网站默认配置文件，记得先备份
```php
sudo cp /etc/nginx/sites-available/default /etc/nginx/sties-available/default_bak
sudo vi /etc/nginx/sites-available/default
```
二、 将所有内容删除，只保留一下配置
```php
server{
    listen 80 default_server;
    server_name _;
    return 404;
}
```
三、 重启

如果你不想禁止IP地址访问整个目录，只是要防止别人通过IP访问你的博客和论坛。那就需要禁止”/blog”和”/forum”的目录访问。

打开Nginx网站默认配置文件，同上面一样，记得先备份
在”server { }”部分加上以下配置

```php
location ^~ /blog/ {
    deny all;
}
location ^~ /forum/ {
    deny all;
}
```




