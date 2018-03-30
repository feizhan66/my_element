# <a href="/public/index/blog/blog.html?article_id=149"><img class="media-object" src="http://oss.feizhan.me/Image/20170518/2017051814950896998B808830-6A24-66B6-0F1C-AE11CFC3312B.jpg" alt="..." width="60px" height="60px">

import urllib.request
import re
import os

response = urllib.request.urlopen("http://feizhan.me/public/index/blog/list_blog/user_id/2.html")
# response.header('User-Agent','Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0')
html = response.read().decode("utf-8")
# print(html)
p = r'<img class="media-object".*?src="([^"]*\.jpg)".*?>'
imglist = re.findall(p,html)
print(imglist)
for each in imglist:
    print(each)

try:
    os.mkdir("imgfile2")
except FileExistsError:
    # 如果改文件夹已存在则覆盖保存
    pass
os.chdir("imgfile2")
for each in imglist:
    filename = each.split("/")[-1]
    urllib.request.urlretrieve(each,filename,None)#下载图片







