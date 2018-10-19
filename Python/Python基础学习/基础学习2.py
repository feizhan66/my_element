# a1 = 100
# def func():
#     global a2
#     a2 = 200
#     print("inner fun")
#
#
# func()
# print(a2)  # 注意：这个必须是在调用函数之后才可以使用内置函数的全局变量

# a = 1
# b = 2
#
#
# def func(c, d):
#     e = 123
#     print("Locals={0}".format(locals()))
#     print("Globals={0}".format(globals()))
#
#
# func(1, 1)


# x = 100
# y = 200
# z = eval("x+y")
# print(z)


# x=100
# y=200
# z = exec("print('x+y:',x+y)")

# x = 0
# def func(x):
#     x += 1
#     print(x)
#     func(x)
#
# func(x)


# l = [6, 2]
# print(type(l))
# # l[0] = 6
# print(l)
# print(l[0])
# l.append(9)  # 在末尾添加一个值
# print(l)
# l.pop(0)  # 删除某索引的值
# print(l)
# l.remove(2)  # 删除特定值
# print(l)
# q = l
# p = l.copy()  # 复制
# f = l[:]  # 复制
# print(q)
# print(p)
# print(l)
# print(f)
# q.append(9)  # q = l
# p.append(5)
# l.append(6)  # q = l
# f.append(2)
# print(q)
# print(p)
# print(l)
# print(f)

# l = [1, 2, 3, 4, 5, 6, 7, 8, 9]
# print(l[0:6:2])
# print(l[-4:-1])
# print(l[-1:-4:-1])

# a = 100
# b = 200
# c = a
# d = c + 1
# print(id(a))
# print(id(b))
# print(id(c))
# print(id(d))

# a = [1, 2, 3, 4, 5, 6]
# b = [1, 2, 3, 4, 5, 6]
# c = a
# d = a.append(7)
# e = a[:]
# print(id(a))
# print(id(b))
# print(id(c))
# print(id(d))
# print(id(e))


# a = [1,2,3]
# b = [3,4,5]
# c = a + b
# print(c)
#
# d = a * 3
# print(d)
#
# e = a in b
# f = 3
# g = f in a  # bool
# h = f not in a
# print(e)
# print(g)
# print(h)

# b = {'a': 'f'}
# for k, v in b.items():
#     print(k, v)


# a = [["one", 1, "eins"], ["two", 2, "zwi"]]
# for k, v, w in a:
#     print(k, v, w)

# a = ['a','b','c']
# b = [i for i in a]
# c = [i * 10 for i in a]
# print(b)
# print(id(a))
# print(id(b))
# print(c)

# a = [x for x in range(1,35)]
# print(a)
# b = [m for m in a if m % 2 == 0]
# print(b)

# a = [i for i in range(1,10)]
# print(a)
#
# b = [i for i in range(1,1000) if i % 100 == 0]
# print(b)
# # 列表生成可以嵌套
# c = [m+n for m in a for n in b]
# print(c)
#
# d = [m+n for m in a for n in b if m+n < 250]
# print(d)


# a = [x for x in range(1, 100)]
# print(len(a))

# a = [x for x in range(1,100)]
# print(max(a))
#
# b = ["huang","xin"]
# print(max(b))

# a = [1,2,3]
# print(list(a))
# s = "huaung xin yun"
# print(list(s))
# print(list(range(1,10)))

# l = ['a', 'huang', 45, 766, 5+4j, (6, 9)]
# print(l)  # ['a', 'huang', 45, 766, (5+4j), (6, 9)]

# a = [1,2,3]
# a.insert(2,666)
# print(a)

# a = [1,2,3,4,5]
# print(a)
# b = a.pop() # 默认弹出最后一个
# print(b)
# print(a)
# c = a.pop(1)
# print(c)
# print(a)

# try:
#     a = [1,2,3]
#     a.remove(1)
#     a.remove(4)
#     print(a)
# except Exception as e:
#     print(e)
# finally:
#     print('f')

# a = [1,2,3]
# print(id(a))
# a.clear()
# print(a)
# print(id(a))

# a = [1,2,3]
# print(id(a))
# a = [] # a = list()
# print(id(a))

# a = [1,2,3,4]
# print(a)
# print(id(a))
# a.reverse()
# print(a)
# print(id(a))


# a = [1,2,3]
# b = [4,5,6]
# c = a.extend(b) # 没有返回值的，是在a上拼接
# print(c)
# print(a)
# print(b)

# a = [1,2,3,3]
# b = a.count(3)
# print(b)

# a = [1,2,3,4]
# b = a
# print(a)
# b[3] = 777
# print(a)
# print(b)
# print(b[3])
# c = b[3]
# print(c)

# 浅拷贝与深拷贝区别
a = [1,2,3,[10,20,30]]
b = a.copy()
c = a[:]
print(id(a))
print(id(b))
print(id(c))
print(id(a[3]))
print(id(b[3]))
print(id(c[3]))
a[3][2] = 600
print(a)
print(b)
print(c)



























