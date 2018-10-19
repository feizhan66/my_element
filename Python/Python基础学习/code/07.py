# 多继承实例


class Fish:
    def __init__(self, name):
        self.name = name

    def swim(self):
        print("I am swimming...")


class Bird:
    def __init__(self, name):
        self.name = name

    def fly(self):
        print("I am flying...")


class Person:
    def __init__(self, name):
        self.name = name

    def work(self):
        print("working...")


# 多继承
class SuperMan(Person, Bird, Fish):
    def __init__(self, name):
        self.name = name
    pass


# 单继承
class Student(Person):
    def __init__(self, name):
        self.name = name
    pass


# 多继承实例化父类是有顺序的
s = SuperMan("yun")
s.fly()
s.work()
s.swim()
print(SuperMan.__mro__)


stu = Student("yun")
s.work()









