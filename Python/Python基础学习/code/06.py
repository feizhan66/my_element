class A:
    pass


class B(A):
    pass


class C(B, A):
    pass


# mro 可以查询任意一个类的血统 super

print(A.__mro__)
print(B.__mro__)
print(C.__mro__)















