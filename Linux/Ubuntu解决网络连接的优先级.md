# Ubuntu解决网络连接的优先级
[尚未验证]

例如：电脑的有线接入和WIFI接入

1.查看网关
ip route show
```html
default via 192.168.2.1 dev enx00e04c689947  proto static  metric 100 
default via 10.159.0.1 dev wlp2s0  proto static  metric 600 
10.159.0.0/23 dev wlp2s0  proto kernel  scope link  src 10.159.0.177  metric 600 
10.201.109.45 via 10.159.0.1 dev wlp2s0  proto dhcp  metric 600 
169.254.0.0/16 dev wlp2s0  scope link  metric 1000 
192.168.2.0/24 dev enx00e04c689947  proto kernel  scope link  src 192.168.2.22  metric 100 
```

2. 查看ip
ifconfig
```html
enp0s31f6 Link encap:以太网  硬件地址 10:65:30:fa:d9:92  
          UP BROADCAST MULTICAST  MTU:1500  跃点数:1
          接收数据包:0 错误:0 丢弃:0 过载:0 帧数:0
          发送数据包:0 错误:0 丢弃:0 过载:0 载波:0
          碰撞:0 发送队列长度:1000 
          接收字节:0 (0.0 B)  发送字节:0 (0.0 B)
          中断:16 Memory:ef200000-ef220000 
 
enx00e04c689947 Link encap:以太网  硬件地址 00:e0:4c:68:99:47  
          inet 地址:192.168.2.22  广播:192.168.2.255  掩码:255.255.255.0
          inet6 地址: fe80::bc99:4cd0:c5af:138c/64 Scope:Link
          UP BROADCAST RUNNING MULTICAST  MTU:1500  跃点数:1
          接收数据包:15 错误:0 丢弃:0 过载:0 帧数:0
          发送数据包:57 错误:0 丢弃:0 过载:0 载波:0
          碰撞:0 发送队列长度:1000 
          接收字节:1725 (1.7 KB)  发送字节:7967 (7.9 KB)
 
lo        Link encap:本地环回  
          inet 地址:127.0.0.1  掩码:255.0.0.0
          inet6 地址: ::1/128 Scope:Host
          UP LOOPBACK RUNNING  MTU:65536  跃点数:1
          接收数据包:170360 错误:0 丢弃:0 过载:0 帧数:0
          发送数据包:170360 错误:0 丢弃:0 过载:0 载波:0
          碰撞:0 发送队列长度:1000 
          接收字节:21814219 (21.8 MB)  发送字节:21814219 (21.8 MB)
 
wlp2s0    Link encap:以太网  硬件地址 a0:c5:89:c7:86:6b  
          inet 地址:10.159.0.177  广播:10.159.1.255  掩码:255.255.254.0
          inet6 地址: 2400:a980:fe:49f:9fbe:949c:9cc5:e43e/64 Scope:Global
          inet6 地址: fe80::c952:cb8b:ed44:a75e/64 Scope:Link
          UP BROADCAST RUNNING MULTICAST  MTU:1500  跃点数:1
          接收数据包:2803233 错误:0 丢弃:0 过载:0 帧数:0
          发送数据包:1749640 错误:0 丢弃:0 过载:0 载波:0
          碰撞:0 发送队列长度:1000 
          接收字节:2230862258 (2.2 GB)  发送字节:594909272 (594.9 MB)
```

3. 删除默认的有线网关（不是IP）

注意这里的192.168.1.1 不是有线网的ip地址，而是有线网的网关地址 ，不要弄错了

sudo route del default gw 192.168.2.1

4. 添加wifi ip为默认地址（IP,不是网关地址）

注意这里的172.28.70.25 是wifi的IP地址，不是网关地址

sudo route add default gw 10.159.0.177






