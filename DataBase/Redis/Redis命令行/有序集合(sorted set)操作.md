# Redis 有序集合(sorted set)

 Redis 有序集合和集合一样也是string类型元素的集合,且不允许重复的成员。

不同的是每个元素都会关联一个double类型的分数。redis正是通过分数来为集合中的成员进行从小到大的排序。

有序集合的成员是唯一的,但分数(score)却可以重复。

集合是通过哈希表实现的，所以添加，删除，查找的复杂度都是O(1)。 集合中最大的成员数为 232 - 1 (4294967295, 每个集合可存储40多亿个成员)。 


实例：
实例中我们通过命令 ZADD 向 redis 的有序集合中添加了三个值并关联上分数。
```bash
ZADD runoobkey 1 redis

ZADD runoobkey 2 mongodb

ZADD runoobkey 3 mysql

ZADD runoobkey 3 mysql

ZADD runoobkey 4 mysql

ZRANGE runoobkey 0 10 WITHSCORES

1) "redis"
2) "1"
3) "mongodb"
4) "2"
5) "mysql"
6) "4"
```

向有序集合添加一个或多个成员，或者更新已存在成员的分数
```bash
ZADD key score1 member1 [score2 member2]
```
获取有序集合的成员数
```bash
ZCOUNT key min max
```
有序集合中对指定成员的分数加上增量 increment
```bash
ZINCRBY key increment member
```
计算给定的一个或多个有序集的交集并将结果集存储在新的有序集合 key 中
```bash
ZINTERSTORE destination numkeys key [key ...]
```
在有序集合中计算指定字典区间内成员数量
```bash
ZLEXCOUNT key min max
```
通过索引区间返回有序集合成指定区间内的成员
```bash
ZRANGE key start stop [WITHSCORES]
```
通过字典区间返回有序集合的成员
```bash
ZRANGEBYLEX key min max [LIMIT offset count]
```
通过分数返回有序集合指定区间内的成员
```bash
ZRANGEBYSCORE key min max [WITHSCORES] [LIMIT]
```
返回有序集合中指定成员的索引
```bash
ZRANK key member
```
移除有序集合中的一个或多个成员
```bash
ZREM key member [member ...]
```
移除有序集合中给定的字典区间的所有成员
```bash
ZREMRANGEBYLEX key min max
```
移除有序集合中给定的排名区间的所有成员
```bash
ZREMRANGEBYRANK key start stop
```
移除有序集合中给定的分数区间的所有成员
```bash
ZREMRANGEBYSCORE key min max
```
返回有序集中指定区间内的成员，通过索引，分数从高到底
```bash
ZREVRANGE key start stop [WITHSCORES]
```
返回有序集中指定分数区间内的成员，分数从高到低排序
```bash
ZREVRANGEBYSCORE key max min [WITHSCORES]
```
返回有序集合中指定成员的排名，有序集成员按分数值递减(从大到小)排序
```bash
ZREVRANK key member
```
返回有序集中，成员的分数值
```bash
ZSCORE key member
```
计算给定的一个或多个有序集的并集，并存储在新的 key 中
```bash
ZUNIONSTORE destination numkeys key [key ...]
```
迭代有序集合中的元素（包括元素成员和元素分值）
```bash
ZSCAN key cursor [MATCH pattern] [COUNT count]
```









