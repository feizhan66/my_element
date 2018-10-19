from package2 import *

stu = p01.Student()
stu.say()

# inInit()  # 包的init里面定义了__all__,那么其他非包的加载就会失效
