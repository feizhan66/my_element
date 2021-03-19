# Redis 列表(List) 

 Redis列表是简单的字符串列表，按照插入顺序排序。你可以添加一个元素到列表的头部（左边）或者尾部（右边）

一个列表最多可以包含 232 - 1 个元素 (4294967295, 每个列表超过40亿个元素)。 

实例：
```bash
LPUSH runoobkey redis

LPUSH runoobkey mongodb

LPUSH runoobkey mysql

LRANGE runoobkey 0 10
```

移出并获取列表的第一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止
```bash
BLPOP key1 [key2 ] timeout
```
BRPOP key1 [key2 ] timeout
移出并获取列表的最后一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
```bash
BRPOP key1 [key2 ] timeout
```
从列表中弹出一个值，将弹出的元素插入到另外一个列表中并返回它； 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
```bash
BRPOPLPUSH source destination timeout
```
通过索引获取列表中的元素
```bash
LINDEX key index
```
在列表的元素前或者后插入元素
```bash
LINSERT key BEFORE|AFTER pivot value
```
获取列表长度
```bash
LLEN key
```
移出并获取列表的第一个元素
```bash
LPOP key
```
将一个或多个值插入到列表头部
```bash
LPUSH key value1 [value2] 
```
将一个值插入到已存在的列表头部
```bash
	LPUSHX key value
```
获取列表指定范围内的元素
```bash
LRANGE key start stop
```
移除列表元素
```bash
LREM key count value
```
通过索引设置列表元素的值
```bash
LSET key index value
```
对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除
```bash
LTRIM key start stop 
```
移除列表的最后一个元素，返回值为移除的元素。
```bash
RPOP key
```
移除列表的最后一个元素，并将该元素添加到另一个列表并返回
```bash
RPOPLPUSH source destination
```
在列表中添加一个或多个值
```bash
RPUSH key value1 [value2]
```
为已存在的列表添加值
```bash
RPUSHX key value
```











