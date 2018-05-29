
#### 方法四、利用不对称加密和对称加密（类似HTTPS）
1. 不对称加密消耗资源多，速度慢，但是安全
2. 对称加密速度快，速度快，但是要保证两端拿到的key是一样且传输过程中不被截取

```
sequenceDiagram
客户端->>服务器: 请求公钥
服务器->>客户端: 收到请求，返回公钥
客户端->>客户端: 收到公钥,生成随机唯一KEY（guid）
客户端->>服务器: 把KEY用公钥加密，发送给服务器
服务器->>客户端: 接收到加密过后的KEY，用私钥解密。保存数据库，返回sign_id和create_time
客户端->>客户端: 本地存储sign_id，create_time，key
客户端->>服务器: 发送api请求，参数带上sign_id和nowtime，再用key进行md5加密得到密文
服务器->>服务器: 通过sign_id获取key，再进行md5比对，正确就执行处理
服务器->>客户端: 在返回的过程中加上密文，客户端同样方法校验
```


- 获取：
1. 在打开APP的时候首先请求，执行获取key操作
2. 保存sign_id，create_time，key，（选填：公钥）

- 过期：
1. 前后端约定好半个钟过期，（客户端保存有key，sign_id，create_time）
2. 在客户端要请求api时首先判断create_time和now_time是否超过有效期
3. 超过就重新获取，没超过就加密获取

- 实现：
1. 不对称加密的公钥/私钥对目前有两个：一个是https的一个是微信的。
2. 个人认为如果能获取到https的公钥执行操作就最为简单（==*==）

- 说明：以上是HTTPS的实现原理


### 加密与登录结合

1. 在申请秘钥时注意：首次申请和更新申请
2. 首次申请就是上面完整的流程
3. 更新申请的话可以省去请求公钥这一步（前提是客户端缓存了公钥）
4. 更新申请除了需要把guid加密之外还需要传之前的appid（识别用户作用）
5. 注意的是KEY的有效时间是半个钟，用户的登录有效时间是一星期，但是每次更新KEY也会同步更新用户登录有效时间。也就是如果用户一直用着，用户的有效时间是无限的，如果超过一周没上的话将会变成非登录状态
6. 好处：一些API可以后台验证登录态才放行







---

### 参考资料 Oauth2.0（微信认证使用）


```
sequenceDiagram
Client->>Resource Owner: 用户打开客户端以后，客户端要求用户给予授权。
Resource Owner->>Client: 用户同意给予客户端授权。-->相当于微信的授权code

Client->>Authorization Grant: 客户端使用上一步获得的授权，向认证服务器申请令牌。-->相当于根据code再次拉取信息
Authorization Grant->>Client: 认证服务器对客户端进行认证以后，确认无误，同意发放令牌。

Client->>Resource Servrt: 客户端使用令牌，向资源服务器申请获取资源。-->根据用户信息获取其他的操作
Resource Servrt->>Client: 资源服务器确认令牌无误，同意向客户端开放资源。
```


### 客户端的授权模式
1. 授权码模式（authorization code）
2. 简化模式（implicit）
3. 密码模式（resource owner password credentials）
4. 客户端模式（client credentials）


[参考链接](http://www.ruanyifeng.com/blog/2014/05/oauth_2_0.html)
