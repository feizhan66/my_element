四种语句
PHP中有四个加载文件的语句：include、require、include_once、require_once。

 

 

基本语法
require：require函数一般放在PHP脚本的最前面，PHP执行前就会先读入require指定引入的文件，包含并尝试执行引入的脚本文件。require的工作方式是提高PHP的执行效率，当它在同一个网页中解释过一次后，第二次便不会解释。但同样的，正因为它不会重复解释引入文件，所以当PHP中使用循环或条件语句来引入文件时，需要用到include。

 

include：可以放在PHP脚本的任意位置，一般放在流程控制的处理部分中。当PHP脚本执行到include指定引入的文件时，才将它包含并尝试执行。这种方式可以把程序执行时的流程进行简单化。当第二次遇到相同文件时，PHP还是会重新解释一次，include相对于require的执行效率下降很多，同时在引入文件中包含用户自定义函数时，PHP在解释过程中会发生函数重复定义问题。

 

require_once / include_once：分别与require / include作用相同，不同的是他们在执行到时会先检查目标内容是不是在之前已经导入过，如果导入过了，那么便不会再次重复引入其同样的内容。
————————————————
版权声明：本文为CSDN博主「李闪磊」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
原文链接：https://blog.csdn.net/lishanleilixin/article/details/81123500
