# 借助于 importlib 包可以实现导入以数字开头的模块名称
import importlib

# 相当于导入了一个叫01的模块。并把模块值赋给了 luling 的变量
tuling = importlib.import_module("01")

stu = tuling.say()

