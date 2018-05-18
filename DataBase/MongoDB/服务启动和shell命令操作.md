# 服务启动和shell命令操作

设置作为 Windows 服务启动

```
// 配置
mongod --dbpath "D:\mongodb\data\db"  --logpath "D:\mongodb\logs\mongodb.log" --install --serviceName "MongoDB"

// 启动
net start MongoDB
// 关闭
net stop MongoDB

```
















