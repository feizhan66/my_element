shell变量是有足够的能力保持一个单一的值。这种类型的变量被称为标量变量。

Shell支持不同类型的变量称为数组变量，可以在同一时间容纳多个值。阵列，提供了一组变量进行分组的方法的。而不是创建一个新的名称为每个变量所需要的，你可以使用一个单一的阵列存储所有其他变量的变量。

所有讨论shell变量的命名规则将适用数组命名。

## 定义数组值：
一个数组变量和标量变量之间的差异可以解释如下。

说，你正试图表示各种学生为变量集的名字。每一个单个变量是一个标量变量，如下所示：
```angular2html
NAME01="Zara"
NAME02="Qadir"
NAME03="Mahnaz"
NAME04="Ayan"
NAME05="Daisy"
```
我们可以用一个单一的阵列来存储所有上述提及的名称。以下是最简单的方法创建一个数组变量分配一个值，其索引之一。这是表示，如下所示：
```angular2html
array_name[index]=value
```
array_name 是数组名，索引是在阵列中，你要设置的项目索引，值是你想要的值设置该项目。 

作为一个例子，下面的命令：
```angular2html
NAME[0]="Zara"
NAME[1]="Qadir"
NAME[2]="Mahnaz www.yiibai.com"
NAME[3]="Ayan"
NAME[4]="Daisy"
```
如果您使用的是ksh shell在这里初始化数组的语法：
```angular2html
array_name=(value1 ... valuen)
```








