# 下载整个网页的文本，只是文本不能动态获取ajax的内容
import urllib.request
response = urllib.request.urlopen("http://www.feizhan.me/public")
html = response.read()
html = html.decode("utf-8")
print(html)















