# echo、print_r、print、var_dump之间的区别


* echo、print是php语句，var_dump和print_r是函数
* echo 输出一个或多个字符串，中间以逗号隔开，没有返回值是语言结构而不是真正的函数，因此不能作为表达式的一部分使用
* print也是php的一个关键字，有返回值 只能打印出简单类型变量的值(如int，string)，如果字符串显示成功则返回true，否则返回false
* print_r 可以打印出复杂类型变量的值(如数组、对象）以列表的形式显示，并以array、object开头，但print_r输出布尔值和NULL的结果没有意义，因为都是打印"\n"，因此var_dump()函数更适合调试
* var_dump() 判断一个变量的类型和长度，并输出变量的数值