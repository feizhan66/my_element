import os

# 获取当前文件夹的绝对路径
mydir = os.getcwd()
print(mydir)

# 改变当前的工作目录 - 可以改变的(绝对目录)
os.chdir("D:/project/python_study/WatchVideo")

mydir = os.getcwd()
print(mydir)

# 获取一个目录的所有子目录和文件的名称列表
# 默认是当前文件
# 返回列表
ld = os.listdir("D:/project/python_study/WatchVideo")
print(ld)
ld2 = os.listdir()
print(ld2)

# 递归创建文件夹（递归路径）
# 默认如果文件夹存在的话就报错
help(os.makedirs)
md = os.makedirs("aa/aa",exist_ok=True)

# 运行系统命令
s = os.system("ls")
print(s)

# 获取指定的系统变量值
rst = os.getenv("PATH")
print(rst)

print("*"*20)

print(os.curdir)  # 当前目录
print(os.pardir)  # 父目录
print(os.sep)  # 当前系统的路径分隔符 => win:"\" linux: "/"
print(os.linesep)  # 当前系统的换行符号 => win: "\r\r"  linux: "\n"
print(os.name)  # 当前系统名称 => win:"nt"  linux:"posix"

print("*"*20)


# os.path 跟路径相关的模块
print(os.path)
print(os.path.abspath("."))


# os.path.basename 获取路径中文件名部分
bn = os.path.basename("D:\project\python_study\WatchVideo\基础学习1.py")
print(bn)


# os.path.join 将多个路径拼合成一个路径 => 其实找两个路径相同的部分
j = os.path.join("D:\project\python_study\WatchVideo","D:\project\python_study\WatchVideo\code")
print(j)


# os.path.split 将路径切割为文件夹部分和当前文件部分 =》 切割最后一部分而已
# 返回元组
t = os.path.split("D:\project\python_study\WatchVideo\基础学习1.py")
print(t)

t = os.path.split("D:\project\python_study\WatchVideo")
print(t)

# os.path.isdir 检测是否目录
print(os.path.isdir('D:\project\python_study\WatchVideo'))
print(os.path.isdir('D:\project\python_study\WatchVideo\基础学习1.py'))

# os.path.exists 检测文件/目录是否存在
print(os.path.exists("D:\project\python_study\WatchVideo\基础学习1.py"))





