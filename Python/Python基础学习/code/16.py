# time模块

import time

# 获取时间戳，精确的
print(time.time())

# 返回字符串化后的时间格式
# Thu Sep 13 14:48:46 2018
print(time.asctime())

# 系统当前的时区和UTC时间相差的描述
# UTC时间简当前地区时间
print(time.timezone)  # -28800

# 得到当前时间的时间结构
# 可以通过点好操作符得到内容
# 返回元组
print(time.localtime())
print(time.localtime().tm_year)

# 获取字符串化的当前时间
print(time.ctime())


# 通过时间元组获取时间戳
print(time.mktime(time.localtime()))


# cpu时间
print(time.process_time())  # cup处理时间
print(time.perf_counter())  # cpu等待状态


# 睡眠
# print(time.sleep(2))
for i in range(10):
    print(i)
    # time.sleep(1)


print(time.process_time())  # cup处理时间
print(time.perf_counter())  # cpu等待状态


t = time.localtime()  # 获取当前时间元组 type=>time.struct_time
print(type(t))
print(t)
ft = time.strftime('%Y-%m-%d %T %p', t)
print(ft)

