# Redis键(key)
设置键，返回OK
```bash
set key value
```
删除键，返回0/1
```bash
del key
```
序列化key，返回序列化值
```bash
dump key
```
检查KEY是否存在
```bash
expire key
```
为给定KEY设置过期时间，以秒计
```bash
expire key seconds
```
EXPIREAT 的作用和 EXPIRE 类似，都用于为 key 设置过期时间。 不同在于 EXPIREAT 命令接受的时间参数是 UNIX 时间戳(unix timestamp)。
```bash
EXPIREAT key timestamp
```
设置 key 的过期时间以毫秒计。
```bash
PEXPIRE key milliseconds
```
设置 key 过期时间的时间戳(unix timestamp) 以毫秒计
```bash
PEXPIREAT key milliseconds-timestamp
```
查找所有符合给定模式( pattern)的 key 。 
```bash
KEYS pattern
```
将当前数据库的 key 移动到给定的数据库 db 当中。
```bash
MOVE key db
```
移除 key 的过期时间，key 将持久保持。
```bash
PERSIST key
```
以毫秒为单位返回 key 的剩余的过期时间。
```bash
PTTL key
```
以秒为单位，返回给定 key 的剩余生存时间(TTL, time to live)。
```bash
TTL key
```
从当前数据库中随机返回一个 key 。 
```bash
RANDOMKEY
```
修改 key 的名称
```bash
RENAME key newkey
```
仅当 newkey 不存在时，将 key 改名为 newkey 。
```bash
RENAMENX key newkey
```
返回 key 所储存的值的类型。
```bash
TYPE key
```