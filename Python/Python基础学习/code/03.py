class Person:
    # name 是公共成员
    name = "程雨涵"
    # __age就是私有成员
    __age = 18


p = Person()
print(p.name)  # 共有变量，可以直接访问
# print(p.__age)  # 私有变量，不可以直接访问
# print(p.age)  # 不能
print(Person.__dict__)
print(Person._Person__age)  # 访问了age
print(p._Person__age)  # 访问了age