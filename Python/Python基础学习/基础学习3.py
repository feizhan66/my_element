
# t = ()
# print(type(t))

# t = (1,)  # tuple
# t1 = (1)  # int
# print(type(t))
# print(type(t1))
# print(t)
# print(t1)
# t2 = 1,2,3
# print(type(t2))
# print(t2)

# t = (1,2,3)
# # print(t[4])  # 报错
# print(t[1:5])  # 切片，可以

# t1 = (1,2,3)
# t2 = (4,5,6)
#
# print(id(t1))
# print(id(t2))
#
# t1 = t1 + t2
# print(id(t1))
# print(t1)

# t = (1,2,3)
# for v in t:
#     print(v)

# t = (1,2,3)
# print(t.index(3))

# t = ((1,2,3),(4,5,6))
# for v in t:
#     print(v)
#
# for k,m,n in t:
#     print(k,m,n)

# a = 1
# b = 2
#
# print(a)
# print(b)
#
# print("*" * 12)
#
# # java写法
# c = a
# a = b
# b = c
# print(a)
# print(b)
#
# print("*" * 12)
#
# # python写法
# # a,b = b,a
# # print(a)
# # print(b)


# s= set()
# print(type(s))
# print(s)
#
# s2 = {1,2,3}
# print(type(s2))
# print(s2)
# s3 = {}
# print(type(s3))
# print(s3)
#
# s4 = {'ff':'gg'} # 这是字典
# print(type(s4))
# print(s4)

# s = {4,5,"i","yun"}
# print(s)

# s = {(1,2,3),("i","f","g"),(4,5,6)}
# for k,m,n in s:
#     print(k,m,n)

# s = {23,34,456,1,23,4,5,1,1,2,2,2,3,3,3,4,4,4,4}
# print(s)
#
# ss = {i for i in s}
# print(ss)
#
# sss = {i for i in s if i % 2 == 0}
# print(sss)

# s1 = {1,2,3,4}
# s2 = {"i","f","g"}
# s = {m*n for m in s2 for n in s1}
# print(s)


# l = [1,2,3]
# s = set(l)
# print(s)

# s = {2,3}
# print(id(s))
# s.clear()
# print(id(s))

# s = {12,4,45,6,6,7,7}
# print(s)
# print(id(s))
# s.remove(6)
# print(s)
# print(id(s))
# s.discard(4)
# print(s)
# print(id(s))
#
# s.discard(4) # 不存在可以
# print(s)
#
# s.remove(6) # 不存在报错
# print(s)


# s = {7,1,2,3,4,5,6}
# print(s)
# s.pop()
# print(s)
# s.pop()
# print(s)

# s1 = {1,2,3,4,5,6}
# s2 = {6,7,8,9}
# s_1 = s1.intersection(s2)
# print(s_1)


# s1 = {1,2,3,4}
# s2 = {4,5,6}
# s_2 = s1 - s2
# print(s_2)
# s_1 = s1 + s2 # 相加不支持
# print(s_1)


# s = frozenset()
# print(type(s))
# print(s)


# d = {}
# print(type(d))
#
# d = dict()
# print(type(d))
#
# d = {"one":"one","two":"two","two":"two9"}
# print(d)

# d = {"one":"one","two":"two"}
# print(d["one"])
# d["one"] = "ffff"
# print(d["one"])
# d["ff"] = "ggg"
# print(d)

# d = {"one":"onev","two":"twov"}
# # for k in d:
# #     print(k) # 只打印key
# #     print(d[k]) # 根据键找值
#
# for k,v in d.items():
#     print(k,v)

# d = {"one":1,"two":2,"three":3}
#
# dd = {k:v for k,v in d.items()}
#
# dds = {k:v for k,v in d.items() if v >1}
#
# print(dd)
# print(dds)

# d = {"one":1,"two":2}
# print(str(d))

# d = {"one":1,"two":2}
# i = d.items()
# print(type(i))
# print(i)

l = ["one","two"]
d = dict.formkeys(l,"value")
print(d)







