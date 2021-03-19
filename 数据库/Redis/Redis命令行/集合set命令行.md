# Redis 集合(Set)

Redis 的 Set 是 String 类型的无序集合。集合成员是唯一的，这就意味着集合中不能出现重复的数据。

Redis 中集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是 O(1)。

集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。 

实例：
```bash
SADD runoobkey redis

SADD runoobkey mongodb

SADD runoobkey mysql

SADD runoobkey mysql

SMEMBERS runoobkey
```

向集合添加一个或多个成员
```bash
SADD key member1 [member2]
```
获取集合的成员数
```bash
SCARD key
```
返回给定所有集合的差集
```bash
SDIFF key1 [key2]
```
返回给定所有集合的差集并存储在 destination 中
```bash
SDIFFSTORE destination key1 [key2]
```
返回给定所有集合的交集
```bash
SINTER key1 [key2]
```
返回给定所有集合的交集并存储在 destination 中
```bash
SINTERSTORE destination key1 [key2]
```
判断 member 元素是否是集合 key 的成员
```bash
SISMEMBER key member
```
返回集合中的所有成员
```bash
SMEMBERS key
```
将 member 元素从 source 集合移动到 destination 集合
```bash
SMOVE source destination member
```
移除并返回集合中的一个随机元素
```bash
SPOP key
```
返回集合中一个或多个随机数
```bash
SRANDMEMBER key [count]
```
移除集合中一个或多个成员
```bash
SREM key member1 [member2]
```
返回所有给定集合的并集
```bash
	SUNION key1 [key2]
```
所有给定集合的并集存储在 destination 集合中
```bash
SUNIONSTORE destination key1 [key2]
```
迭代集合中的元素
```bash
	SSCAN key cursor [MATCH pattern] [COUNT count]
```













