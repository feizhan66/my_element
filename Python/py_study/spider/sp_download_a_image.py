# 下载并保存一张图片
import urllib.request

resp = urllib.request.urlopen("http://oss.feizhan.me/Image/20170404/2017040410237149130722319698.jpeg")
img = resp.read()
with open('head.jpg','wb') as f:
    f.write(img)














