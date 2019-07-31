Centos下可以通过配置crontab来定时执行任务，执行体可以是一条系统命令或自己写的一个脚本，同时可以指派用户来执行。配置crontab有两种方法。
方法1、使用crontab命令，例如添加一个新的或编辑已有的，使用：
```bash
crontab -e
```

就可以进入配置文件。此时配置crontab的执行者是当前登入用户，如果当前用户是root，需要为其他用户配置，可以使用
```bash
crontab -e -u 用户名

或

su 用户名

crontab -e
```

这种方法有一个缺点，就是当前系统中配置的crontab不在一个配置文件中，让管理员不方便查询系统到底有多少个crontab。

方法2、直接在/etc/crontab文件中添加，不过需要是root身份。打开文件，应该会看到类似下面的信息
```bash
SHELL=/bin/bash

PATH=/sbin:/bin:/usr/sbin:/usr/bin

MAILTO=root

HOME=/

# For details see man 4 crontabs

# Example of job definition:

# .---------------- minute (0 - 59)

# | .------------- hour (0 - 23)

# | | .---------- day of month (1 - 31)

# | | | .------- month (1 - 12) OR jan,feb,mar,apr ...

# | | | | .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat

# | | | | |

# * * * * * user-name command to be executed
```

要添加新的crontab，只需要在文件最后增加即可。注意这里面需要指定用户名；而方法1中则不需要，如果指定了，它会认为是命令的一部分，从而可能导致crontab执行失败。

如果服务器都是有root来管理，建议添加crontab使用方法2，这样系统中的所有计划任务都在一起，一目了然。