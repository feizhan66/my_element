# 继承语法
# 在py中，任何类都有一个公共的父类叫object


class Person:
    name = "NoName"
    age = 18
    __score = 0  # 考试成绩是秘密，中有自己知道
    _petname = "sec"  # 小名，是保护的，子类可以用，但不能共用

    def sleep(self):
        print("sleep")

    def work(self):
        print("make some money")


class Teacher(Person):  # 老师类继承人类
    def make_test(self):
        pass

    def work(self):
        """
        扩充父类的功能只需要调用父类相应的函数
        """
        # 方法1
        # Person.work(self)  # 子类可以冒充父类，但是父类不能冒充子类
        # 方法2
        super().work()
        self.make_test()


t = Teacher()
p = Person()

print(t.name)  # 继承过来的属性
print(Teacher.name)  # 继承过来的属性
print(t._petname)  # 父类受保护成员 =》 为啥可以访问？
print(p._petname)  # 父类直接访问
# print(t.__score)  # 父类私有成员，不可以直接访问

print("*"*20)
print(t.work())







