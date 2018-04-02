import urllib.request
import re
import os

response = urllib.request.urlopen("http://tieba.baidu.com/p/3823765471")
# response.header('User-Agent','Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0')
html = response.read().decode("utf-8")
p = r'<img class="BDE_Image".*?src="([^"]*\.jpg)".*?>'
imglist = re.findall(p,html)
for each in imglist:
    print(each)
try:
    os.mkdir("imgfile")
except FileExistsError:
    # 如果改文件夹已存在则覆盖保存
    pass
os.chdir("imgfile")
for each in imglist:
    filename = each.split("/")[-1]
    urllib.request.urlretrieve(each,filename,None)#下载图片



