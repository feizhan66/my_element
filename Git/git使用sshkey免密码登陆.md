最近在oschina上托管项目，oschina上的项目都是用git来管理。git有个很麻烦的地方就是每次提交代码，都要求输入oschina的用户名和密码进行验证，极大的影响效率。oschina提供了SSH Key访问的方法，该方法只要在oschina上添加公钥，在本地使用密钥就可以免密码连接


## 首先用ssh-keygen生成sshkey

```
ssh-keygen -t rsa -C "xxxxx@xxxxx.com" -f "d:\id_rsa"

xxxxx@xxxxx.com是个人邮箱

d:\id_rsa 是生成的sshkey文件
```


接下来会要求输入私钥密码，如果想留空可以直接按回车(Enter)
```
Enter passphrase (empty for no passphrase):
Enter same passphrase again:
```
完成后会有如下提示，下面的key值可能不一样
```
The key fingerprint is:
bf:3c:17:0b:16:31:86:bb:c4:f3:06:75:7d:83:72:78 xxxxx@xxxxx.com
```

最后生成两个文件id_rsa和id_rsa.pub，把这两个文件放到.ssh文件夹下，windows中.ssh文件夹一般在系统盘的用户下(c:\users\)

用记事本把id_rsa.pub打开，把文本添加到oschina的公钥列表中

在git bash中输入

ssh -T git@git.oschina.net

返回Welcome to Git@OSC, 你的名字! 表示添加成功。


注意事项：

生成的sshkey文件一定要命名为id_rsa，因为ssh默认读id_rsa的sshkey。


在完成以上配置后，提交代码还是需要输入用户名和密码，可以到本地git repository的.git\config文件，如果url使用的是https协议，改为git协议即可。

修改前
```
[remote "origin"]
	url = https://git.oschina.net/oschina/git-osc.git
	fetch = +refs/heads/*:refs/remotes/origin/*
```
修改后
```
[remote "origin"]
	url = git@git.oschina.net:oschina/git-osc.git
	fetch = +refs/heads/*:refs/remotes/origin/*
```






