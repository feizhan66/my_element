自己动手搭建免费的VPN服务器
JUL31
2015 25 COMMENTS WRITTEN BY CHEN
VPN的作用，不用做解释，有需要的人很明白。网上有很多卖VPS或VPN服务的，我曾经买过，但使用时，速度慢、不稳定。经常长时间的摸索，发现了稳定、可靠、数据安全（网上购买，担心用户数据会被泄露）、且免费的方法：基于Amazon AWS EC2搭建自己的VPN服务器。


搭建自己的VPN服务器，有两个关键动作：

1、申请并创建免费的AWS EC2虚拟机

可创建Linux主机，也可以创建Windows Server。这个主机就是一台干净的服务器。

2、在虚拟机上搭建VPN 服务器

Windows Server中搭建VPN Server非常简单，自行Google或bing搜索即可。本文针对Linux主机，搭建VPN Server。Linux中搭建VPN Server稍微复杂，对于Linux初学者，建议使用Windows Server。

 

以下是主要步骤：

一、创建AWS EC2账户

 登录http://aws.amazon.com/cn/ec2/页面，选择“免费试用Amazon EC2”。



我们来看一下免费套餐详细信息：



也就是说创建1个虚拟机，可以一直开机免费运行一年。AWS EC2的特点是按使用收费，关机时不收费。

750 小时的 Linux、RHEL 或 SLES t2.micro 实例使用量/月
750 小时的 Windows t2.micro 实例使用量/月
一次运行一个实例或同时运行多个实例
    接下来就选择注册免费账户，填写信息。需要提供VISA或MasterCard信用卡。这里略去注册步骤。

    注册过程中，建议要填写自己的真实手机号码，Amazon会回拨电话，要求在手机里输入注册页面提供的注册码。注册成功后，amazon会在你的信用卡扣费1美元，但不会形成实际账单，个人理解amazon就是验证信用卡有效性。



二、创建AWS EC2 Instance（即虚拟机）

1、创建好AWS账户后，进入登录页面



2、登录成功后，进入了Amazon Web Services页面。这里我们关注“EC2云中的虚拟服务器”



3、进入EC2控制面板后，我们就可以创建虚拟机了。选择“启动实例”：

启动实例，意思就是创建虚拟主机。这里注意网页右上角，有个数据中心地址。对于我们大陆来说，建议选择日本的“东京”。经过实测，东京的主机网络延时在100ms左右，而美国的俄勒冈，演示高达500ms。



4、启动实例后，进入下面页面：

  OS有Linux和Windows两种。Linux有Amazon Linux和Redhat、Suse、Ubutun。Windows版本有Windows Server2003/2008/2012。

  这里我们选择“Amazon Linux”。



5、这里我们选择免费的“t2.micro”，配置为1 vCPU和1GB内存，这个配置对于搭建一个VPN Server来说，足够了。

  注意amazon对实例存储的提示：“实例可用的本地实例存储卷。实例存储中的数据不是永久性的 – 它仍然存在实例的生命周期中。”



对于“符合条件的免费套餐”，Amazon的说明如下：

微型实例有资格享用 AWS 免费使用套餐。在您注册 AWS 后的 12 个月，您每月可获得高达 750 小时的微型实例。如果您的免费使用期结束，或者应用程序用量超出免费使用套餐范围，只需按照标准服务费率根据使用量付费即可。

了解更多 有关免费使用套餐资格和限制的信息

即你可以创建多个虚拟机，但所有虚拟机加起来免费运行时间是750小时。若只创建1个虚拟机，那么一直开机，一个月最多24×31=744小时。即我们可以使用一个虚拟机，一直免费开机用一年。

6、点击上一步页面的“审核和启动”，进入“核查实例启动”

 这里我们再次确认配置是免费的，1 vCPU、1GB内存



7、点击上一步的“启动”，提示“选择现有密钥对或则创建新密钥对”。

   由于我们第一次创建，没有密钥对。这里新建一个。



这里注意，要选择“下载密钥对”，将密钥文件下载本地。这样虚拟机创建后，我们才能远程SSH登录。



8、密钥文件下载完成后，启动实例。进入“您的实例正在启动”页面。



至此，虚拟机创建成功。我们点击实例，就可以对虚拟机进行配置。这里我的虚拟机编号” i-353dc2c3 “，点击即可进入配置界面。

 

三、配置AWS EC2虚拟机

配置过程中，常见的问题：

（1）我的虚拟机公网IP多少？

（2）我的公网IP可以ping通吗？ping不通的话，原因是什么？

（3）如何SSH登录我的EC2虚拟机？

（4）如何创建root用户密码？

 

前面创建完成虚拟机并启动后，就可以进入EC2控制面板，对实例进行配置。



1、获取EC2公网IP地址信息

进入实例控制面板后，就可以看到公有IP地址信息，这个IP是可以全球访问的。就是我们要做VPN Server的IP地址。建议使用浮动IP，这样你的公网IP一直不会变。若不选择浮动IP，重启后，公网IP可能会变化。当然也可以直接使用公有DNS来访问你的主机，就不用记IP地址。

注意，此时的公有IP地址，还无法ping通，也没法直接SSH连接。这是因为EC2虚拟机创建时，“安全组”默认拒绝所有的连接（除SSH外）。后面将介绍如何修改。



2、如何SSH登录EC2虚拟机

   刚才创建虚拟机过程中，我们创建了密钥文件，并下载到本地。此时我们要使用这个密钥文件登录。

   amazon有个网页专门说明如何SSH EC2虚拟机。

http://docs.aws.amazon.com/zh_cn/AWSEC2/latest/UserGuide/AccessingInstancesLinux.html

     从Windows机器登录说明：

http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/putty.html

（1）Linux系统登录方式

  若使用Linux机器登录，则非常简单。将下载的密钥文件拷贝到命令执行当前目录

     ssh -i ilinuxkernel.pem ec2-user@52.27.xx.xx

   或则

    ssh -i ilinuxkernel.pem ec2-user@ec2-52-25-237-29.us-west-2.compute.amazonaws.com

    注意必须是ec2-user@共有IP或公有DNS，这种格式。用户名不能变。

 

或者（2）Windows登录方式

稍后会有提示ilinuxkernel.pem的位置。我们“import”即可，会提示你找密钥文件的位置。

   主要步骤：

   a）使用puttygen.exe转换我们下载的密钥文件，



创建的过程中，晃动一下鼠标：

 

 







b）使用转换后的密钥文件登录



 

 c）输入用户名ec2-user



3、创建root用户密码

https://aws.amazon.com/amazon-linux-ami/2015.03-release-notes/

31 package(s) needed for security, out of 64 available

Run “sudo yum update” to apply all updates.

[ec2-user@ip-172-31-19-108 ~]$ sudo su –

[root@ip-172-31-19-108 ~]# passwd

Changing password for user root.

New password:

BAD PASSWORD: it is based on a dictionary word

Retype new password:

passwd: all authentication tokens updated successfully.

[root@ip-172-31-19-108 ~]#

 

四、搭建PPTP VPN服务器

1、安装所需组件：

a）可以通过yum安装的包括ppp、dkms和ppp-devel

[root@ip-172-31-19-108 ~]# yum install ppp -y

[root@ip-172-31-19-108 ~]# yum install dkms -y

[root@ip-172-31-19-108 pptpd]# yum install -y ppp-devel

b）手动安装pptpd组件

可以到下面地址下载rpm安装包

http://poptop.sourceforge.net/yum/stable/packages/

为了方便，我将rpm包和配置文件均打包一起，可以直接安装使用。

[root@ip-172-31-19-108 ~]# tar jxf pptpd_20150728.tar.bz2

[root@ip-172-31-19-108 ~]# ls

pptpd  pptpd_20150728.tar.bz2

[root@ip-172-31-19-108 ~]# cd pptpd

[root@ip-172-31-19-108 pptpd]# ls

chap-secrets                options.pptpd                          pptpd-1.4.0-1.el6.x86_64.rpm       rc.local

dkms-2.0.17.5-1.noarch.rpm  ppp-2.4.5-33.0.rhel6.x86_64.rpm        pptpd.conf

options                     ppp-devel-2.4.5-33.0.rhel6.x86_64.rpm  pptp-release-4-7.rhel6.noarch.rpm

[root@ip-172-31-19-108 pptpd]#

2、配置防火墙

iptables -A INPUT -p tcp –dport 1723 -j ACCEPT

iptables -A INPUT -p tcp –dport 47 -j ACCEPT

iptables -A INPUT -p gre -j ACCEPT

iptables -A POSTROUTING -t nat -s 192.168.0.0/24 -o eth0 -j MASQUERADE

iptables -A INPUT -p UDP –dport 53 -j ACCEPT

以上命令可以放在/etc/rc.local文件中，每次系统启动时，自动执行。

3、配置sysctl.conf

# Controls IP packet forwarding

net.ipv4.ip_forward = 1

将ip_forware的值由0改为1。

4、配置/etc/pptp.conf

在文件最后，添加以下内容：

localip 192.168.0.1

remoteip 192.168.0.100-199

5、配置/etc/ppp/options.pptpd

在文件最后，添加以下内容：

ms-dns  8.8.8.8

ms-dns  8.8.4.4

6、添加vpn用户名和密码

在配置文件/etc/pppt/chap-secrets中添加用户名和密码。

示例：

[root@ip-172-31-19-108 pptpd]# cat chap-secrets

# Secrets for authentication using CHAP

# client     server       secret                         IP addresses

   linux          pptpd  linux *

添加用户linux，密码也为linux。

7、生效以上配置，然后启动pptpd服务

  source /etc/rc.local

  sysctl -p

  service pptpd start

8、将pptpd加入系统服务（可选）

  chkconfig –add pptpd

  chkconfig  –level 2345 pptpd on

 

到现在为止，就可以VPN服务器已经启动，在电脑或者手机上，设置登录即可。

但以上配置完成和服务启动后，客户端并不能连接VPN服务器。原因在于EC2的安全策略屏蔽了SSH以外的服务。

接下来我们修改EC2安全组策略。