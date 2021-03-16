

## 创建数据库
```angular2html
// 如果数据库不存在，则创建数据库，否则切换到指定数据库。
use DATABASE_NAME
```

## 查看所有数据库
```angular2html
show dbs
```

## 查看数据库里面所有的表
```angular2html
// use database
show tables
```

## 删除数据库
```angular2html
// 需要先 use.database 进入到里面再删除
db.dropDatabase()
```

## 创建集合
```angular2html
db.createCollection(name,options)
// name:要创建的集合名称
// options:可选参数, 指定有关内存大小及索引的选项
```

## 查看已有集合
```angular2html
show collections
```

## 删除集合
```angular2html
// collection 是待删除的集合名称
db.collection.drop()
```

## 插入文档
```angular2html
// 这个需要插入毒对象
db.COLLECTION_NAME.insert({})
```
## 查询文档
```angular2html
db.COLLECTION.find()
```
## 更新文档 1
```angular2html
db.COLLECTION.update(<query>,<update>,{upsert:<boolean>,multi:<boolean>,writeCollection:<document>})

query : update的查询条件，类似sql update查询内where后面的。
update : update的对象和一些更新的操作符（如$,$inc...）等，也可以理解为sql update查询内set后面的
upsert : 可选，这个参数的意思是，如果不存在update的记录，是否插入objNew,true为插入，默认是false，不插入。
multi : 可选，mongodb 默认是false,只更新找到的第一条记录，如果这个参数为true,就把按条件查出来多条记录全部更新。
writeConcern :可选，抛出异常的级别。

// 例子：
db.col.update({"title":"DEMO"}),{$set:{"title":"MongoDB"}}

```
## 更新文档 2 - 根据ID来更新
```angular2html
db.COLLECTION.save({
"_id":ObjectId(),
}),
"table":"ffff"
```
## 删除文档
```angular2html
db.COLLECTION.remove(<query>,{hustOne:<boolean>,writeConcern:<document>})

query :（可选）删除的文档的条件。
justOne : （可选）如果设为 true 或 1，则只删除一个文档。
writeConcern :（可选）抛出异常的级别。
```

## 清空文档
```angular2html
db.COLLECTION.remove({})
```







