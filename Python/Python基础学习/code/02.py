class Student:
    name = "yun"
    age = 18

    def say(self):
        self.name = "fff"
        self.age = 20
        # print("ddd")

    def sayAgain(s):
        print("My name is {0}".format(s.name))
        print("My age is {0}".format(s.age))
        pass


# print(Student.name)
# print(Student.age)
# print(id(Student.name))
# print(id(Student.age))
#
# a = Student()
# print(Student.__dict__)
# print(Student.__dict__)


# 这里的注意点是参数 self 是全局的，在一个方法里面改变了，在其他方法可以直接使用
# self并不是关键字，只是一个用于接受对象的普通参数，理论上可以用任何一个普通变量名词代替
# yun = Student()
# yun.say()
# yun.sayAgain()


class Teacher:
    name = "teacher"
    age = 19

    def say(self):
        self.name = "say"
        self.age = 20
        print("Say name {0}".format(self.name))
        print("Say age {0}".format(self.age))
        print("*"*20)
        print(__class__.name)
        print(__class__.age)
        print("*"*20)

    def sayAgain():
        print(__class__.name)
        print(__class__.age)
        print("Hello, nice to see you")


# self不是关键字！

# t = Teacher()
# t.say()  # 可以用
# # t.sayAgain()  # 没有 self 就报错 =》 只要用实例去调用，系统默认会把实例作为参数传进去
# Teacher.sayAgain()  # 用类名去调用就可以


# 关于 self 的案例

class A:
    name = 'a'
    age = 18

    def __init__(self):
        """
        这个是构造函数
        """
        self.name = "init"
        self.age = 20

    def say(self):
        print(self.name)
        print(self.age)


class B:
    name = "b"
    age = 19


a = A()
a.say()  # 构造函数之后的值 =》 会默认传a对象进去
# A.say()  # 不能这么调用，参数 self 的问题 =》 不会自动传A对象进去
A.say(a)  # 这样可以， self 被 a 替换 20
A.say(A)  # 这样可以 18

A.say(B)  # 把 class B放进去，因为B具有name和age属性，所以不会报错

# ↑↑↑ 以上代码，利用的是鸭子模型  =》 看起来像这个东西，用起来也是这个东西，就认为是这个东西




















