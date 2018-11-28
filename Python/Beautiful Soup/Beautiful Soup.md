# 安装 Beautiful Soup

- 如果你用的是新版的Debain或ubuntu,那么可以通过系统的软件包管理来安装:
```
$ apt-get install Python-bs4
```
- Beautiful Soup 4 通过PyPi发布,所以如果你无法使用系统包管理安装,那么也可以通过 easy_install 或 pip 来安装.包的名字是 beautifulsoup4 ,这个包兼容Python2和Python3.
```
$ easy_install beautifulsoup4

$ pip install beautifulsoup4
```
- (在PyPi中还有一个名字是 BeautifulSoup 的包,但那可能不是你想要的,那是 Beautiful Soup3 的发布版本,因为很多项目还在使用BS3, 所以 BeautifulSoup 包依然有效.但是如果你在编写新项目,那么你应该安装的 beautifulsoup4 )

- 如果你没有安装 easy_install 或 pip ,那你也可以 下载BS4的源码 ,然后通过setup.py来安装.
```
$ Python setup.py install
```
- 如果上述安装方法都行不通,Beautiful Soup的发布协议允许你将BS4的代码打包在你的项目中,这样无须安装即可使用.

- 作者在Python2.7和Python3.2的版本下开发Beautiful Soup, 理论上Beautiful Soup应该在所有当前的Python版本中正常工作



# 安装解析器

- Beautiful Soup支持Python标准库中的HTML解析器,还支持一些第三方的解析器,其中一个是 lxml 根据操作系统不同,可以选择下列方法来安装lxml:

```
$ apt-get install Python-lxml

$ easy_install lxml

$ pip install lxml
```
- 另一个可供选择的解析器是纯Python实现的 html5lib , html5lib的解析方式与浏览器相同,可以选择下列方法来安装html5lib:
```
$ apt-get install Python-html5lib

$ easy_install html5lib

$ pip install html5lib
```

解析器 | 使用方法 | 优势 | 劣势
--- | --- | --- | ---
Python标准库 | BeautifulSoup(markup, "html.parser") | Python的内置标准库、执行速度适中、文档容错能力强 | Python 2.7.3 or 3.2.2)前 的版本中文档容错能力差
lxml HTML 解析器 | BeautifulSoup(markup, "lxml") | 速度快、文档容错能力强 | 需要安装C语言库
lxml XML 解析器 | BeautifulSoup(markup, ["lxml", "xml"]) 、 BeautifulSoup(markup, "xml") | 速度快、唯一支持XML的解析器 | 需要安装C语言库
html5lib | BeautifulSoup(markup, "html5lib") | 最好的容错性、以浏览器的方式解析文档、生成HTML5格式的文档 | 速度慢、不依赖外部扩展





