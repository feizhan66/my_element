
## 说明
pip是一个安装和管理Python包的工具。在Pip的帮助下，你可以安装独特版本的包。最重要的是，Pip可以通过一个“requirements”的工具来管理一个由包组成的列表和版本号。Pip很像easy_install，但是Pip有一些额外的特色。

## ubuntu 安装 pip 【系统默认版本的安装】
```angular2html
# 1. 更新系统包
sudo apt-get update
sudo apt-get upgrade

# 2. 安装Pip
sudo apt-get install python-pip

# 3. 检查 pip 是否安装成功
pip -V
```

## 非默认版本的安装
第一种可以通过源码的方式，下载源码，再用指定的python版本执行安装

另外可以从官网下载 get-pip.py，然后执行：

## pip 常用命令

- 查看pip帮助：pip -help
- 安装新的python包：pip install packageName
- 卸载python包：pip uninstall packageName
- 寻找python包：pip search packageName
