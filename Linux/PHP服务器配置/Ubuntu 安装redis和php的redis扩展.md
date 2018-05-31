## 安装redis服务

Finish!

```angular2html
sudo apt-get install redis-server
```
装好之后默认就是自启动、后台运行的，无需过多设置，安装目录应该是/etc/redis

## 启动
```angular2html
sudo service redis-server start
```
然后运行客户端命令redis-cli能够出现命令提示符127.0.0.1:6379: >就算成功了！

## 安装php的redis扩展
分别执行以下命令：
```angular2html
// 1.下载phpredis扩展文件
git clone https://github.com/phpredis/phpredis.git

// 2.移动文件
mv phpredis(此处是你clone下的文件) /etc/phpredis

// 3.安装
cd /etc/phpredis
phpize

//如果phpize命令没有响应，可能是没有安装php-dev。我目前安装的是php7.0，键入命令
apt-get install php7.0-dev
//然后再phpize

// 4.编译
./configure
make && make install
```
设置php.ini

```angular2html
vi /etc/php/7.0/apache2/php.ini 
中写入 
extension=/etc/phpredis/modules/redis.so
```
重启php7.0-fpm
```angular2html
service php7.0-fpm restart
```








