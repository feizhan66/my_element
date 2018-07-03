## 派生选择器

通过依据 元素 在其位置的上下文关系来定义样式，你可以使标记更加简洁。

希望列表中的 strong 元素变为斜体字，而不是通常的粗体字，可以这样定义一个派生选择器：

```angular2html
li strong {
    font-style: italic;
    font-weight: normal;
  }
```

## id 选择器
```angular2html
#red {color:red;}
```
id 选择器和派生选择器
```angular2html
#sidebar p {
	font-style: italic;
	text-align: right;
	margin-top: 0.5em;
	}
```
请注意，类选择器和 ID 选择器可能是区分大小写的。这取决于文档的语言。HTML 和 XHTML 将类和 ID 值定义为区分大小写，所以类和 ID 值的大小写必须与文档中的相应值匹配。
## 类选择器

```angular2html
.center {text-align: center}
```
和 id 一样，class 也可被用作派生选择器：
```angular2html
.fancy td {
	color: #f60;
	background: #666;
	}
```
元素也可以基于它们的类而被选择
```angular2html
td.fancy {
	color: #f60;
	background: #666;
	}
```
在上面的例子中，类名为 fancy 的表格单元将是带有灰色背景的橙色。
```angular2html
<td class="fancy">
```
类选择器可以结合元素选择器来使用。
例如，您可能希望只有段落显示为红色文本：
```angular2html
p.important {color:red;}
```
### CSS 多类选择器
在上一节中，我们处理了 class 值中包含一个词的情况。在 HTML 中，一个 class 值中可能包含一个词列表，各个词之间用空格分隔。例如，如果希望将一个特定的元素同时标记为重要（important）和警告（warning），就可以写作：
```angular2html
<p class="important warning">
This paragraph is a very important warning.
</p>
```
这两个词的顺序无关紧要，写成 warning important 也可以。
我们假设 class 为 important 的所有元素都是粗体，而 class 为 warning 的所有元素为斜体，class 中同时包含 important 和 warning 的所有元素还有一个银色的背景 。就可以写作：
```angular2html
.important {font-weight:bold;}
.warning {font-style:italic;}
.important.warning {background:silver;}
```
通过把两个类选择器链接在一起，仅可以选择同时包含这些类名的元素（类名的顺序不限）。
如果一个多类选择器包含类名列表中没有的一个类名，匹配就会失败。请看下面的规则：
```angular2html
.important.urgent {background:silver;}
```
不出所料，这个选择器将只匹配 class 属性中包含词 important 和 urgent 的 p 元素。因此，如果一个 p 元素的 class 属性中只有词 important 和 warning，将不能匹配。不过，它能匹配以下元素：
```angular2html
<p class="important urgent warning">
This paragraph is a very important and urgent warning.
</p>
```

## 属性选择器

下面的例子为带有 title 属性的所有元素设置样式：
```angular2html
[title]
{
color:red;
}
```
下面的例子为 title="W3School" 的所有元素设置样式：
```angular2html
[title=W3School]
{
border:5px solid blue;
}
<img title="W3School" src="">
```
下面的例子为包含指定值的 title 属性的所有元素设置样式。适用于由空格分隔的属性值：
```angular2html
[title~=hello] { color:red; }
<h2 title="hello world">Hello world</h2>
```
下面的例子为带有包含指定值的 lang 属性的所有元素设置样式。适用于由连字符分隔的属性值：
```angular2html
[lang|=en] { color:red; }
<h1>可以应用样式：</h1>
<p lang="en">Hello!</p>
<p lang="en-us">Hi!</p>
<hr />
```
设置表单的样式
```angular2html
input[type="text"]
{
  width:150px;
  display:block;
  margin-bottom:10px;
  background-color:yellow;
  font-family: Verdana, Arial;
}
```
只对有 href 属性的锚（a 元素）应用样式：
```angular2html
a[href] {color:red;}
```
还可以根据多个属性进行选择，只需将属性选择器链接在一起即可
```angular2html
a[href][title] {color:red;}
```
假设希望将指向 Web 服务器上某个指定文档的超链接变成红色，可以这样写：
```angular2html
a[href="http://www.w3school.com.cn/about_us.asp"] {color: red;}

a[href="http://www.w3school.com.cn/"][title="W3School"] {color: red;}
```

属性选择器参考

选择器 | 描述
--- | ---
[attribute] | 用于选取带有指定属性的元素。
[attribute=value] | 用于选取带有指定属性和值的元素。
[attribute~=value] | 用于选取属性值中包含指定词汇的元素。
[attribute|=value] | 用于选取带有以指定值开头的属性值的元素，该值必须是整个单词。
[attribute^=value] | 匹配属性值以指定值开头的每个元素。
[attribute$=value] | 匹配属性值以指定值结尾的每个元素。
[attribute*=value] | 匹配属性值中包含指定值的每个元素。

## 元素选择器
```angular2html
html {color:black;}
h1 {color:blue;}
h2 {color:silver;}
```
## CSS 分组
### 选择器分组
假设希望 h2 元素和段落都有灰色。为达到这个目的，最容易的做法是使用以下声明：
可以将任意多个选择器分组在一起，对此没有任何限制。
```angular2html
h2, p {color:gray;}
```
### 通配符选择器
CSS2 引入了一种新的简单选择器 - 通配选择器（universal selector），显示为一个星号（*）。该选择器可以与任何元素匹配，就像是一个通配符。
```angular2html
* {color:red;}
```

## 后代选择器
后代选择器（descendant selector）又称为包含选择器。
后代选择器可以选择作为某元素后代的元素。

如果您希望只对 h1 元素中的 em 元素应用样式，可以这样写：
```angular2html
h1 em {color:red;}
```
有关后代选择器有一个易被忽视的方面，即两个元素之间的层次间隔可以是无限的。

如果写作 ul em，这个语法就会选择从 ul 元素继承的所有 em 元素，而不论 em 的嵌套层次多深。


## 子元素选择器
与后代选择器相比，子元素选择器（Child selectors）只能选择作为某元素子元素的元素。

如果您不希望选择任意的后代元素，而是希望缩小范围，只选择某个元素的子元素，请使用子元素选择器（Child selector）。
例如，如果您希望选择只作为 h1 元素子元素的 strong 元素，可以这样写：
```angular2html
h1 > strong {color:red;}
<h1>This is <strong>very</strong> <strong>very</strong> important.</h1>
```
结合后代选择器和子选择器
```angular2html
table.company td > p
```
上面的选择器会选择作为 td 元素子元素的所有 p 元素，这个 td 元素本身从 table 元素继承，该 table 元素有一个包含 company 的 class 属性。

## 相邻兄弟选择器
相邻兄弟选择器（Adjacent sibling selector）可选择紧接在另一元素后的元素，且二者有相同父元素。

如果要增加紧接在 h1 元素后出现的段落的上边距
```angular2html
h1 + p {margin-top:50px;}

<h1>This is a heading.</h1>
<p>This is paragraph.</p>
<p>This is paragraph.</p>
```
请记住，用一个结合符只能选择两个相邻兄弟中的第二个元素。请看下面的选择器：
```angular2html
li + li {font-weight:bold;}

<ul>
    <li>List item 1</li>
    <li>List item 2</li>
    <li>List item 3</li>
  </ul>
  <ol>
    <li>List item 1</li>
    <li>List item 2</li>
    <li>List item 3</li>
  </ol>
```

## 伪类 (Pseudo-classes)
CSS 伪类用于向某些选择器添加特殊的效果。

伪类的语法：
```angular2html
selector : pseudo-class {property: value}
```
CSS 类也可与伪类搭配使用。
```angular2html
selector.class : pseudo-class {property: value}
```

```angular2html
a:link {color: #FF0000}		/* 未访问的链接 */
a:visited {color: #00FF00}	/* 已访问的链接 */
a:hover {color: #FF00FF}	/* 鼠标移动到链接上 */
a:active {color: #0000FF}	/* 选定的链接 */
```
提示：在 CSS 定义中，a:hover 必须被置于 a:link 和 a:visited 之后，才是有效的。
提示：在 CSS 定义中，a:active 必须被置于 a:hover 之后，才是有效的。
提示：伪类名称对大小写不敏感。










