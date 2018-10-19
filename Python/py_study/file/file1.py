a = open('../demo/array_demo.py','r',-1,'utf-8')
# print(a)
# b = a.read()
# print(b)

# print('-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*')

c = a.readline()  # 读取一整行字符串
print(c)
c1 = a.tell()  # 返回当前在文件中的位置
print(c1)

c2 = a.readline()  # 读取一整行字符串
print(c2)
c12 = a.tell()  # 返回当前在文件中的位置
print(c12)


# d = a.seek(68,75)
# print(d)
# d1 = a.tell()
# print(d1)

# 存放 - list非常的强大，什么都可以往里面放
l = list(a)
print(l)
# 遍历
# for each_line in l:
#     print(each_line)
#直接遍历也是可以的
for each_line in a:
    print(each_line)

# b1 = open('http://feizhan.me/public','r','-1','utf-8')#不能直接访问网址
# b2 = b1.read();
# print(b2)





