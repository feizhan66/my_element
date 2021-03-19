# 字符串
设置指定 key 的值
```bash
SET key value
```
获取指定 key 的值。
```bash
GET key
```
返回 key 中字符串值的子字符
```bash
GETRANGE key start end
```
将给定 key 的值设为 value ，并返回 key 的旧值(old value)。
```bash
GETSET key value
```
对 key 所储存的字符串值，获取指定偏移量上的位(bit)。
```bash
GETBIT key offset
```
获取所有(一个或多个)给定 key 的值。 
```bash
MGET key1 [key2..]
```
对 key 所储存的字符串值，设置或清除指定偏移量上的位(bit)。
```bash
SETBIT key offset value
```
将值 value 关联到 key ，并将 key 的过期时间设为 seconds (以秒为单位)。
```bash
SETEX key seconds value
```
只有在 key 不存在时设置 key 的值。
```bash
SETNX key value
```
用 value 参数覆写给定 key 所储存的字符串值，从偏移量 offset 开始。 
```bash
SETRANGE key offset value
```
返回 key 所储存的字符串值的长度。
```bash
STRLEN key
```
同时设置一个或多个 key-value 对。
```bash
MSET key value [key value ...]
```
同时设置一个或多个 key-value 对，当且仅当所有给定 key 都不存在。
```bash
MSETNX key value [key value ...]
```
这个命令和 SETEX 命令相似，但它以毫秒为单位设置 key 的生存时间，而不是像 SETEX 命令那样，以秒为单位。
```bash
PSETEX key milliseconds value
```
将 key 中储存的数字值增一。
```bash
INCR key
```
将 key 所储存的值加上给定的增量值（increment） 。
```bash
INCRBY key increment
```
将 key 所储存的值加上给定的浮点增量值（increment） 。
```bash
INCRBYFLOAT key increment
```
将 key 中储存的数字值减一。
```bash
DECR key
```
key 所储存的值减去给定的减量值（decrement） 。
```bash
DECRBY key decrement
```
如果 key 已经存在并且是一个字符串， APPEND 命令将指定的 value 追加到该 key 原来值（value）的末尾。 
```bash
APPEND key value
```