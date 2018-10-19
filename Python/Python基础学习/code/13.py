# 自己组装一个类

class A:
    pass

def say(self):
    print("Saying...")
    print(self)

say(99)

A.say = say

a = A()
a.say()


# => 一样

class B:
    def say(self):
        print("B Say")
        print(self)

b = B()
b.say()






