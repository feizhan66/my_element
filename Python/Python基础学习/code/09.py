# 构造函数
class A:
    def __init__(self):
        print("A")


class B(A):
    def __init__(self, name):
        print("B")
        print(name)


class C(B):
    """
    C中想扩展B的构造函数
    即调用B的构造函数后再添加一些功能
    两种方法可以实现：
    一：通过父类名实现
    """
    '''
    def __init__(self, name):
        # 首先调用父类构造函数
        B.__init__(self, name)
        # 其次，再增加自己的功能
        print("这是C中附加的功能")
    '''
    def __init__(self, name):
        super(C, self).__init__(name)
        print("这是C中附加功能")

    def __getattr__(self, item):
        print("访问不存在的属性时触发")
        print(item)  # 输出调用的方法


c = C("我是C")
c.fff


