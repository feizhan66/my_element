同一个服务器搭建多个站点，就需要用Nginx配置

一、 在Nginx配置目录下，创建一个 vhost 目录。
```php
sudo mkdir /etc/nginx/vhost
```
二、 创建网站配置文件
```php
sudo vi /etc/nginx/vhost/vhost_siteA.conf
```
输入如下配置信息
```php
server {
    listen       80;                        # 监听端口
    server_name www.siteA.com siteA.com;    # 站点域名
    root  /home/user/www/blog;              # 站点根目录
    index index.html index.htm index.php;   # 默认导航页
 
    location / {
        # WordPress固定链接URL重写
        if (!-e $request_filename) {
            rewrite (.*) /index.php;
        }
    }
 
    # PHP配置
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```
可以配置多个，即是多个站点了
三、 打开nginx.conf文件
```php
sudo vi /etc/nginx/nginx.conf
```
四、 将虚拟目录的配置加入到“http{}”部分的末尾
```php
http {
    ***
    include /etc/nginx/vhost/*.conf
}
```
重启Nginx服务即可
```php
sudo service nginx restart
```










