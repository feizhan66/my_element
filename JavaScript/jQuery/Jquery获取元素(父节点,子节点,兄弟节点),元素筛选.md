
一,js 获取元素(父节点,子节点,兄弟节点)

```javascript
var test = document.getElementById("test");
　　var parent = test.parentNode; // 父节点
　　var chils = test.childNodes; // 全部子节点
　　var first = test.firstChild; // 第一个子节点
　　var last = test.lastChile; // 最后一个子节点　
　　var previous = test.previousSibling; // 上一个兄弟节点
　　var next = test.nextSbiling; // 下一个兄弟节点
```

二,jquery 获取元素(父节点,子节点,兄弟节点)
```javascript
$("#test1").parent(); // 父节点
    $("#test1").parents(); // 全部父节点
    $("#test1").parents(".mui-content");
    $("#test").children(); // 全部子节点
    $("#test").children("#test1");
    $("#test").contents(); // 返回#test里面的所有内容，包括节点和文本
    $("#test").contents("#test1");
    $("#test1").prev();  // 上一个兄弟节点
    $("#test1").prevAll(); // 之前所有兄弟节点
    $("#test1").next(); // 下一个兄弟节点
    $("#test1").nextAll(); // 之后所有兄弟节点
    $("#test1").siblings(); // 所有兄弟节点
    $("#test1").siblings("#test2");
    $("#test").find("#test1");
```

三,元素筛选
```javascript
// 以下方法都返回一个新的jQuery对象，他们包含筛选到的元素
    $("ul li").eq(1); // 选取ul li中匹配的索引顺序为1的元素(也就是第2个li元素)
    $("ul li").first(); // 选取ul li中匹配的第一个元素
    $("ul li").last(); // 选取ul li中匹配的最后一个元素
    $("ul li").slice(1, 4); // 选取第2 ~ 4个元素
    $("ul li").filter(":even"); // 选取ul li中所有奇数顺序的元素
```































