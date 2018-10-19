# 异常的实例
num = input('输入除数：')
print(num)

try:
    num = int(num)
    gg = 100/num
    print(gg)

except ZeroDivisionError as e:
    print("除数不允许为0")
    print(e)
    exit()

except Exception as e:
    print(e)
    print("就是有异常")
else:
    print("没有异常")
finally:
    print("这是所有都要输出的")



