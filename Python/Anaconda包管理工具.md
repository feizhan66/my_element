# Anaconda

# 概述
如果我在本地只有一个python环境那我所有程序用到的各种包都只能放到同一个环境中, 导致环境混乱, 另外当我将写好的程序放到另一电脑上运行时又会遇到缺少相关包, 需要自己手动一个个下载的情况, 实在是烦人, 要是能每个程序开发都选用不同的环境, 而开发好之后又能将该程序需要的环境(第三方包)都独立打包出来就好了.


# 下载
官方下载地址：https://www.continuum.io/downloads 
所有安装包地址：https://repo.continuum.io/archive/ 

# 安装
安装较为简单，这里参考官方文档：https://docs.continuum.io/anaconda/install/linux.html 
在文件目录下执行：

```$xslt
bash Anaconda3-4.2.0-Linux-x86_64.sh
```
然后一路回车+yes

# 查看是否安装成功
```$xslt
anaconda -V
```

# 打开 Jupyter Notebook
```$xslt
终端输入：
ipython notebook
```

# 管理虚拟环境
## activate
activate 能将我们引入anaconda设定的虚拟环境中, 如果你后面什么参数都不加那么会进入anaconda自带的base环境,
```$xslt
conda activate
```
你可以输入python试试, 这样会进入base环境的python解释器, 如果你把原来环境中的python环境去除掉会更能体会到, 这个时候在命令行中使用的已经不是你原来的python而是base环境下的python.而命令行前面也会多一个(base) 说明当前我们处于的是base环境下.

## 创建虚拟环境
```$xslt
# 创建一个名字叫learn的python环境
conda create -n learn python=3
```

## 切换环境/开启环境
```$xslt
# 切换
conda activate learn
```
## 查看所有环境
```$xslt
conda env list
```
## 关闭环境
```$xslt
conda deactivate
```

新创建的环境除了官方包是没有其他的包的，是比较干净的环境

## 安装第三方包
```$xslt
1.切换到相关环境
conda activate learn
2.安装
conda install requests
或者
pip install requests
```
## 卸载第三方包
```$xslt
conda remove requests
或者
pip uninstall requests
```

## 查看环境包信息
```$xslt
conda list
```

## 导出当前环境
```$xslt
conda env export > environment.yaml
```

## 创建一个相同的环境
```$xslt
conda env create -f environment.yaml
```

# 常用命令列表
```$xslt
activate // 切换到base环境

activate learn // 切换到learn环境

conda create -n learn python=3 // 创建一个名为learn的环境并指定python版本为3(的最新版本)

conda env list // 列出conda管理的所有环境

conda list // 列出当前环境的所有包

conda install requests 安装requests包

conda remove requests 卸载requets包

conda remove -n learn --all // 删除learn环境及下属所有包

conda update requests 更新requests包

conda env export > environment.yaml // 导出当前环境的包信息

conda env create -f environment.yaml // 用配置文件创建新的虚拟环境


```

# 与pycharm连接

在Setting => Project => Project Interpreter 里面修改 Project Interpreter , 点击齿轮标志再点击Add Local为你某个环境的python.exe解释器就行了








