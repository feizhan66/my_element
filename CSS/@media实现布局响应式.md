
获取屏幕分辨率
```javascript
document.write("浏览器分辨率是"+document.documentElement.clientWidth+"*"+document.documentElement.clientHeight ); 

document.write("屏幕分辨率是"+window.screen.width+"*"+window.screen.height); 
```

1280分辨率以上（大于1200px）
```css
@media screen and (min-width:1200px){
    #page{ width: 1100px; }#content,.div1{width: 730px;}#secondary{width:310px}
}
```
1100分辨率（大于960px，小于1199px）
```css
@media screen and (min-width: 960px) and (max-width: 1199px) {
    #page{ width: 960px; }#content,.div1{width: 650px;}#secondary{width:250px}select{max-width:200px}
}
```
440分辨率以下（小于479px）
```css
@media only screen and (max-width: 479px) {
    #page{ width: 300px; }#content,.div1{width: 300px;}#secondary{display:none}#access{width: 330px;} #access a {padding-right:10px;padding-left:10px}#access a img{display:none}#rss{display:none}#branding #s{display:none}#access ul ul a{width:100px}
}
```


```css
@media screen and (max-width: 600px) { 
/*当屏幕尺寸小于600px时，应用下面的CSS样式*/
}
```


```javascript
@media only screen and 
only(限定某种设备)
screen 是媒体类型里的一种
and 被称为关键字，其他关键字还包括 not(排除某种设备)

/* 常用类型 */
类型 解释
all 所有设备
braille 盲文
embossed 盲文打印
handheld 手持设备
print 文档打印或打印预览模式
projection 项目演示，比如幻灯
screen 彩色电脑屏幕
speech 演讲
tty 固定字母间距的网格的媒体，比如电传打字机
tv 电视

screen一般用的比较多，下面是我自己的尝试，列出常用的设备的尺寸，然后给页面分了几个尺寸的版本。

/* 常用设备 */
设备 屏幕尺寸
显示器 1280 x 800
ipad 1024 x 768
Android 800 x 480
iPhone 640 x 960

两种方式
a<linkrel="stylesheet" type="text/css" href="styleB.css" media="screen and (min-width: 600px) and (max-width: 800px)">
意思是当屏幕的宽度大于600小于800时，应用styleB.css

b@media screen and (max-width: 600px) { /*当屏幕尺寸小于600px时，应用下面的CSS样式*/
  .class {
    background: #ccc;
  }
}
```
```css
device-aspect-ratio
device-aspect-ratio可以用来适配特定屏幕长宽比的设备，这也是一个很有用的属性，比如，我们的页面想要对长宽比为4:3的普通屏幕定义一种样式，然后对于16:9和16:10的宽屏，定义另一种样式，比如自适应宽度和固定宽度：

@media only screen and (device-aspect-ratio:4/3)

-webkit-min-device-pixel-ratio的常见值对比（是设备上物理像素和设备独立像素，设备像素比率）
```





















