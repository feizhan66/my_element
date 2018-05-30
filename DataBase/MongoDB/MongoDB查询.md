

## 查询文档【详细】

基本语法
```angular2html
db.COLLECTION.find(query,projection)

query ：可选，使用查询操作符指定查询条件
projection ：可选，使用投影操作符指定返回的键。查询时返回文档中所有键值， 只需省略该参数即可（默认省略）。
```
如果你需要以易读的方式来读取数据，可以使用 pretty() 方法，语法格式如下：
```angular2html
db.col.find().pretty()
```
除了 find() 方法之外，还有一个 findOne() 方法，它只返回一个文档。
```angular2html
db.CONNECTION.findOne()
```

## MongoDB 与 RDBMS Where 语句比较

```angular2html

操作	格式	范例	RDBMS中的类似语句
等于	{<key>:<value>}	db.col.find({"by":"菜鸟教程"}).pretty()	where by = '菜鸟教程'
小于	{<key>:{$lt:<value>}}	db.col.find({"likes":{$lt:50}}).pretty()	where likes < 50
小于或等于	{<key>:{$lte:<value>}}	db.col.find({"likes":{$lte:50}}).pretty()	where likes <= 50
大于	{<key>:{$gt:<value>}}	db.col.find({"likes":{$gt:50}}).pretty()	where likes > 50
大于或等于	{<key>:{$gte:<value>}}	db.col.find({"likes":{$gte:50}}).pretty()	where likes >= 50
不等于	{<key>:{$ne:<value>}}	db.col.find({"likes":{$ne:50}}).pretty()	where likes != 50

$lt --> <
$lte --> <=
$gt --> >
$gte --> >=
$ne --> != 
```

## MongoDB AND 条件
MongoDB 的 find() 方法可以传入多个键(key)，每个键(key)以逗号隔开，即常规 SQL 的 AND 条件。
```angular2html
db.col.find({key1:value1, key2:value2}).pretty()
```

## MongoDB OR 条件
MongoDB OR 条件语句使用了关键字 $or,语法格式如下：
```angular2html
db.col.find(
   {
      $or: [
         {key1: value1}, {key2:value2}
      ]
   }
).pretty()
// 实例
db.col.find({$or:[{"by":"菜鸟教程"},{"title": "MongoDB 教程"}]}).pretty()
```

## AND 和 OR 联合使用
以下实例演示了 AND 和 OR 联合使用，类似常规 SQL 语句为： 'where likes>50 AND (by = '菜鸟教程' OR title = 'MongoDB 教程')'

```angular2html
db.col.find({"likes": {$gt:50}, $or: [{"by": "菜鸟教程"},{"title": "MongoDB 教程"}]}).pretty()
```
## MongoDB (>) 大于操作符 - $gt
如果你想获取 "col" 集合中 "likes" 大于 100 的数据，你可以使用以下命令：
```angular2html
db.col.find({"likes" : {$gt : 100}})
```
类似于SQL语句：
```angular2html
Select * from col where likes > 100;
```

## MongoDB 使用 (<) 和 (>) 查询 - $lt 和 $gt
如果你想获取"col"集合中 "likes" 大于100，小于 200 的数据，你可以使用以下命令：
```angular2html
db.col.find({likes : {$lt :200, $gt : 100}})
```
类似于SQL语句：
```angular2html
Select * from col where likes>100 AND  likes<200;
```

## MongoDB Limit() 方法
如果你需要在MongoDB中读取指定数量的数据记录，可以使用MongoDB的Limit方法，limit()方法接受一个数字参数，该参数指定从MongoDB中读取的记录条数。
```angular2html
db.COLLECTION_NAME.find().limit(NUMBER)
```
注：如果你们没有指定limit()方法中的参数则显示集合中的所有数据。

## MongoDB Skip() 方法[跳过多少个]
我们除了可以使用limit()方法来读取指定数量的数据外，还可以使用skip()方法来跳过指定数量的数据，skip方法同样接受一个数字参数作为跳过的记录条数。
```angular2html
db.COLLECTION_NAME.find().limit(NUMBER).skip(NUMBER)
```
注:skip()方法默认参数为 0 。

# MongoDB排序
## MongoDB sort()方法
在MongoDB中使用使用sort()方法对数据进行排序，sort()方法可以通过参数指定排序的字段，并使用 1 和 -1 来指定排序的方式，其中 1 为升序排列，而-1是用于降序排列。
```angular2html
db.COLLECTION_NAME.find().sort({KEY:1})
```

```angular2html
db.col.find({},{"title":1,_id:0}).sort({"likes":-1})
```










