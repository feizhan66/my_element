number = [1,2,3,4,5,6,7,8,9,"huangxinyun",3.14,["黄新云",159]]
number.append(6)#向数组里面添加元素
print(number)
number.extend(["k","jj"])#想数组结尾添加多个，注意中括号
print(number)
number.insert(1,"6")#向数组里面指定位置面添加
print(number)

print(number[10])#取指定的值

print(number)

print(number[1],number[2])
number.remove(6)#删除一个6，这是值,移去的是第一次找到的，这个必须要是在数组里面存在的
print(number)
print("------------------")
del number[1]#删除数组第二个元素
print(number)

number.pop()#删除最后一个
print(number)
number.pop(2)#删除第三个元素
print(number)

print("********************")
print(number[:9])#一次获取多个9个元素

print(number[3:5])#从第3个开始获取2个，第五个是不算

#分片还可以接收第三个参数就是步长
aa = [1,2,3,4,5,6,7,8,9,]
print(aa[0:9:2])


#数组比较
kk = [456]
bb = [444]
print(kk>bb)

#只比较第一个，第一个赢了就正确，如果是字符的话就比较ASCII
ee = [76,456]
ff = [77,55]
print(ee>ff)

print("ff" in ee)

print(dir(list))

pp = [1,2,3,4,5,6,7,8,9,]
print(pp.count(2))#2在数组里面有几个,出现的次数
print(pp.index(8))#2在哪里，返回键

gg = [9,8,7,11,5,4,78,2,1]
#将整个数组倒转
gg.reverse()
print(gg)


# 排序
gg.sort()
print(gg)

#sort(func,key,reverse)--三个默认排序参数
gg.sort(reverse=True)
print(gg)

#注意：引用只是给指向引用而已，内存是同一个的，之前一个改变了之后的也改变。想要不改变就用分片来“拷贝”
print("999999999999999999999999999999999999999999999999999999")
hh = [7,9,4,8,3,1,6,7]
tt = hh#指向
print(tt)
ii = hh[:]#拷贝
print(ii)
hh.sort()
print("------------------------------------------")
print(hh)
print(tt)
print(ii)



# 元组
#元祖个列表类似，元组是小括号，数组是大括号
#访问与数组一样，但是限制了一些功能，例如不能排序
#元组可以没有小括号
kkk = (46,78,99,1)
print(kkk)

#复制元组
jjj = kkk[:]
print(jjj)

#元组
ppp = 1,9,8,6
print(ppp)

# 明确元组
ggg = (6,)
print(ggg)
print(type(ggg))
