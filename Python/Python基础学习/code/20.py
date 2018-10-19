import random

# 生成一个随机数
print(random.random())

l = [1,2,3,5,6]

# 随机选择一个
print(random.choice(l))

# 打乱一个列表(在源列表基础上打乱)
random.shuffle(l)
print(l)

# 返回一个a到b之间的整数，包含a,b
print(random.randint(0,100))