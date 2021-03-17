## 方法一：使用JavaScript方法实现：


```
<html>
<head>
<title>响应式网页设计</title>
<script>
function sc1() {
document.getElementById("tt").style.top = (document.documentElement.scrollTop + (document.documentElement.clientHeight - document.getElementById("tt").offsetHeight) / 2) + "px";
document.getElementById("tt").style.left = (document.documentElement.scrollLeft + (document.documentElement.clientWidth - document.getElementById("tt").offsetWidth) / 2) + "px";
}
</script>

<head>
<body onload="sc1()">
<div id="tt" style="width:200px;height:200px;background:red;position:absolute; ">响应式网页设计</div>
</body>
</html>

使用JavaScript实现的优点是，我们可以随意改变div的大小。
```


方法二：使用CSS方法实现：

```
<html>
<head>
<title>响应式网页设计</title>
<style type="text/css">
#tt{
height:200px;
width:200px;
background:red;
top:50%;
left:50%;
position:absolute;
margin-top:-100px;
margin-left:-100px;
}
</style>
<head>
<body onload="sc1()">
<div id="tt">响应式网页设计</div>
</body>
</html>

使用CSS代码实现的缺点是，我们改变div的宽度和高度时，还要修改margin-top和margin-left两个属性值。
```






