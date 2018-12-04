在redis的目录下执行（执行后就作为windows服务了）
```bash
redis-server --service-install redis.windows.conf
```
安装好后需要手动启动redis
```bash
redis-server --service-start
```
停止服务
```bash
redis-server --service-start
```
卸载redis服务
```bash
redis-server --service-uninstall
```

