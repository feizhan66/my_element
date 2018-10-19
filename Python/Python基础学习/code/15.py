# 日历模块

import calendar

# calendar 获取一年的日历字符串
# 参数
# w = 每个日期之间的间隔字符数
# l = 每周所占的行数
# c = 每个月之间的间隔字符数

cal = calendar.calendar(2017)

cal = calendar.calendar(2018,l=1,w=2,c=5,m=4)

# print(type(cal))
# print(cal)

# isleap: 判断某一年是否闰年
print(calendar.isleap(2000))

# leapdays 获取指定年份之间闰年的个数
print(calendar.leapdays(1998,2018))

help(calendar.leapdays)

# 返回一个月
print(calendar.month(2018,9))

# 返回每个月的周几开始 和 该月的总天数
# 0-6 代表周一到周日
# 返回元组
print(calendar.monthrange(2018,9))

# 返回一个月每天的矩阵
# 没有的天就会用0补齐
print(calendar.monthcalendar(2018,9))

# pracl 直接打印日历
calendar.prcal(2018)



