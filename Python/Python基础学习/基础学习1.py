# name = input("请输入你的名字:")
#
# print("你的名字是:{0}".format(name))
#
# if name == "yun":
#     print("哈哈，输入正确")
# else:
#     print("输入错误")

# for name in ['tom', 'yun', 'liu']:
#     print(name)
#
# for i in range(5):
#     print(i)

# for name in ['huang', 'xin', 'yun']:
#     print(name)
#     if name == 'huang':
#         print("这是我的姓")
#     else:
#         print("这是我的名字")
# else:
#     print("没有了")

# for _ in range(10):
#     print("输出")

# for i in range(5):
#     if i % 2 == 1:
#         print("这是基数")
#         continue
#     else:
#         print("{0}是偶数".format(i))

# for i in range(5):  # 定义了但是没实现，占位置，防止报错,没有跳过功能，只表示占坑
#     pass
#
# for i in range(5):
#     pass
#     print(i)

# ben = 1000
# year = 0
# while ben < 2000:
#     ben = ben * (1+0.067)
#     year += 1
#     print("第{0}年拿了{1}块钱".format(year, ben))
# else:
#     print("本钱翻倍了，庆祝一下")


# def func():
#     print("这是函数")
#
#
# func()  # 调用

# # 9*9乘法表
# for row in range(1, 10):
#     # 打印一行
#     for col in range(1, row+1):
#         print("{0} * {1} = {2} | ".format(row, col, row*col), end="")
#     print("")

# help(print)

# def stu(*args):
#     print(args)
#
#
# stu()
#
#
# stu("huang", "xin", 18)

# # 字符串乘法
# print("*"*10)

# # 字典的访问
# kwargs = {"key": "value"}
# for k, v in kwargs.items():
#     print(k, "---", v)

# # 传值进来的是字典，注意两个星号
# def stu(**kwargs):
#     print(type(kwargs))
#     for k, v in kwargs.items():
#         print(k, "---", v)
#
#
# stu(name="huang", kk="xin")

# print(type({1, 2}))

# # 注意参数的顺序
# def func(name, age, *args, hobby="没有", **kwargs):
#     print("hello大家好")
#     print("我叫{0}，今年{1}岁了".format(name, age))
#     if hobby == "没有":
#         print("我没有爱好")
#     else:
#         print("我的爱好是{0}".format(hobby))
#
#     print("*" * 20)
#     for i in args:
#         print(i)
#
#     print("#" * 30)
#
#     for k, v in kwargs.items():
#         print(k, "-", v)
#
#
# # func("yun", 25)
# # func("yun", 25, "羽毛球")
# func("yun", 25, "huang", hobby="羽毛球", keys="value", hobby2="足球")

# def stu(*args):
#     for i in args:
#         print(i)
#
# # stu("huang","xin",2,3)
#
# # 传入list不行的！！！，传入的应该是元组
# l = list()  # []
# l.append("huang")
# l.append(3)
# l.append(45)
# stu(l)  # 注意：进入里面是元组，list不行，也就是把l当成是一个值，就是传入了一个list类型的值

# def stu():
#     """
#     这是文档2
#     """
#     print('demo')
#
#
# # stu()
# # # 注意没有括号
# # help(stu)
#
# print(stu.__doc__)




