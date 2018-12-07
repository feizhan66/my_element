# Redis 安装

## Linux下安装(编译安装)

```
$ wget http://download.redis.io/releases/redis-2.8.17.tar.gz
$ tar xzf redis-2.8.17.tar.gz
$ cd redis-2.8.17
$ make
```
 make完后 redis-2.8.17目录下会出现编译后的redis服务程序redis-server,还有用于测试的客户端程序redis-cli,两个程序位于安装目录 src 目录下：

下面启动redis服务. 

```
$ cd src
$ ./redis-server
```
注意这种方式启动redis 使用的是默认配置。也可以通过启动参数告诉redis使用指定配置文件使用下面命令启动。 

```
$ cd src
$ ./redis-server redis.conf
```
 redis.conf是一个默认的配置文件。我们可以根据需要使用自己的配置文件。

启动redis服务进程后，就可以使用测试客户端程序redis-cli和redis服务交互了。 比如：
```
$ cd src
$ ./redis-cli
redis> set foo bar
OK
redis> get foo
"bar"
```

## Ubuntu下安装
在 Ubuntu 系统安装 Redis 可以使用以下命令:

```
$sudo apt-get update
$sudo apt-get install redis-server
```
- 启动Redis
```
$ redis-server
```
- 查看 redis 是否启动？
```
$ redis-cli
```
以上命令将打开以下终端：
```
redis 127.0.0.1:6379>
```
127.0.0.1 是本机 IP ，6379 是 redis 服务端口。现在我们输入 PING 命令。

```
redis 127.0.0.1:6379> ping
PONG
```
```angular2html
// 在WIN的安装目录下
./redis-cli
```

