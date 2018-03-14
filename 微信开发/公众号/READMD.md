# 开发事项

[官方文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1445241432)

## 微信网页授权

- 说明：
 1. 在微信公众号请求用户网页授权之前，开发者需要先到公众平台官网中的“开发 - 接口权限 - 网页服务 - 网页帐号 - 网页授权获取用户基本信息”的配置选项中，修改授权回调域名。请注意，这里填写的是域名（是一个字符串），而不是URL，因此请勿加 http:// 等协议头；
 
 2. 授权回调域名配置规范为全域名，比如需要网页授权的域名为：www.qq.com，配置以后此域名下面的页面http://www.qq.com/music.html 、 http://www.qq.com/login.html 都可以进行OAuth2.0鉴权。但http://pay.qq.com 、 http://music.qq.com 、 http://qq.com无法进行OAuth2.0鉴权
 
 3. 如果公众号登录授权给了第三方开发者来进行管理，则不必做任何设置，由第三方代替公众号实现网页授权即可

- 关于网页授权的两种scope的区别说明

1. 以snsapi_base为scope发起的网页授权，是用来获取进入页面的用户的openid的，并且是静默授权并自动跳转到回调页的。用户感知的就是直接进入了回调页（往往是业务页面）

2. 以snsapi_userinfo为scope发起的网页授权，是用来获取用户的基本信息的。但这种授权需要用户手动同意，并且由于用户同意过，所以无须关注，就可在授权后获取该用户的基本信息。

3. 用户管理类接口中的“获取用户基本信息接口”，是在用户和公众号产生消息交互或关注后事件推送后，才能根据用户OpenID来获取用户基本信息。这个接口，包括其他微信接口，都是需要该用户（即openid）关注了公众号后，才能调用成功的。

- 关于网页授权access_token和普通access_token的区别

1. 微信网页授权是通过OAuth2.0机制实现的，在用户授权给公众号后，公众号可以获取到一个网页授权特有的接口调用凭证（网页授权access_token），通过网页授权access_token可以进行授权后接口调用，如获取用户基本信息；

2. 其他微信接口，需要通过基础支持中的“获取access_token”接口来获取到的普通access_token调用。

3.  *简单的说：* 网页授权access_token是根据用户授权获得的用户access_token，在获取该用户的信息时（例如用户的头像等信息）用到。普通access_token是平台调用实现平台功能的，与用户无关

- 关于UnionID机制
1. 请注意，网页授权获取用户基本信息也遵循UnionID机制。即如果开发者有在多个公众号，或在公众号、移动应用之间统一用户帐号的需求，需要前往微信开放平台（open.weixin.qq.com）绑定公众号后，才可利用UnionID机制来满足上述需求。

2. UnionID机制的作用说明：如果开发者拥有多个移动应用、网站应用和公众帐号，可通过获取用户基本信息中的unionid来区分用户的唯一性，因为同一用户，对同一个微信开放平台下的不同应用（移动应用、网站应用和公众帐号），unionid是相同的。

- 具体而言，网页授权流程分为四步：

1. 引导用户进入授权页面同意授权，获取code

2. 通过code换取网页授权access_token（与基础支持中的access_token不同）

3. 如果需要，开发者可以刷新网页授权access_token，避免过期

4. 通过网页授权access_token和openid获取用户基本信息（支持UnionID机制）

[详细的实现看官方文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842)


## JSSDK开发
一、 概述：
- 微信JS-SDK是微信公众平台 面向网页开发者提供的基于微信内的网页开发工具包。

- 通过使用微信JS-SDK，网页开发者可借助微信高效地使用拍照、选图、语音、位置等手机系统的能力，同时可以直接使用微信分享、扫一扫、卡券、支付等微信特有的能力，为微信用户提供更优质的网页体验。

二、 使用步骤

1. 绑定域名
2. 引入JS文件
3. 通过config接口注入权限验证配置
4. 通过ready接口处理成功验证（注意这一步）
5. 通过error接口处理失败验证

[详细的实现看官方文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115)

三、 接口实现的功能实例

- Demo页面：http://demo.open.weixin.qq.com/jssdk

![image](http://mmbiz.qpic.cn/mmbiz/PiajxSqBRaEIQxibpLbyuSK39dMUJfWKTT3w5O5mich0nbKnpPnpl0QzuWuncBtibiaZQlmH1MGf3HoicWNIeaV4dXUg/0?wx_fmt=png)

- 示例代码：http://demo.open.weixin.qq.com/jssdk/sample.zip


四、 微信网页开发样式库
- 获取：https://github.com/Tencent/weui
![image](http://mmbiz.qpic.cn/mmbiz_png/PiajxSqBRaEIQxibpLbyuSKyjH0owTZq7HSO4rqonJU9dmPrribiadkZkFWKPciboaO4gHuV4AZnI3vIBovlZ6bhnUA/0?wx_fmt=png)
