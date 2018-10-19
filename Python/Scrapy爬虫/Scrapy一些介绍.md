# Document

## 周期

- 首先生成初始请求被爬取网站的第一个URL，并制定要使用这些请求下载的响应调用的回调函数。第一个执行请求是通过调用start_requests()【默认情况下】为请求中作为回调函数的方法中 Request 制定的URL start_urls 和 parse 方法生成的方法获得
- 在回调函数中，解析响应网页并返回带有提取的数据， Item对象， Request对象或这些对象的可迭代的dicts。这些请求还将包含一个回调，然后由Scrapy下载，然后由制定的回调处理他们的响应
- 在回调函数中，通常使用选择器解析页面的内容（也可以用BeautifulSoup等）并使用解析的数据生成项目
- 最后，蜘蛛返回的项目通常会持久保存到数据库（在某些项目管道中）或使用Feed导出写入文件


## Scrapy终端

Scrapy终端是一个交互终端，供您在未启动spider的情况下尝试及调试您的爬取代码。 其本意是用来测试提取数据的代码，不过您可以将其作为正常的Python终端，在上面测试任何的Python代码。

该终端是用来测试XPath或CSS表达式，查看他们的工作方式及从爬取的网页中提取的数据。 在编写您的spider时，该终端提供了交互性测试您的表达式代码的功能，免去了每次修改后运行spider的麻烦。

- 启动终端
```
scrapy shell <url>
```
```
scrapy shell 'http://scrapy.org' --nolog

sel.xpath("//h2/text()").extract()[0] # 获取字段值
```

- 在spider中启动shell来查看response
```
scrapy.shell.inspect_response
```
- 查看【在shell中】
```
view(response)
```

## Item Pipeline

当Item在Spider中被收集之后，它将会被传递到Item Pipeline，一些组件会按照一定的顺序执行对Item的处理。

每个item pipeline组件(有时称之为“Item Pipeline”)是实现了简单方法的Python类。他们接收到Item并通过它执行一些行为，同时也决定此Item是否继续通过pipeline，或是被丢弃而不再进行处理。

以下是item pipeline的一些典型应用：

- 清理HTML数据
- 验证爬取的数据(检查item包含某些字段)
- 查重(并丢弃)
- 将爬取结果保存到数据库中


## Feed exports
实现爬虫时最经常提到的需求就是能合适的保存爬取到的数据，或者说，生成一个带有爬取数据的”输出文件”(通常叫做”输出feed”)，来供其他系统使用。

Scrapy自带了Feed输出，并且支持多种序列化格式(serialization format)及存储方式(storage backends)。

### 序列化方式(Serialization formats)：
feed输出使用到了 Item exporters 。其自带支持的类型有:

- JSON
- JSON lines
- CSV
- XML
您也可以通过 FEED_EXPORTERS 设置扩展支持的属性。

### 存储(Storages)
使用feed输出时您可以通过使用 URI (通过 FEED_URI 设置) 来定义存储端。 feed输出支持URI方式支持的多种存储后端类型。

自带支持的存储后端有:

本地文件系统
- FTP
- S3 (需要 boto)
- 标准输出
有些存储后端会因所需的外部库未安装而不可用。例如，S3只有在 boto 库安装的情况下才可使用。

### 存储URI参数
存储URI也包含参数。当feed被创建时这些参数可以被覆盖:

%(time)s - 当feed被创建时被timestamp覆盖
%(name)s - 被spider的名字覆盖
其他命名的参数会被spider同名的属性所覆盖。例如， 当feed被创建时， %(site_id)s 将会被 spider.site_id 属性所覆盖。

下面用一些例子来说明:

存储在FTP，每个spider一个目录:
ftp://user:password@ftp.example.com/scraping/feeds/%(name)s/%(time)s.json
存储在S3，每一个spider一个目录:
s3://mybucket/scraping/feeds/%(name)s/%(time)s.json


## Logging
Scrapy提供了log功能。您可以通过 scrapy.log 模块使用。当前底层实现使用了 Twisted logging ，不过可能在之后会有所变化。

log服务必须通过显示调用 scrapy.log.start() 来开启。

### Log levels

Scrapy提供5层logging级别:

CRITICAL - 严重错误(critical)
ERROR - 一般错误(regular errors)
WARNING - 警告信息(warning messages)
INFO - 一般信息(informational messages)
DEBUG - 调试信息(debugging messages)

### 如何记录信息(log messages)
下面给出如何使用 WARNING 级别来记录信息的例子:

```
from scrapy import log
log.msg("This is a warning", level=log.WARNING)
```

## 数据收集(Stats Collection)
Scrapy提供了方便的收集数据的机制。数据以key/value方式存储，值大多是计数值。 该机制叫做数据收集器(Stats Collector)，可以通过 Crawler API 的属性 stats 来使用。在下面的章节 常见数据收集器使用方法 将给出例子来说明。

无论数据收集(stats collection)开启或者关闭，数据收集器永远都是可用的。 因此您可以import进自己的模块并使用其API(增加值或者设置新的状态键(stat keys))。 该做法是为了简化数据收集的方法: 您不应该使用超过一行代码来收集您的spider，Scrpay扩展或任何您使用数据收集器代码里头的状态。

数据收集器的另一个特性是(在启用状态下)很高效，(在关闭情况下)非常高效(几乎察觉不到)。

数据收集器对每个spider保持一个状态表。当spider启动时，该表自动打开，当spider关闭时，自动关闭。

### 常见数据收集器使用方法
通过 stats 属性来使用数据收集器。 下面是在扩展中使用状态的例子:
```
class ExtensionThatAccessStats(object):

    def __init__(self, stats):
        self.stats = stats

    @classmethod
    def from_crawler(cls, crawler):
        return cls(crawler.stats)
```

## 发送email
虽然Python通过 smtplib 库使得发送email变得很简单，Scrapy仍然提供了自己的实现。 该功能十分易用，同时由于采用了 Twisted非阻塞式(non-blocking)IO ，其避免了对爬虫的非阻塞式IO的影响。 另外，其也提供了简单的API来发送附件。 通过一些 settings 设置，您可以很简单的进行配置。

有两种方法可以创建邮件发送器(mail sender)。 您可以通过标准构造器(constructor)创建:
```
from scrapy.mail import MailSender
mailer = MailSender()
```

## Telnet终端(Telnet Console)
Scrapy提供了内置的telnet终端，以供检查，控制Scrapy运行的进程。 telnet仅仅是一个运行在Scrapy进程中的普通python终端。因此您可以在其中做任何事。

### 如何访问telnet终端
telnet终端监听设置中定义的 TELNETCONSOLE_PORT ，默认为 6023 。 访问telnet请输入:
```
telnet localhost 6023
```

## Web Service
Scrapy提供用于监控及控制运行中的爬虫的web服务(service)。 服务通过 JSON-RPC 2.0 协议提供大部分的资源，不过也有些(只读)资源仅仅输出JSON数据。

Scrapy为管理Scrapy进程提供了一个可扩展的web服务。 您可以通过 WEBSERVICE_ENABLED 来启用服务。 服务将会监听 WEBSERVICE_PORT 的端口，并将记录写入到 WEBSERVICE_LOGFILE 指定的文件中。

web服务是默认启用的 内置Scrapy扩展 ， 不过如果您运行的环境内存紧张的话，也可以关闭该扩展。


## Scrapy是以广度优先还是深度优先进行爬取的呢？

默认情况下，Scrapy使用 LIFO 队列来存储等待的请求。简单的说，就是 深度优先顺序 。深度优先对大多数情况下是更方便的。如果您想以 广度优先顺序 进行爬取，你可以设置以下的设定:
```
DEPTH_PRIORITY = 1
SCHEDULER_DISK_QUEUE = 'scrapy.squeue.PickleFifoDiskQueue'
SCHEDULER_MEMORY_QUEUE = 'scrapy.squeue.FifoMemoryQueue'
```

## reponse返回的状态值999代表了什么?
999是雅虎用来控制请求量所定义的返回值。 试着减慢爬取速度，将spider的下载延迟改为 2 或更高:
```
class MySpider(CrawlSpider):

    name = 'myspider'

    download_delay = 2

    # [ ... rest of the spider code ... ]
```

## 将所有爬取到的item转存(dump)到JSON/CSV/XML文件的最简单的方法?

dump到JSON文件:

scrapy crawl myspider -o items.json

dump到CSV文件:

scrapy crawl myspider -o items.csv

dump到XML文件:

scrapy crawl myspider -o items.xml

更多详情请参考 Feed exports


## 如何才能看到Scrapy发出及接收到的Scrapy呢？
启用 COOKIES_DEBUG 选项。

## 要怎么停止爬虫呢?
在回调函数中raise CloseSpider 异常。 更多详情请参见: CloseSpider 。


## 调试(Debugging)Spiders
简单地说，该spider分析了两个包含item的页面(start_urls)。Item有详情页面， 所以我们使用 Request 的 meta 功能来传递已经部分获取的item。
```
import scrapy
from myproject.items import MyItem

class MySpider(scrapy.Spider):
    name = 'myspider'
    start_urls = (
        'http://example.com/page1',
        'http://example.com/page2',
        )

    def parse(self, response):
        # collect `item_urls`
        for item_url in item_urls:
            yield scrapy.Request(item_url, self.parse_item)

    def parse_item(self, response):
        item = MyItem()
        # populate `item` fields
        # and extract item_details_url
        yield scrapy.Request(item_details_url, self.parse_details, meta={'item': item})

    def parse_details(self, response):
        item = response.meta['item']
        # populate more `item` fields
        return item
```

!link()[https://scrapy-chs.readthedocs.io/zh_CN/0.24/_images/scrapy_architecture.png]















































