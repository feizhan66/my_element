# 定义一个学生类，用来形容学生
class Student:
    # 一个空类，pass代表直接跳过
    # 空类pass必须有
    pass


# 定义一个听课类
class PythonStudent:
    name = None
    age = 18
    course = "Python"  # 课程

    # 注意：
    # 1.注意缩进层级
    # 2.系统默认有一个self参数
    def doHomeWork(self):
        """
        666
        :keyword
        :return:
        """
        print("在做作业")
        # 函数末尾，默认会返回None，可以不写
        return None


xin = Student
xin2 = Student()

yun = PythonStudent()
print(yun.age)
print(yun.doHomeWork())
# print(yun.doHomeWork('yun'))

# 获取类的文档
# print(yun.__dict__)



