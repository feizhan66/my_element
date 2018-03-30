# 函数文档
def documentExam(name):
    """
    名字->这里的参数是名字
    :param name: name
    :return: name
    """
    return '名字:'+name

data = documentExam('黄新云')
print(data)
# 显示文档
do = documentExam.__doc__
print(do)

print("*****************闭包******************")
def funX(x):
    def funY(y):
        return x*y
    return funY
# 说明：调用funY

print(funX(8)(6))

i = funX(8)
print(i(5))


g = lambda x : 2*x+1
print(g(5))


dd = list(filter(lambda x : x % 2 , range(10)))
print(dd)

gg = list(map(lambda x : x * 2 , range(10)))
print(gg)