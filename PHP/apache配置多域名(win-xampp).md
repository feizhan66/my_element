## 配置域名主机解析

路径：c:\windows\system32\drivers\etc\hosts

修改内容：
```$xslt
// 域名解析的例子
127.0.0.1 localhost
127.0.0.1 laraveldemo.com
127.0.0.1 myblue.com
127.0.0.1 www.myblue.com
```

注意：域名不能出现下滑杠 _ ,例如“huang_xin_yun.com”是不行的

## 配置 httpd.conf

路径：C:\xampp\apache\conf\httpd.conf

把这个的注解弄掉
```$xslt
Include conf/extra/httpd-vhosts.conf
```

## 配置 httpd_vhosts.conf

把注析去掉 

路径：C:\xampp\apache\conf\extra\httpd-vhosts.conf
```
NameVirtualHost *:80
```

对着模板写
```$xslt
<VirtualHost *:80>
    ServerAdmin webmaster@my_blue.com
    DocumentRoot "C:\xampp\htdocs\public"
    ServerName my_lue.com
    ServerAlias www.myblue.com
    ErrorLog "logs/myblue.com-error.log"
    CustomLog "logs/myblue.com-access.log" common
</VirtualHost>
```

## 可能需要
C:\xampp\apache\conf\httpd.conf

```$xslt
<Directory />
    AllowOverride none
    Require all denied
</Directory>

替换成：

<Directory />
    Options FollowSymLinks
    AllowOverride None
    Order deny,allow
    # Deny from all
    Allow from all
</Directory>
```






