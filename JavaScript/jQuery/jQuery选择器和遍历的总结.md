```
$('*'):全部元素

$(this):选中这个元素，this永远指的都是调用函数的那个对象

$('#intro'):id为intro的元素

$('.intro'):class为intro的元素

$('li:first'):所有li里的第一个

$('li:last'):所有li里的最后一个

$('li:first-child'):某个父元素里的第一个子元素，同时得是li元素

$('ul li:first'):第一个ul里的第一个li

$('ul li:first-child'):每个ul里的第一个子元素，同时得是li元素

$('footer .item:last-of-type'):footer的后代元素，类名是item，是其兄弟元素中的最后一个(元素种类不一致时每种元素都会出一个)

$('ul li:nth-child(n)'):每个ul里的第n个子元素并且同时得是li元素，n从1开始

$('ul li:nth-child(n+4)'):每个ul里的第4个子元素后面的元素并且同时得是li元素，包括第4个子元素，n从0开始

$('ul li:nth-child(-n+4)'):每个ul里的第1，2，3，4个子元素并且同时得是li元素，包括第4个子元素，n从0开始

$('ul li:nth-child(3n+1)'):隔二取一

$('ul li:nth-last-child(n)'):倒数第n个，n从1开始

$('ul li:nth-of-type(2)'):每个ul里的li元素里的第二个，括号里的数字从1开始

$('p.intro'):intro类中的p元素

$('div>span'):div的直接子元素里的span

$('div span'):div的后代子元素里的span

$('.intro+'):每个类名为intro的元素的下一个兄弟元素

$('div~p'): div后面的兄弟元素里的所有p元素

$('li:even'):索引值是偶数的li，注意！索引值从0开始

$('li:odd'):索引值是奇数的li

$('li:lt(3)'):索引值小于3的li

$('li:gt(3)'):索引值大于3的li

$('li:eq(index)'):按索引值index选中元素，index从0开始

$('ul:parent'):是父元素的ul

$('div:has(span)'):里面有span元素的div

$('div:has(p，span，li)'):里面同时有p，span和li的div

$(':animated'):当前所有动画元素

$(':button'):button元素和type='button'的input元素

$('[id]'):有id属性的元素

$('[id="jQuery"]'):有id属性且属性值等于jQuery的元素。注意！不要单引号套单引号或双引号套双引号

$('div[id="jQuery"]'):有id属性且属性值等于jQuery的div

$('[id=" '+k+' "]'):有id属性且属性值等于变量k的值的元素

不能写成$('[class="hi hello"]')，包裹属性值的引号里只被识别为一个字符串，不要放置多个属性值

$('[class="hi"][type="button"]'):同时有class属性和type属性且class属性的属性值等于hi，type属性的属性值等于button的那个元素。注意！前后两个属性不能相同，后面还能再增加其他属性选择器

$('[class="hi"]，[type="button"]'):有class属性且属性值是hi的元素和有type属性且属性值是button的元素的集合

$('[class!="hi"]'):选中除了有class属性且属性值等于hi的其他元素

$('[href$=".png"]'):有href属性且属性值以.png结尾的元素

$('[name|="code"]'):有name属性且属性值等于code或属性值以code作为前缀的元素，如:

识别<input name="code">，<input name="code-gaga">，不识别<input name="code gaga">，<input name="codegaga">

$('[name^="code"]'):有name属性且属性值以code字符串开头的元素

$('[name*="nation"]'):有name属性且属性值中包含nation字符串的元素，如:

识别<input name="nationality">，<input name="nation">，<input name="anothernation">，不识别<input name="country">

$('[name~="nation"]'):有name属性且属性值中包含nation单词的元素，如:

识别<input name="nation">，不识别<input name="nationality">，<input name="anothernation">，<input name="country">



siblings():和被选元素有相同父元素的所有兄弟元素

$('.intro').next():每个类名为intro的元素的下一个兄弟元素。$('.intro').next() = $('.intro+')；$('.intro').next('input') = $('.intro+input')

nextAll():被选元素后面的所有兄弟元素，不包含被选元素本身

nextUntil():两个给定参数之间的所有兄弟元素，如:$('h1').nextUntil('h6')，选中h1到h6之间的兄弟元素，不包含h1和h6

prev()和next()类似，prevAll()和nextAll()类似，prevUntil()和nextUntil()类似

find(filter):filter参数是必需的，从被选元素的所有后代元素中查找。查找被选元素的所有后代元素:find('*')

children():被选元素的所有直接子元素，不会返回文本节点

parent():被选元素的直接父元素

parents():被选元素的所有祖先元素。如需返回多个祖先元素:parents('li，ul')

parentsUntil():在两个元素之间的所有祖先元素，例:$('span').parentsUntil('div')，不含div

closest('#pop'):从当前元素开始沿DOM树向上遍历，返回被选元素的，id是pop的，第一个祖先元素，也会返回本身，如:$('#pop').closest('#pop')

eq(index):按索引值index选中元素，index从0开始，括号里不用加引号，如:eq(0)

index也可以是负数，表示倒数，如:eq(-1)表示倒数第一个，eq(-2)表示倒数第二个

first():选中第一个元素

last():选中最后一个元素

filter():选中符合筛选条件的元素，如:filter('.intro')，筛选出类名为.intro的元素

not():选中不符合筛选条件的元素，刚好和filter()相反

each():为每个匹配的元素指定要运行的函数，如:

$('p').each(function () { alert( $(this).text() )；})；



document.getElementsByTagName()
```
