
```bash
# 登入mysql
mysql -u root -p

# 查询当前存储路径
show global variables like "%datadir%";
```

迁移步骤：

1. 现在我们创建新的目录
```bash
mkdir /data/mysql
```
2. mv或cp原始数据库数据目录文件
这里我用的是cp，为了安全考虑，直接复制一份，如果失败原始数据不会影响，可以快速回滚到之前的目录启动数据库
```bash
cp -a /var/lib/mysql /data/mysql/
```
3. 修改配置文件my.cnf
备份my.cnf
```bash
cp /etc/my.cnf /etc/my.cnfbak
```

```bash
vim /etc/my.cnf

# 修改如下几项（ #为了安全起见，你可以把原来的注释掉，然后重新加入一行，改成现在的目录，也会为了快速回滚。）
datadir=/data/mysql
socket=/data/mysql/mysql.sock
```
4. 修改配置vim
```bash
vim /etc/init.d/mysqld

datadir=/data/mysql
```

5. 建立软链接
```bash
ln -s /data/mysql/mysql.sock /var/lib/mysql/mysql.sock
```
6. 重启mysql

```bash
systemctl stop mysqld
systemctl start mysqld
```






















