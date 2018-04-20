# SSH用法进阶

## 复制SSH密钥到目标主机，开启无密码SSH登录
```
ssh-copy-id user@host
```
如果还没有密钥，请使用ssh-keygen命令生成。

## 从某主机的80端口开启到本地主机2001端口的隧道
```
ssh -N -L2001:localhost:80 somemachine
```
现在你可以直接在浏览器中输入http://localhost:2001访问这个网站。


## 将你的麦克风输出到远程计算机的扬声器
```
dd if=/dev/dsp | ssh -c arcfour -C username@host dd of=/dev/dsp
```
这样来自你麦克风端口的声音将在SSH目标计算机的扬声器端口输出，但遗憾的是，声音质量很差，你会听到很多嘶嘶声。

## 比较远程和本地文件
```
ssh user@host cat /path/to/remotefile | diff /path/to/localfile –
```
在比较本地文件和远程文件是否有差异时这个命令很管用。

## 通过SSH挂载目录/文件系统
```
sshfs name@server:/path/to/folder /path/to/mount/point
```
从http://fuse.sourceforge.net/sshfs.html下载sshfs，它允许你跨网络安全挂载一个目录。

## 通过中间主机建立SSH连接
```
ssh -t reachable_host ssh unreachable_host
```
Unreachable_host表示从本地网络无法直接访问的主机，但可以从reachable_host所在网络访问，这个命令通过到reachable_host的“隐藏”连接，创建起到unreachable_host的连接。

## 将你的SSH公钥复制到远程主机，开启无密码登录 – 简单的方法

```
ssh-copy-id username@hostname
```

## 直接连接到只能通过主机B连接的主机A
```
ssh -t hostA ssh hostB
```

## 创建到目标主机的持久化连接

```
ssh -MNf <user>@<host>
```
在后台创建到目标主机的持久化连接，将这个命令和你~/.ssh/config中的配置结合使用：

```
Host host
ControlPath ~/.ssh/master-%r@%h:%p
ControlMaster no
```
所有到目标主机的SSH连接都将使用持久化SSH套接字，如果你使用SSH定期同步文件（使用rsync/sftp/cvs/svn），这个命令将非常有用，因为每次打开一个SSH连接时不会创建新的套接字

## 通过SSH连接屏幕

```
ssh -t remote_host screen –r
```
直接连接到远程屏幕会话（节省了无用的父bash进程）。

## 端口检测（敲门）
```
knock <host> 3000 4000 5000 && ssh -p <port> user@host && knock <host> 5000 4000 3000
```
在一个端口上敲一下打开某个服务的端口（如SSH），再敲一下关闭该端口，需要先安装knockd，下面是一个配置文件示例。
```
[options]
logfile = /var/log/knockd.log
[openSSH]
sequence = 3000,4000,5000
seq_timeout = 5
command = /sbin/iptables -A INPUT -i eth0 -s %IP% -p tcp –dport 22 -j ACCEPT
tcpflags = syn
[closeSSH]
sequence = 5000,4000,3000
seq_timeout = 5
command = /sbin/iptables -D INPUT -i eth0 -s %IP% -p tcp –dport 22 -j ACCEPT
tcpflags = syn
```

## 删除文本文件中的一行内容，有用的修复
```
ssh-keygen -R <the_offending_host>
```
在这种情况下，最好使用专业的工具。

## 通过SSH运行复杂的远程shell命令
```
ssh host -l user $(<cmd.txt)
```
更具移植性的版本：
```
ssh host -l user “`cat cmd.txt`”
```

## 通过SSH将MySQL数据库复制到新服务器

```
mysqldump –add-drop-table –extended-insert –force –log-error=error.log -uUSER -pPASS OLD_DB_NAME | ssh -C user@newhost “mysql -uUSER -pPASS NEW_DB_NAME”
```
通过压缩的SSH隧道Dump一个MySQL数据库，将其作为输入传递给mysql命令，我认为这是迁移数据库到新服务器最快最好的方法。

## 删除文本文件中的一行，修复“SSH主机密钥更改”的警告
```
sed -i 8d ~/.ssh/known_hosts
```

## 从一台没有SSH-COPY-ID命令的主机将你的SSH公钥复制到服务器
```
cat ~/.ssh/id_rsa.pub | ssh user@machine “mkdir ~/.ssh; cat >> ~/.ssh/authorized_keys”
```

## 保持SSH会话永久打开
```
autossh -M50000 -t server.example.com ‘screen -raAd mysession’
```
打开一个SSH会话后，让其保持永久打开，对于使用笔记本电脑的用户，如果需要在Wi-Fi热点之间切换，可以保证切换后不会丢失连接。


## 更稳定，更快，更强的SSH客户端

```
ssh -4 -C -c blowfish-cbc
```
强制使用IPv4，压缩数据流，使用Blowfish加密。


