#循环的知识

# range范围

# for i in range(5): #代表从1到5(不包含5)
#     print(i)
#
# for ih in range(15,19):
#     print(ih)

# for i in range(5,10,2): #代表从5到10，间隔2(不包含5)
#     print(i)

# value = '黄新云是帅哥'
# answer = input("输入一句话:")
# while True:
#     if answer == value:
#         break
#     answer = input("输错，请重新输入:")
# print("哈哈，结束了")

# aaa = "kShUdf"
# for each in aaa:
#     print(each,end='')

# for i in range(10):
#     if i % 2 != 0:
#         print(i)
#         continue
#     i += 2

# 冒泡排序
# array = [1,15,2,6,3,4,8,9,16]
# for i in range(len(array)-1,0,-1):
#     print(i)
#     for j in range(0,i):
#         print(-j)
#         if array[j]>array[j+1]:
#             array[j],array[j+1]=array[j+1],array[j]
# print(array)

# 简单的
array2 = [1,15,2,6,3,4,8,9,16]
print(sorted(array2))

