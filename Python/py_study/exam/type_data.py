# 字符类型
# py中完全由存储在内存里面的数据来确定，完全不需要进行定义
# 但是在py看来还是有区别的
# 可以尝试一下

num1 = 123
a = type(num1)
print(a)
# type

num1 = "123"
b = type(num1)
print(b)

num1 = 123.3
c = type(num1)
print(c)

num1 = 123^160
d = type(num1)
print(d)



