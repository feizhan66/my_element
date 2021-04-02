查看内存使用情况

free -m
 
查看cpu使用情况

top #查看进程运行情况
 
查看磁盘以及分区情况

df -h 
 
查看网络情况

ifconfig
 
查看端口使用情况

#1.方法一
lsof -i:端口号
#2.方法二
netstat -apn|grep 端口号

#3.方法三
ps -au|grep 端口号
