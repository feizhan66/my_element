
通过一起使用 box-align 和 box-pack 属性，对 div 框的子元素进行居中：

```
div
{
width:350px;
height:100px;
border:1px solid black;

/* Firefox */
display:-moz-box;
-moz-box-pack:center;
-moz-box-align:center;

/* Safari、Opera 以及 Chrome */
display:-webkit-box;
-webkit-box-pack:center;
-webkit-box-align:center;

/* W3C */
display:box;
box-pack:center;
box-align:center;
}
```


```
box-pack: start|end|center|justify;
```

## 浏览器支持
目前没有浏览器支持 box-pack 属性。
Firefox 支持替代的 -moz-box-pack 属性。
Safari、Opera 以及 Chrome 支持替代的 -webkit-box-pack 属性。







