mysql默认密码为空

但是使用mysql -uroot -p 命令连接mysql时，报错
ERROR 1045 (28000): Access denied for user 'root'@'localhost' 

此时修改root的默认密码即可

登录数据库
1. 方法一：
sudo mysql -uroot -p; # 弹出输入密码的，直接回车就可以

2. 方法二：

A：进入到etc/mysql 目录下，查看debian.cnf文件(里面有user和password)

B：找到用户名，密码 ，使用此账号登录mysql
登录：mysql -udebian-sys-maint -pxedvSNKdLavjuEWV

C：修改root用户的的密码
这里是关键点，由于mysql5.7没有password字段，密码存储在authentication_string字段中，password()方法还能用

在mysql中执行下面语句修改密码
```bash
show databases;

use mysql;

update user set authentication_string=PASSWORD("自定义密码") where user='root';

update user set plugin="mysql_native_password";

flush privileges;

quit;
```
修改完密码，需要重启mysql
```bash
/etc/init.d/mysql restart;
或者
sudo service mysql restart;
```
再次登录
mysql -u root -p 密码;













