# 函数初览
def functionFirst():
    print('这是我的第一个函数')
# 调用函数
functionFirst()


print('*******************************')

for i in range(5):
    print(i)
    functionFirst()

print('*******************************')

def functionTwo(name):
    print("传入的参数"+name)

functionTwo('name')


# 可变参数
print('-------------------------------可变参数-----------------------------------')
def test(*param):
    print(param)
    print(param[0])
    print('有%d个参数' % len(param))

test(1,2,3,4,5)
test("kkkk","jj",5)

a = ["dd",'dd']
test(a)#吧a当做一个参数
test(*a)#吧a里面每一个参数作为参数-----解包












