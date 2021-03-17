
# 宽度
```css
div{
    /*width: 200px;*/
    /*width: 100%;*/
    /*width: 20em;*/
    /*min-width: 200px;*/
    /*max-width: 100px;*/
}
```

# 高度
```css
div{
    height: auto;/*高度自动，内容增多而增高，高度自适应不用设置*/
    height: 50px;
    height: 50em;
    min-height: 100px;
    max-height: 100px;
}
```

# 边框 border
CSS 边框即CSS border是控制对象的边框边线宽度、颜色、虚线、实线等样式CSS属性
```css
div{
    border: 1px solid black;
    border-top: 1px solid yellow;
    border-bottom: 1px;
    border-left: yellow;
    border-right: yellow;
    
    /*边框颜色*/
    border-color:#000;
    /*边框厚度*/
    border-width:1px;
    /*边框样式*/
    /*主流：solid实线边框 dashed虚线边框*/
    border-style:solid
}
```
```css
边框样式值如下：
none : 　无边框。与任何指定的border-width值无关
hidden : 　隐藏边框。IE不支持
dotted : 　在MAC平台上IE4+与WINDOWS和UNIX平台上IE5.5+为点线。否则为实线（常用）
dashed : 　在MAC平台上IE4+与WINDOWS和UNIX平台上IE5.5+为虚线。否则为实线（常用）
solid : 　实线边框（常用）
double : 　双线边框。两条单线与其间隔的和等于指定的border-width值
groove : 　根据border-color的值画3D凹槽
ridge : 　根据border-color的值画菱形边框
inset : 　根据border-color的值画3D凹边
outset : 　根据border-color的值画3D凸边
```

# 背景 background
```css
div{
    background CSS手册查询-background手册
    background-color 设置颜色作为对象背景颜色
    background-image 设置图片作为背景图片
    background-repeat 设置背景平铺重复方向
    background-attachment 设置或检索背景图像是随对象内容滚动还是固定的。
    background-position 设置或检索对象的背景图像位置。
}
```
Background背景样式的值是复合属性值组合，也就是背景单词的值可以跟多个属性值，值与值之间使用一个空格间隔链接上即可。
如：
```css
background:1.#000 2.url(图片地址) 3.no-repeat 4.left 5.top 6.fixed

1.设置背景颜色值
2.设置背景图片具体路径
3.设置图片是否平铺方式
- no-repeat 不重复
- repeat-x X方向(横向)重复平铺
- repeat-y Y方向(纵向)重复平铺
- 如不设置为全背景平铺
4. 距离左多少像素
5.距离右多少像素
6.背景图片固定还是随上下滚动条流动
```

# 图像拼合(取其中的一部分) sprites
css sprites直译过来就是CSS精灵。通常被解释为“CSS图像拼合”或“CSS贴图定位”。其实就是通过将多个图片融合到一张图里面，然后通过CSS background背景定位技术技巧布局网页背景。这样做的好处也是显而易见的，因为图片多的话，会增加http的请求，无疑促使了网站性能的减低，特别是图片特别多的网站，如果能用css sprites降低图片数量，带来的将是速度的提升。

css sprites是什么通俗解释：CSS Sprites其实就是把网页中一些背景图片整合拼合成一张图片中，再利用DIV CSS的“background-image”，“background- repeat”，“background-position”的组合进行背景定位，background-position可以用数字能精确的定位出背景图片在布局盒子对象位置。

具体操作：
http://www.divcss5.com/rumen/r767.shtml


# 浮动 float
```css
Float常跟属性值left、right、none
Float:none 不使用浮动
Float:left 靠左浮动
Float:right 靠右浮动

float语法：
float : none | left |right

参数值：
none : 　对象不浮动
left : 　对象浮在左边
right : 　对象浮在右边
```

我们要区别与文字内容靠左( text-align:left)靠右( text-align:right)样式，浮动只针对html标签设置靠左靠右浮动样式。float浮动样式没有靠中（浮动居中）的样式，如果需要让标签对象居中我们在css布局居中相关文字给大家详细讲解介绍（css margin）。这里记住浮动靠右使用float:right，浮动靠左使用float:left样式即可。

```haml
    <div class="divcss5"> 
        <div class="divcss5_left">布局靠左浮动</div> 
        <div class="divcss5_right">布局靠右浮动</div> 
        <div class="clear"></div><!-- html注释：清除float产生浮动 --> 
    </div> 
    .divcss5{ width:400px;padding:10px;border:1px solid #F00} 
    .divcss5_left{ float:left;width:150px;border:1px solid #00F;height:50px} 
    .divcss5_right{ float:right;width:150px;border:1px solid #00F;height:50px} 
    .clear{ clear:both}
```

# 外边距/外间距 margin

margin是设置对象外边距外延边距离。
margin的值有三种情况，可以为正整数和负整数并加单位如PX像素（margin-left:20px）；可以为auto自动属性(margin-left:auto 自动)；可以为百分比（%）值（margin-left:3%）。

Margin延伸（单独设置四边间距属性单词）
margin-left 对象左边外延边距 （margin-left:5px; 左边外延距离5px）
margin-right 对象右边外延边距 （margin-right:5px; 右边外延距离5px）
margin-top 对象上边外延边距 （margin-top:5px; 上边外延距离5px）
margin-bottom 对象下边外延边距 （margin-bottom:5px; 下边外延距离5px）

# 内边距 padding

padding : +数值+单位 或 百分比数值

第一个40px代表“上”padding-top:40px;
第二个30px代表“右”padding-right:30px;
第三个50px代表“下”padding-bottom:50px;
第四个20px代表“左”padding-left:20px;

# 字体颜色 color
```html
<span color="yellow">黄色</span>

div{
    color: yellow;
}

```

# 超链接
首先我们认识下CSS 超链接基础
a:active是超级链接的初始状态
a:hover是把鼠标放上去时的状况
a:link是鼠标点击时
a:visited是访问过后的情况
这几个CSS样式一般情况下是默认的。


# 字体文字大小 font-size

```html

.divcss5{font-size:12px;}
设置了文字大小为12px像素
Font-size+字体大小数值+单位

单词：font-size
语法：font-size : absolute-size | relative-size | length
取值：xx-small | x-small | small | medium | large | x-large | xx-large
xx-small:最小
x-small:较小
small:小
medium:正常(默认值)，根据字体进行调整
large:大
x-large:较大
xx-large:最大
也可取具体长度单位值


font-size:12px; 设置对象具体字体大小为12px
font-size:xx-small; 设置文字大小为最小
font-size:small; 设置文字字体大小为小
font-size:x-large;设置对象字体大小为较大
font-size:larger;设置对象字体大小为大
font-size:smaller;相对于父容器中字体尺寸进行相对减小
font-size:50%;相对于父容器中字体尺寸进行相应调整为50%大小
font-size:150%;相对于父容器中字体尺寸进行相应调整为150%大小
```

# 字体 font-family
CSS 字体常见我们使用“黑体”、“宋体”此2种中文字体，这是为什么呢，因为网页载入选择字体时候是调用访问者系统文字库的文字字体，如果没有找到字体那将显示默认的网页字体。而每个人安装的操作系统(XP\VISTA\WIN7等系统)默认包括此几种中文字体。这样我们要使用每个人操作系统自带都有的字体作为网页字体，所以不能设置我们单独安装的文字字体。如果我们设置自己单独安装的字体，在自己电脑上会实现设置字体样式，而到其它用户浏览此网页时候此网页内文字字体会大变样。

宋体、黑体、微软雅黑、Arial, Helvetica, sans-serif此4种字体。
```html
.divcss5{ font-family:"黑体";}
```

# 加粗 font-weight

```html
CSS 加粗这里指的是通过DIV CSS控制对象的加粗。
使用CSS属性单词
font-weight
对象值：从100到900，最常用font-weight的值为bold

font-weight参数：

normal : 正常的字体。相当于number为400。声明此值将取消之前任何设置
bold : 粗体。相当于number为700。也相当于b对象的作用
bolder : IE5+　特粗体
lighter : IE5+　细体
number : IE5+　100 | 200 | 300 | 400 | 500 | 600 | 700 | 800 | 900

以前html直接对对象加粗的标签如下：
<b></b>或<strong></strong>两者效果相同。

```

# display 

常用display
1、div{display:block} 有换行作用。
案例：图片做背景，隐藏图片上文字http://www.divcss5.com/jiqiao/j55.shtml

2、div{display:None } 隐藏对象及对象内容。
案例：CSS隐藏HTML内容 http://www.divcss5.com/jiqiao/j55.shtml

3、div{display:Inline } 在一排显示。
代表案例，对li列表默认一排显示li{display:Inline }
```html
.divcss5{display:none}
```
```html
display参数

block :块对象的默认值。用该值为对象之后添加新行
none :隐藏对象。与visibility属性的hidden值不同，其不为被隐藏的对象保留其物理空间
inline :内联对象的默认值。用该值将从对象中删除行
compact :分配对象为块对象或基于内容之上的内联对象
marker :指定内容在容器对象之前或之后。要使用此参数，对象必须和:after及:before 伪元素一起使用
inline-table :将表格显示为无前后换行的内联对象或内联容器
list-item :将块对象指定为列表项目。并可以添加可选项目标志
run-in :分配对象为块对象或基于内容之上的内联对象
table :将对象作为块元素级的表格显示
table-caption :将对象作为表格标题显示
table-cell :将对象作为表格单元格显示
table-column :将对象作为表格列显示
table-column-group :将对象作为表格列组显示
table-header-group :将对象作为表格标题组显示
table-footer-group :将对象作为表格脚注组显示
table-row :将对象作为表格行显示
table-row-group :将对象作为表格行组显示

```

# 显示和隐藏滚动条 overflow

Overflow可以实现隐藏超出对象内容，同时也有显示与隐藏滚动条的作用

```html
overflow : visible | auto | hidden | scroll

visible : 　不剪切内容也不添加滚动条。假如显式声明此默认值，对象将被剪切为包含对象的window或frame的大小。并且clip属性设置将失效
auto : 　此为body对象和textarea的默认值。在需要时剪切内容并添加滚动条，DIV默认情况也是这个值，但需要设置时候设置即可
hidden : 　不显示超过对象尺寸的内容
scroll : 　总是显示滚动条

```

# 绝对定位 position

position : static absolute relative 

```html
position参数：
static : 　无特殊定位，对象遵循HTML定位规则
absolute : 　将对象从文档流中拖出，使用left，right，top，bottom等属性进行绝对定位。而其层叠通过css z-index属性定义。此时对象不具有边距，但仍有补白和边框
relative : 　对象不可层叠，但将依据left，right，top，bottom等属性在正常文档流中偏移位置
```

position说明：
设置对象的定位方式，可以让布局层容易位置绝对定位，控制盒子对象更加准确。

绝对定位与float浮动不能同时使用，比如一个大盒子里有的是绝对定位，有的是使用css float浮动定位，这样IE6浏览器将不会显示改大对象里的这些绝对定位与相对定位，这也算是IE6 CSS HACK吧，注意不要混用即可。

CSS基础必学列表

    CSS width宽度
    CSS height高度
    CSS border边框
    CSS background背景
    CSS sprites背景拼合
    CSS float浮动
    CSS margin外边距
    CSS padding内边距
    CSS color字体颜色
    CSS font-size字体大小
    CSS font-family字体
    CSS font-weight字体加粗
    CSS display显示与隐藏
    CSS overflow隐藏与滚动条
    CSS position定位
    CSS text-align内容水平位置
    CSS text-indent缩进
    CSS text-decoration下划线
    CSS clear清除浮动
    CSS cursor鼠标手势光标
    CSS font文本
    CSS font-style文本斜体
    CSS font-variant缩小大写字母
    CSS id CSS class
    left right top bottom
    css letter-spacing字间距
    CSS line-height行高
    css min-width最小宽度
    css max-width最大宽度
    CSS min-height最小高度
    css max-height最大高度
    CSS text-transform英文大小写
    css text-overflow省略号
    CSS white-space不换行
    css z-index重叠顺序
    CSS 前花括号星号*
    CSS 缩写
    div与span区别及用法
    CSS是什么
    DIV+CSS是什么
    CSS 注释
    CSS 指针
    CSS 文本排版

CSS position绝对定位absolute relative

DIV CSS position绝对定位absolute relative教程篇

常常使用position用于层的绝对定位，比如我们让一个层位于一个层内具体什么位置，为即可使用position:absolute和position:relative实现。
一、position语法与结构   -   TOP

position语法：
position : static absolute relative

position参数：
static : 　无特殊定位，对象遵循HTML定位规则
absolute : 　将对象从文档流中拖出，使用left，right，top，bottom等属性进行绝对定位。而其层叠通过css z-index属性定义。此时对象不具有边距，但仍有补白和边框
relative : 　对象不可层叠，但将依据left，right，top，bottom等属性在正常文档流中偏移位置

position说明：
设置对象的定位方式，可以让布局层容易位置绝对定位，控制盒子对象更加准确。
二、position实际用处   -   TOP

绝对定位position用于定位盒子对象，有时一个布局中几个小对象，不易用css padding、css margin进行相对定位，这个时候我们就可以使用绝对定位来轻松搞定。特别是一个盒子里几个小盒子不规律的布局，这个时候我们使用position绝对定位非常方便布局对象。

position绝对定位示范图
绝对定位position示范适用图、不规律布局，为即可利用position:absolute；position:relative进行绝对定位

绝对定位与float浮动不能同时使用，比如一个大盒子里有的是绝对定位，有的是使用css float浮动定位，这样IE6浏览器将不会显示改大对象里的这些绝对定位与相对定位，这也算是IE6 CSS HACK吧，注意不要混用即可。
三、绝对定位使用条件   -   TOP

position:absolute；position:relative绝对定位使用通常是父级定义position:relative定位，子级定义position:absolute绝对定位属性，并且子级使用left或right和top或bottom进行绝对定位。

.divcss5{position:relative} 定义，通常最好再定义CSS宽度和CSS高度
.divcss5-a{position:absolute;left:10px;top:10px} 这里定义了距离父级左侧距离间距为10px，距离父级上边距离为10px
或
.divcss5-a{position:absolute;right:10px;bottom:10px} 这里定义了距离父级靠右距离10px,距离父级靠下边距离为10px

对应HTML结构
<div class="divcss5">
    <div class="divcss5-a"></div>
</div>

这样就绝对定位了“divcss5-a”在父级“divcss5”盒子内。

注意的是，left（左）和right（右）在一个对象只能选一种定义，bottom（下）和top（上）也是在一个对象只能选一种定义。
四、position应用案例   -   TOP

这里DIVCSS5为大家实例应用position绝对定位，我们设置一个最外层盒子css边框为红色，css width为400px,css height为200px,内部包含了2个盒子，为就用绝对定位这2个盒子，第一个盒子CSS命名为“divcss5-a”,其宽度为100px,背景颜色为黑色，高度为100px,定位距离父级上为10px，距离左为10px;第二个盒子CSS类命名为“divcss5-b”，其宽度和高度分别为50px,css背景颜色为蓝色，距离父级下距离为13px,距离父级右边为15px。

1、css代码如下

    <style> 
    .divcss5{ position:relative;width:400px;height:200px; 
    border:1px solid #000} 
    /* 定义父级position:relative 为就认为是绝对定位声明吧 */ 
    .divcss5-a{ position:absolute;width:100px;height:100px; 
    left:10px;top:10px;background:#000} 
    /* 使用绝对定位position:absolute样式 并且使用left top进行定位位置 */ 
    .divcss5-b{ position:absolute;width:50px;height:50px; 
    right:15px;bottom:13px;background:#00F} 
    /* 使用绝对定位position:absolute样式 并且使用right bottom进行定位位置 */ 
    </style> 

2、html代码片段

    <div class="divcss5"> 
        <div class="divcss5-a"></div> 
        <div class="divcss5-b"></div> 
    </div> 

3、DIV+CSS绝对定位案例截图

CSS position absolute relative绝对定位应用案例截图
DIV+CSS position绝对定位布局应用案例
五、css绝对定位总结   -   TOP

通常我们使用position:absolute；position:relative进行绝对定位布局，通过CSS进行定义定位，DIV布局HTML，注意什么地方使用position:relative，什么地方使用position:absolute进行定位，同时不要忘记使用left、right、top、bottom的配合定位具体位置。绝对定位如果父级不使用position:relative，而直接使用position:absolute绝对定位，这个时候将会以body标签为父级，使用position:absolute定义对象无论位于DIV多少层结构，都将会被拖出以<body>为父级（参考级）进行绝对定位。绝对定位非常好用，但切记不要滥用，什么地方都用，这样有时会懒得计算距离上、下、左、右间距，同时可能会造成CSS代码臃肿，更加经验适当使用，用于该使用地方。

在绝对定位时候我们可以使用css z-index定义css层重叠顺序。

# text-align 图片/文字 居中/左/右

text-align语法：
text-align : left | right | center | justify 

```html
text-align参数值与说明：
left : 左对齐
right : 右对齐
center : 居中
*justify : 两端对齐（不推荐使用，通常大部分浏览器不使用）
我们对text-align常用的参数值为left、right、center
```

# 段落首行文字缩进 text-indent
.divcss5{text-indent:25px}
这里divcss5对象内段落首行开头文字缩进了25像素。


# 下划线，删除线，上划线  text-decoration

```html
text-decoration : none || underline || blink || overline || line-through

text-decoration下划线CSS单词值参数：
none : 　无装饰
blink : 　闪烁
underline : 　下划线
line-through : 　贯穿线
overline : 　上划线
```

# 清除浮动 clear 

我们知道有时使用了css float浮动会产生css浮动，这个时候就需要清理清除浮动，我们就用clear样式属性即可实现。

```html
1、clear语法：
clear : none | left|right| both

2、clear参数值说明：
none : 　允许两边都可以有浮动对象
both : 　不允许有浮动对象
left : 　不允许左边有浮动对象
right : 　不允许右边有浮动对象
```
使用clear可以清除float产生的浮动，注意clear样式对象加入位置，如上案例对“.divcss5”清除浮动，我们就只需要在此对象div标签结束前加入即可清除内部小盒子产生浮动。而一般常用clear:both来清除浮动，其它clear:left和clear:right可以下来根据clear both案例扩展学习实践。

# 鼠标助阵光标样式 cursor

1、cursor语法：
cursor : auto | crosshair | default | hand | move | help | wait | text | w-resize |s-resize | n-resize |e-resize | ne-resize |sw-resize | se-resize | nw-resize |pointer | url (url)

```html
1）、div{ cursor:default }默认正常鼠标指针
2）、div{ cursor:hand }和div{ cursor:text } 文本选择效果
3）、div{ cursor:move } 移动选择效果
4）、div{ cursor:pointer } 手指形状 链接选择效果
5）、div{ cursor:url(url图片地址) }设置对象为图片
```

# CSS文字 font
font、font-family(字体)、font-size（字大小）、font-style（字样式）、font-weight（css加粗）、text-decoration（下划线）、font-variant（字母大小写）、text-transform（英文大小写）、letter-spacing（间隔）


# 斜体字体 font-style

常用字体样式设置font-style: italic
兼容各大浏览器

normal : 正常的字体(默认字体样式，可用于去掉html i斜体标签默认斜体样式)

italic : 斜体。对于没有斜体变量的特殊字体，将应用oblique

oblique : 倾斜的字体

注意：< i >< / i > 标签也是斜体

# 全大写并缩小英文字幕字体 font-variant
font-variant : normal | small-caps

normal : 正常的字体
small-caps : 让字母变成小型的大写字母字体并缩小字母

# 字间距 
text-indent抬头距离，letter-spacing字与字间距

text-indent : 20px

# 行高 line-height
line-height:22px
div{line-height:22px}

line-height行高上下居中属性样式，使用于多排文字如文章内容实现文字上下排间隔居中属性，以及单排高度固定的上下垂直居中。常常遇见内容与图片混排，我们希望图片和文字内容上下居中在一排，但是文字会居图片下部，通常解决方法是使用两个盒子分别设置行高与高度。

# 英文全大写/小写 text-transform
text-transform 值：
Capitalize 英文拼音的首字母大写
Uppercase 英文拼音字母全大写
Lowercase 英文拼音字母全小写

2、CSS text-transform语法结构
div{text-transform:capitalize}

# 超出移除显示省略号 text-overflow
有时为了避免文本文字内容超出一定宽度后溢出，我们想要溢出的部分不显示但用省略号（...）显示，这个时候我们可以使用CSS text-overflow文本溢出省略号属性样式实现。

text-overflow语法：
text-overflow : clip | ellipsis

text-overflow参数值和解释：
clip : 　不显示省略标记（...），而是简单的裁切
ellipsis : 　当对象内文本溢出时显示省略标记（...）

# 强制不换行 white-space
让文字不自动换行，无论CSS宽度设置多少，所有文字都在一行内显示。特别是标题列表，我们想一行只显示一条标题内容，而有时宽度有限标题文字多了width(宽度)又有限，这样会造成文字自动换行，这个时候我们可以使用white-space样式让他一排显示不换行，当然我们为了隐藏超出的文字内容我们可以再加一个css overflow:hidden样式。

1、white-space语法：
white-space : normal nowrap

2、white-space参数：
normal : 　默认处理方式
nowrap : 　强制在同一行内显示所有文本，直到文本结束或者遭遇br标签对象才换行。DIVCSS5推荐使用white-space:nowrap强制不换行。

# 重叠顺序 z-index

div{z-index:100}

注意：z-index的数值不跟单位。

z-index的数字越高越靠前，并且值必须为整数和正数（正数的整数）。