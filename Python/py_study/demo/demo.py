# coding=utf-8

print("hello word")

print("黄新云")


#判断
score = 90
if score>80:
    print("很好")
elif score<=80:
    print("很差")

#循环
#for i in range(0,100):
#    print(i)
#    print("Item {0},{1}".format(i,"huang xinyun"))#它不可以直接传多个参数，一定要写占位符和format

#定义函数
def huang():
    print("黄新云")

huang()

def huangxinyun(a,b):
    if a>b:
        print("A大于B")
    else:
        print("B大于A")

huangxinyun(5,6)

#面向对象

class Hellow:
    #构造函数
    def __init__(self,name):
        self.name = name

    def sayHellow(self):
        print("Python {0}".format(self.name))



#类继承类
class Hi(Hellow):
    def __init__(self,name):
         Hellow.__init__(self,name)

    def sayHi(self):
        print("Hi {0}".format(self.name))

h = Hellow("黄新云6666")
h.sayHellow()

f = Hi("huang")
f.sayHi()

#引入文件 第一种方法
from demo import class_demo

h = class_demo.Hellow_im("黄新云")
h.sayHellow()


#引入文件 第二种方法
from demo.import_file import Hellow_im
h = Hellow_im("黄新云")
h.sayHellow()

















