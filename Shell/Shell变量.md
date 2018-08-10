变量是一个字符串，我们分配一个值。分配的值可以是一个数字，文本，文件名，设备，或任何其他类型的数据。

变量是没有超过实际数据的指针。 shell，可以创建，分配和删除变量。

## 变量名

变量的名称可以包含只有字母（a到z或A到Z），数字（0〜9）或下划线（_）。

按照惯例，UNIX的shell变量将有自己的名称以大写字母。

下面的例子是有效的变量名：
```angular2html
_ALI
TOKEN_A
VAR_1
VAR_2
```
以下是无效的变量名的例子：
```angular2html
2_VAR
-VARIABLE
VAR1-VAR2
VAR_A!
```
不能使用其他字符，如！，*或 - 这些字符有特殊含义。

## 定义变量
变量定义如下:
```angular2html
variable_name=variable_value
```
例如
```angular2html
NAME="Zara Ali"
```

上面的例子中定义的变量名和分配值“Zara Ali”。这种类型的变量被称为标量变量。一个标量变量只能容纳一个值一次。

shell可以存储任何你想在一个变量的值。例如：
```angular2html
VAR1="Zara Ali"
VAR2=100
```
## 访问值
为了访问存储在一个变量的值，它的名字的前缀为美元符号（$）：

例如，下面的脚本将访问的价值定义的变量名，将它打印在标准输出：
```angular2html
#!/bin/sh

NAME="Zara Ali"
echo $NAME
```

这将产生以下值：
```angular2html
Zara Ali
```

## 只读变量
shell提供了一种标记为只读变量使用的只读命令。后一个变量被标记为只读的，它的值不能被改变。

例如，下面的脚本将给出错误提示，同时试图改变NAME的值： 

```angular2html
#!/bin/sh

NAME="Zara Ali"
readonly NAME
NAME="Qadiri"
```
这个结果将产生以下如下：
```angular2html
/bin/sh: NAME: This variable is read only.
```

## 取消设置变量
注销或删除的变量告诉shell删除的变量的变量列表做了跟踪。一旦您取消设置变量，你不可以访问存储在变量值。

以下是使用unset命令定义一个变量的语法：

```angular2html
#!/bin/sh

NAME="Zara Ali"
unset NAME # 试过，不起作用
echo $NAME
```
## 变量类型
当一个shell运行，存在三种主要类型的变量：

局部变量: 局部变量是一个变量所做的是在当前实例中的shell。这不是程序由shell开始。在命令提示符下设置。

环境变量: 环境变量是一个变量所做的是任何子进程的shell。有些程序需要以正常的环境变量。通常一个shell脚本定义，只有那些环境变量所需要的程序没有运行。

Shell 变量: shell变量是一个特殊的变量，由shell设置，也是shell正常需要。一些合成变量环境变量，而其他局部变量。


