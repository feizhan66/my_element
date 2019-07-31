# ubuntu mysql 不能连接问题

```
vim /etc/mysql/mysql.conf.d/mysqld.cnf

注释bind-address
```

```
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'password';
```

```
use mysql;
update user set authentication_string=password('123456');
FLUSH PRIVILEGES;
```

重启