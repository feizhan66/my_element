# 棱形继承问题


class A:
    pass


class B(A):
    pass


class C(A):
    pass


class D(B, C):
    pass


print(D.__mro__)
