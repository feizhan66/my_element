1. 检查本地是否有SSH key存在
或终端输入
```angular2html
ls -al ~/.ssh
```

2. 如果输出的是：
No such file or directory

3. 那么就没有ssh key


4. 生成新的ssh key
在终端输入
```angular2html
ssh-keygen -t rsa -C "your_email@example.me"
```

5. 之后一路回车就生成了

6.文件在 /home/use/.ssh(隐藏文件)