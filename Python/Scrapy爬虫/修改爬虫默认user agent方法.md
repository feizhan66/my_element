方法一

settings文件
（大概19行）
修改USER_AGENT

方法二

修改setting中的
DEFAULT_REQUEST_HEADERS
加入：
'User-Agent': 'xxxxx'

方法三

```python
class HeadervalidationSpider(scrapy.Spider):
    name = 'headervalidation'
    allowed_domains = ['helloacm.com']


    def start_requests(self):
        header={'User-Agent':'Hello World'}
        yield scrapy.Request(url='http://helloacm.com/api/user-agent/',headers=header)

    def parse(self, response):
        print '*'*20
        print response.body
        print '*'*20
```

方法四
中间件自定义Header
customMiddleware.py
```python
#-*-coding=utf-8-*-
from scrapy.contrib.downloadermiddleware.useragent import UserAgentMiddleware

class CustomerUserAgent(UserAgentMiddleware):
    def process_request(self, request, spider):
        ua='HELLO World?????????'
        request.headers.setdefault('User-Agent',ua)
```

在setting中添加设置使中间件生效
```python
DOWNLOADER_MIDDLEWARES = {
    'headerchange.customerMiddleware.customMiddleware.CustomerUserAgent':10
#    'headerchange.middlewares.MyCustomDownloaderMiddleware': 543,
}
```

