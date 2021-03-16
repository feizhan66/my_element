
# MongoDB $type 操作符

$type操作符是基于BSON类型来检索集合中匹配的数据类型，并返回结果。

```angular2html
类型	数字	备注
Double	1	 
String	2	 
Object	3	 
Array	4	 
Binary data	5	 
Undefined	6	已废弃。
Object id	7	 
Boolean	8	 
Date	9	 
Null	10	 
Regular Expression	11	 
JavaScript	13	 
Symbol	14	 
JavaScript (with scope)	15	 
32-bit integer	16	 
Timestamp	17	 
64-bit integer	18	 
Min key	255	Query with -1.
Max key	127	 
```

## MongoDB 操作符 - $type 实例
如果想获取 "col" 集合中 title 为 String 的数据，你可以使用以下命令：
```angular2html
db.col.find({"title" : {$type : 2}})
```








