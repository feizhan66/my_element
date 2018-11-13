使用的是LAMP

# 安装Apache
```angular2html
sudo apt install -y apache2
```

# 安装mysql5.7（ubuntu16.04自带）
```angular2html
sudo apt install -y mysql-server mysql-client libmysqlclient-dev mysql-workbench
```

# 安装php5.6
```angular2html
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php5.6-common php5.6-mbstring php5.6-mcrypt php5.6-mysql php5.6-xml php5.6-gd php5.6-curl php5.6-json php5.6-fpm php5.6-zip php5.6-mcrypt libapache2-mod-php5.6

```

安装：php7.0
```angular2html
sudo apt-get install -y php7.0-common php7.0-mbstring php7.0-mcrypt php7.0-mysql php7.0-xml php7.0-gd php7.0-curl php7.0-json php7.0-fpm php7.0-zip php7.0-mcrypt libapache2-mod-php7.0
```

安装：php7.1
```angular2html
sudo apt-get install -y php7.1-common php7.1-mbstring php7.1-mcrypt php7.1-mysql php7.1-xml php7.1-gd php7.1-curl php7.1-json php7.1-fpm php7.1-zip php7.1-mcrypt libapache2-mod-php7.1
```

#开启重写转向
sudo a2enmod rewrite
sudo a2enmod headers至此安装完成

重启：sudo service apache2 restart

```angular2html
sudo vi .bashrc
```


# 编辑bashrc加入自定义命令，为方便在不同php版本间切换
```angular2html
alias php56='sudo a2dismod php7.0 && sudo a2dismod php7.1 && sudo a2enmod php5.6 && sudo service apache2 restart'
alias php70='sudo a2dismod php5.6 && sudo a2dismod php7.1 && sudo a2enmod php7.0 && sudo service apache2 restart'
alias php71='sudo a2dismod php5.6 && sudo a2dismod php7.0 && sudo a2enmod php7.1 && sudo service apache2 restart'
```

安装完成后，重启电脑，默认是运行5.6版本的php（命令行下php-v 是显示最高版本7.1）

在/etc/php目录下有对应版本号的文件夹，编辑相应的php.ini可配置相应的php版本，命令行下php70可切换到php7版本，其它类同



