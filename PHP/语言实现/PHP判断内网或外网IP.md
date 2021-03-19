## [php 内网/外网ip判断](https://www.cnblogs.com/zqifa/p/php-ip-1.html)

工作需要判断ip是否是内网ip，本来想着使用正则自己写一个呢，后来发现php自带的有现成的函数[filter_var()](http://php.net/manual/zh/function.filter-var.php) 。
除了ip验证外还有许多都可以验证，如url、email等等

验证ip是否是内网ip，如果是的话返回false，否则返回ip；

代码如下：

filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)

**内网ip**

A类：10.0.0.0-10.255.255.255

B类：172.16.0.0-172.31.255.255

C类：192.168.0.0-192.168.255.255

本机地址：127.0.0.1

**PHP FILTER_VALIDATE_IP 过滤器**

定义和用法
FILTER_VALIDATE_IP 过滤器把值作为 IP 进行验证。
Name: "validate_ip"
ID-number: 275
可能的标志：
FILTER_FLAG_IPV4 - 要求值是合法的 IPv4 IP（比如 255.255.255.255）
FILTER_FLAG_IPV6 - 要求值是合法的 IPv6 IP（比如 2001:0db8:85a3:08d3:1319:8a2e:0370:7334）
FILTER_FLAG_NO_PRIV_RANGE - 要求值是 RFC 指定的私域 IP （比如 192.168.0.1）
FILTER_FLAG_NO_RES_RANGE - 要求值不在保留的 IP 范围内。该标志接受 IPV4 和 IPV6 值。
