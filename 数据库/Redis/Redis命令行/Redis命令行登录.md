# 登录Redis客户端
```bash
redis-cli
```
在远程服务商执行命令
```bash
redis-cli -h host -p port -a password

redis-cli -h 127.0.0.1 -p 6379 -a "mypass"
```
有时候会有中文乱码。要在 redis-cli 后面加上 --raw
```bash
redis-cli --raw
```

# 返回所有键
```bash
keys *
```


# 以毫秒为单位返回 key 的剩余的过期时间。
返回值
当 key 不存在时，返回 -2 。 当 key 存在但没有设置剩余生存时间时，返回 -1 。 否则，以毫秒为单位，返回 key 的剩余生存时间。

注意：在 Redis 2.8 以前，当 key 不存在，或者 key 没有设置剩余生存时间时，命令都返回 -1 。
```angularjs
PTTL KEY_NAME
```

# 删除所有的KEY
```angularjs
FLUSHDB
```


