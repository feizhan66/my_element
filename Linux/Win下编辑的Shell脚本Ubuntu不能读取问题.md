在Win下班级的Shell脚本，放到Ubuntu下运行会报“syntax error near unexpected token 'fi' ”的问题

这就是两个平台换行符的问题

解决办法：

方法一：（亲测有效）
```shell
# vi打开存在问题的文件
vi file.sh
# 查看编码
:set ff
# 如果显示fileformat=dos则就是问题了
# 解决方案
:set ff=unix
# 保存
:wq
```

方法二：
```
# 执行命令
yum install -y dos2unix

# 更改文件格式
dos2unix file.sh
```
