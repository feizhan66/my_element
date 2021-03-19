# 刷新操作

关于iframe中需要刷新当前页面或者刷新父页面的操作

- 页面中动态加载子窗体内容的情况
```
	$("#refresh").click(function(){
		parent.location.reload();
		})
```

- 刷新当前子窗体
```
	$("#refresh").click(function(){
		self.location.reload();
		})
```
















