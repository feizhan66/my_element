# Ubuntu配置nginx + php + mysql

1. 安装 nginx

```
sudo apt install nginx

```

2. 安装php7.0

```
sudo apt install php7.0

```

3. 安装 php7.0-fpm (这是php和nginx之间的连接器)

```
sudo apt install php7.0-fpm
```

4. 安装mysql

```
sudo apt install mysql-server
```

5. 安装php7.0-dev和php7.0-mysql
```
sudo apt install php7.0-dev

sudo apt install php7.0-mysql

```
6. 安装正则表达式库pcre
```
sudo apt install libpcre32-3

```

7. 打开/etc/nginx/sites-enabled/default文件，添加如下内容：
```
location ~ \.php$ {
                root    /var/www/html;                                  #php文件所在的根目录
                fastcgi_pass 127.0.0.1:9000;                      #fpm监听的IP和端口
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }

        ## 这段内容表示处理所有对php的请求

```

8. 打开/etc/php/7.0/fpm/pool.d/www.conf文件，找到listen=的这两行，设置相应的IP和端口值 。

```
;listen = /run/php/php7.0-fpm.sock
listen = 127.0.0.1:9000
```

9. 启动这两个进程：
```
service nginx start

service php7.0-fpm start
```


一些扩展库：


1. 安装php扩展：phalcon

git clone git://github.com/phalcon/cphalcon.git

cd cphalcon/build

php gen-build.php

sudo ./install                         #phalcon依赖于php7.0-dev库，所以之前安装此库是必要的。



2. 安装Net_DNS2扩展

sudo pear install Net_DNS2







