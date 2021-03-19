# 签名


### 注意：为了参数可能的弄混和冲突，与签名有关的参数统一以"sign_"开始

公Key：sign_public_token

私Key：sign_private_token

签名的值：sign_value


##### 非登陆状态签名

```
一、 签名参数

1.请求参数params
2.请求时间戳[单位秒](sign_request_time) 
3.公Token(sign_public_token)
4.Api版本号(sign_api_versions)
5.平台类型(sign_platform_type)
6.设备号[全局唯一](sign_equipment_sn)

二、 签名方法

1.对所有签名参数根据参数名进行【字典排序】

2.把参数以键值对的形式组合字符串中间以&链接
(例：...&sign_public_token=toekn&sign_api_versions=1.0.0)

3.参数转码后字符串的MD5值为sign_value

三、 每次请求都带上sign_value


```
##### 登录状态签名

```
一、 获取sign_private_token
1.用户输入账号密码进行登录，在返回用户信息同时返回sign_private_token和sign_time

二、 签名参数
1.请求参数params
2.请求时间戳[单位为秒](sign_request_time)
3.公Token(sign_public_token)
4.Api版本号(sign_api_versions)
5.平台类型(sign_platform_type)
6.设备号[全局唯一](sign_equipment_sn)
7.私Token(sign_private_token)

---下面的流程跟非登录态签名一样

```

##### 目前登录态与非登录态的判定
```
1. 首先确认的是需要传user_tid的接口都是需要用户登录态
2. 之后再约定其他...
```

##### 注意点：
```
1.sign_private_token的有效时间默认是一周
2.只要正常访问了需登录状态的Api就会更新sign_private_token有效时间
3.可Api主动查询和交换sign_private_token信息
4.在测试阶段，为了保证未签名的App能正常调用接口，所以默认不对参数执行签名。要使用签名测试的话就多传一个参数(need_sign=1)就会执行签名
5.文件上传的file字段和file[]不要作为参数放进去签名（由于POST不能拿到上传的文件信息）
```











