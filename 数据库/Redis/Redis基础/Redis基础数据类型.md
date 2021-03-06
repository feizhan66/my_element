# Redis基础

 一、五种数据类型
 - string(字符串)
 - list(列表)
 - set(集合)
 - hsah(散列)
 - zset(有序集合)

二、五种结构

结构类型 | 结构存储的值 | 结构的读写能力
---|---|---
string | 可以是字符串、整数或浮点数 | 对整个字符串或者字符串其中的一部分执行操作：<br>对整数和浮点数执行自增(incremeng)或者自减(decrement)操作
list | 一个链表，链表上的每个节点都包含了一个字符串 | 从链表：两端推入或者弹出元素；根据偏移量对链表进行修剪(trim)；<br>读取单个或者多个元素；<br>根据值查找或删除元素
set | 包含字符串的无序收集器(unordered collection)，并且被包含的每个字符串都是独一无二、各不相同的 | 添加、获取、删除单个元素；<br>检查一个元素是否存在于集合中；<br>计算交集、并集、差集；从集合里面随机获取元素
hash | 包含键值对的无序散列表 | 添加、获取、删除单个键值对；获取所有键值对
zset | 字符串成员(member)与浮点数分值(score)之间的有序映射，<br>元素的排列顺序由分值的大小决定 | 添加、获取、删除单个元素；根据分值范围(range)或者成员来获取元素


三、最基础的使用
- set get del 三个命令
```
redis-cli (启动客户端)

- String
set key value (设置一个键值对)
get key (获取键值对)
del key (删除键值对)
// set name huangxinyun
```
四、Redis中的列表

```
lpush 将元素插入列表的左边
rpush 将元素插入列表的右边

lpop 左边弹出元素
rpop 右边弹出元素

lindex 获取列表在指定位置上的一个元素
lrange 获取列表在给定范围上的所有元素

lpush key value
lrange key 0 10
```

五、Redis的集合 Set

```
sadd 将元素添加到集合
srem 从集合中移除元素
sismember 快速查找一个元素是否在集合中
smembers 获取集合包含的所有元素

```

六、Redis的散列Hash
- Redis的散列可以存储多个键值对之间的映射。和字符串一样，散列存储的值既可以是字符串又可以是数值，并且用户同样可以对散列存储的数字值执行自增操作或者自减操作
- 相当于关系型数据库里面的行

```
hset 在散列里面关联起来给定的键值对
hget 获取指定散列键的值
hgetall 获取散列包含的所有键值对
hdel 如果给定散列存在于散列里面，那么移除这个键

- Hash
HMSET user:1 username huangxinyun password 123456
HGETALL user:1
```

七、Redis的有序集合

```
zadd 将一个带有给定分值的成员添加到有序集合里面
zrange 根据元素在有序排列中所处的位置，从有序集合里面获取多个元素
zrangebyscore 获取有序集合在给定分值范围内的所有元素
zrem 如果给定成员存在于有序集合，那么移除这个成员

zadd key 0 redis
zrangebyscore key 0 1000
```






