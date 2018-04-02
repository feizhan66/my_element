# 函数的递归调用，注意这只是一个方法，不是一个类
def aa():
    temp = input("输入数字:")
    try:
        guess = int(temp)
        if guess == 8:
            print("答对了")
        else:
            print("打错了")
        print("游戏结束")
    except:
        print('不是数字')
        aa()

aa()