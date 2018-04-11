# Ubuntu 安装 php Composer

1. 进入安装目录
```
cd /usr/local/bin
```

2. 下载并安装
```
sudo curl -s https://getcomposer.org/installer | sudo php
```

3. 添加执行权限
```
chmod a+x composer.phar
```

4. 加入全局命令
```
mv composer.phar /usr/local/bin/composer 
```
5. 更新，查看版本号
```
sudo composer.phar self-update
```

6. 查看版本号
```
composer --version
```
