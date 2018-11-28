待测试

多主一从，也称为多源复制，数据流向：

- 主库1 -> 从库s
- 主库2 -> 从库s
- 主库n -> 从库s

# 应用场景

- 数据汇总，可将多个主数据库同步汇总到一个从数据库中，方便数据统计分析。
- 读写分离，从库只用于查询，提高数据库整体性能。

# 部署环境

注：使用docker部署mysql实例，方便快速搭建演示环境。但本文重点是讲解主从配置，因此简略描述docker环境构建mysql容器实例。

- 数据库：MySQL 5.7.x  （相比5.5，5.6而言，5.7同步性能更好，支持多源复制，可实现多主一从，主从库版本应保证一致）
- 操作系统：CentOS 7.x
- 容器：Docker 17.09.0-ce
- 镜像：mysql:5.7
- 主库300：IP=192.168.10.212; PORT=4300; server-id=300; database=test3; table=user
- 主库400：IP=192.168.10.212; PORT=4400; server-id=400; database=test4; table=user
- 主库500：IP=192.168.10.212; PORT=4500; server-id=500; database=test5; table=user
- 从库10345：IP=192.168.10.212; PORT=4345; server-id=10345; database=test3,test4,test5; table=user

# 配置约束

- 主从库必须保证网络畅通可访问
- 主库必须开启binlog日志
- 主从库的server-id必须不同

【主库300】操作及配置

配置my.cnf

```angularjs
[client]
port = 3306
default-character-set = utf8mb4

[mysql]
port = 3306
default-character-set = utf8mb4

[mysqld]
#############
# summary
#############
#bind-address = 0.0.0.0
#port = 3306
#datadir=/usr/mysql/data # 数据存储目录

server-id = 300  # 必须唯一
log_bin = mysql-bin  # 开启及设置二进制日志文件名称
binlog_format = MIXED
sync_binlog = 1
expire_logs_day = 7 # 二进制日志自动删除/过期天数。默认值为0，表示不自动删除

#binlog_cache_size = 128m
#max_binlog_cache_size = 512m
#max_binlog_size=256m

binlog-do-db=test3 # 要同步的数据库

binlog-ignore-db = mysql # 不需要同步的数据库
binlog-ignore-db = information_schema
binlog-ignore-db = performation_schema
binlog-ignore_db = sys


character-sert-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

安装启动


注：若不熟悉docker，可使用传统方式安装mysql，效果相同。

创建授权用户

连接mysql主数据库，键入命令mysql -u root -p，输入密码后登录数据库。创建用户用于从库同步复制，授予复制、同步访问的权限

```sql
mysql> grant replication slave on *.* to 'slave'@'%' identified by '123456';
```

log_bin是否开启

```sql
mysql> show variables like 'log_bin'
```

查看master状态

```sql
mysql> show master status \G;
```

# 【主库400】配置及操作

配置my.cnf

```sql
[client]
port = 3306
default-character-set = utf8mb4

[mysql]
port = 3306
default-character-set = utf8mb4

[mysqld]
#############
# summary
#############
#bind-address = 0.0.0.0
#port = 3306
#datadir=/usr/mysql/data # 数据存储目录

server-id = 400  # 必须唯一
log_bin = mysql-bin  # 开启及设置二进制日志文件名称
binlog_format = MIXED
sync_binlog = 1
expire_logs_day = 7 # 二进制日志自动删除/过期天数。默认值为0，表示不自动删除

#binlog_cache_size = 128m
#max_binlog_cache_size = 512m
#max_binlog_size=256m

binlog-do-db=test4 # 要同步的数据库

binlog-ignore-db = mysql # 不需要同步的数据库
binlog-ignore-db = information_schema
binlog-ignore-db = performation_schema
binlog-ignore_db = sys


character-sert-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

安装启动

创建授权用户

创建用户用于从库同步复制，授予复制、同步访问的权限

......

【主库500】配置及操作

配置my.cnf

```sql
[client]
port = 3306
default-character-set = utf8mb4

[mysql]
port = 3306
default-character-set = utf8mb4

[mysqld]
#############
# summary
#############
#bind-address = 0.0.0.0
#port = 3306
#datadir=/usr/mysql/data # 数据存储目录

server-id = 500  # 必须唯一
log_bin = mysql-bin  # 开启及设置二进制日志文件名称
binlog_format = MIXED
sync_binlog = 1
expire_logs_day = 7 # 二进制日志自动删除/过期天数。默认值为0，表示不自动删除

#binlog_cache_size = 128m
#max_binlog_cache_size = 512m
#max_binlog_size=256m

binlog-do-db=test5 # 要同步的数据库

binlog-ignore-db = mysql # 不需要同步的数据库
binlog-ignore-db = information_schema
binlog-ignore-db = performation_schema
binlog-ignore_db = sys


character-sert-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

安装启动

创建授权用户

创建用户用于从库同步复制，授予复制、同步访问的权限

......

# 【从库10345】配置及操作

配置my.cnf

```sql
[client]
port = 3306
default-character-set = utf8mb4

[mysql]
port = 3306
default-character-set = utf8mb4

[mysqld]
#############
# summary
#############
#bind-address = 0.0.0.0
#port = 3306
#datadir=/usr/mysql/data # 数据存储目录

server-id = 10345
master_info_repository = table
relay_log_info_repository = table


character-sert-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```
安装启动


设置【主库】信息


登录【从库10345】，进入mysql命令行。

```sql
mysql> stop slave;

mysql> CHANGE MASTER TO 
        MASTER_HOST='192.168.10.212',
        MASTER_PORT=4300,
        MASTER_USER='slave',
        MASTER_PASSWORD='123456',
        MASTER_LOG_FILE='mysql-bin.000003',
        MASTER_LOG_POS=438
        for channel '300';

mysql> CHANGE MASTER TO 
       MASTER_HOST='192.168.10.212',
       MASTER_PORT=4500,
       MASTER_USER='slave',
       MASTER_PASSWORD='123456',
       MASTER_LOG_FILE='mysql-bin.000003',
       MASTER_LOG_POS=438
       for channel '500';

mysql> start slave;

```

stop slave;     //停止同步

start slave;     //开始同步

//必须和【主库】的信息匹配。

CHANGE MASTER TO

MASTER_HOST='192.168.10.212',     //主库IP

MASTER_PORT=4300,                       //主库端口

MASTER_USER='slave',                     //访问主库且有同步复制权限的用户

MASTER_PASSWORD='123456',      //登录密码

//【关键处】从主库的该log_bin文件开始读取同步信息，主库show master status返回结果

MASTER_LOG_FILE='mysql-bin.000003',

//【关键处】从文件中指定位置开始读取，主库show master status返回结果

MASTER_LOG_POS=438

for channel '300';            //定义通道名称

# 查看同步状态

```sql
mysql> show slave status \G;
```

可以看见设置三个的主从同步通道的所有状态信息。

只有【Slave_IO_Running】和【Slave_SQL_Running】都是Yes，则同步是正常的。

如果是No或者Connecting都不行，可查看mysql-error.log，以排查问题。

```sql
mysql> show variables like 'log_error%'
```

配置完成，则【从库10345】开始自动同步。


若需要单独启动或停止某个同步通道，可使用如下命令：

start slave for channel '300';     //启动名称为300的同步通道

stop slave for channel '300';     //停止名称为300的同步通道

验证数据同步

建库


使用root账号登录【主库300】，创建test3数据库 


```sql
mysql> create database test3;

mysql> use test3;

```
建表


在【主库300】中创建user表
```sql

create table `user` (
`id` 
)

```
新增


在【主库300】中向user表插入一条数据：

```sql
insert into 
```

在【从库10345】中查询user表数据：
```sql
use test3;

select * from user;

```


新增记录同步成功。

更新


在【主库300】中修改刚才插入的数据：


```sql
update user set name='' where id=1;
```

在【从库10345】中查询user表数据：

```sql
select * from user;
```

更新记录同步成功。

删除


在【主库300】中删除刚才更新的数据：
```sql
mysql> delete from user where id =2;

mysql> select * from user;
```

在【从库10345】中查询user表数据：

```sql
mysql> select * from user;
```

删除记录同步成功。

注：【主库400】、【主库500】的验证操作与上述类似。

补充：


如果【主服务器】重启mysql服务，【从服务器】会等待与【主服务器】重连。当主服务器恢复正常后，从服务器会自动重新连接上主服务器，并正常同步数据。
如果某段时间内，【从数据库】服务器异常导致同步中断（可能是同步点位置不匹配），可以尝试以下恢复方法：进入【主数据库】服务器（正常），在bin-log中找到【从数据库】出错前的position，然后在【从数据库】上执行change master，将master_log_file和master_log_pos重新指定后，开始同步。 



