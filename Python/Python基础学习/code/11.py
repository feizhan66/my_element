# 变量的三种方法

class A:
    def __init__(self):
        self.name = "yun"
        self.age = 18

a = A()
a.name = "huang"
print(a.name)
del a.name
# print(a.name)  # 没有了，就会操作












