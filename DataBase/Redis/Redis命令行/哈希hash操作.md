# 哈希Hash(其实就是保存键值对，有点像JSON)

Redis hash 是一个string类型的field和value的映射表，hash特别适合用于存储对象。

Redis 中每个 hash 可以存储 232 - 1 键值对（40多亿）。 

例子：
```bash
HMSET runoobkey name "redis tutorial" description "redis basic commands for caching" likes 20 visitors 23000

HGET runoobkey name

HGETALL runoobkey
```

删除一个或多个哈希表字段
```bash
HDEL key field1 [field2]
```
查看哈希表 key 中，指定的字段是否存在。
```bash
HEXISTS key field
```
获取存储在哈希表中指定字段的值。
```bash
HGET key field
```
获取在哈希表中指定 key 的所有字段和值
```bash
HGETALL key
```
为哈希表 key 中的指定字段的整数值加上增量 increment 。
```bash
HINCRBY key field increment
```
为哈希表 key 中的指定字段的浮点数值加上增量 increment 。
```bash
HINCRBYFLOAT key field increment
```
获取所有哈希表中的字段
```bash
HKEYS key
```
获取哈希表中字段的数量
```bash
HLEN key
```
获取所有给定字段的值
```bash
HMGET key field1 [field2]
```
同时将多个 field-value (域-值)对设置到哈希表 key 中。
```bash
HMSET key field1 value1 [field2 value2 ]
```
将哈希表 key 中的字段 field 的值设为 value 。
```bash
HSET key field value
```
只有在字段 field 不存在时，设置哈希表字段的值。
```bash
HSETNX key field value
```
获取哈希表中所有值
```bash
HVALS key
```
迭代哈希表中的键值对。
```bash
HSCAN key cursor [MATCH pattern] [COUNT count] 
```








