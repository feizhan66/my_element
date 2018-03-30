class Hellow_im:
    #构造函数
    def __init__(self,name):
        self.name = name

    def sayHellow(self):
        print("Import file {0}".format(self.name))

# Hellow_im.sayHellow('hxy')
c = Hellow_im('黄新云')
a = c.sayHellow()


class class_im:
    def __init__(self,name):
        self.name = 'hxy'

    def aas(self):
        print(self.name)

v = class_im('dd')
p = v.aas()



