
```angularjs
>>> try:
...     print('try...')
...     r = 10 / 0
...     print('result:', r)
... except ZeroDivisionError as e:
...     print('except:', e)
... finally:
...     print('finally...')
...
try...
except: division by zero
finally...
```


复制代码

如果try代码块可能出现多种错误类型，可以编写多个except代码块来处理；此外，如果没有发生错误，还可以在except代码块后面加上else语句，当没有错误的时候，会自动执行else语句：

```angularjs
>>> try:
...     print('开始：')
...     r = 10 / int('2')
...     print('结果：',r)
... except ValueError as e:
...     print('ValueError:',e)
... except ZeroDivisionError as e:
...     print('ZeroDivision:',r)
... else:
...     print('没有出错！')
... finally:
...     print('最后要执行的代码')
...
开始：
结果： 5.0
没有出错！
最后要执行的代码
```









