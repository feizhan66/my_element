
## 简介
OS模块简单的来说它是一个Python的系统编程的操作模块，可以处理文件和目录这些我们日常手动需要做的操作。

```
>>> import os # 导入os模块

>>> help(os) # 查看os模块帮助文档

```

## OS模块重要函数和变量
```
1 )、os.sep 更改操作系统中的路径分隔符。
2 )、os.getcwd()获取当前路径，这个在Python代码中比较常用。
3 )、os.listdir() 列出当前目录下的所有文件和文件夹。
4 )、os.remove() 方法可以删除指定的文件。
5 )、os.system() 方法用来运行shell命令。
6 )、os.chdir() 改变当前目录，到指定目录中。
```

## OS模块函数作用详解
```
os.system函数可以运行shello命令，Linux系统中就是终端模拟器中的命令。
也有一些函数可以执行外部程序，包括execv，它会退出Python解释器，并且将控制权交给被执行的程序。

os.sep变量主要用于系统路径中的分隔符。

Windows系统通过是“\\”，Linux类系统如Ubuntu的分隔符是“/”，而苹果Mac OS系统中是“:”。
```












