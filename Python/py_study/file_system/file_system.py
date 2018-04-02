import os
a = os.getcwd()#显示当前的路径
print(a)

os.chdir("D:\\开发资源包")#改变当前工作目录
b = os.getcwd()
print(b)

c = os.listdir('.')#列出当前路径下面所有的文件夹或者文件
print(c)

os.system("calc")#调出系统计算器

#遍历指定路径下的所有子目录，返回一个三元组(路径，[包括目录],[包含文件])
for i in os.walk('.'):
    print(i)



