实际上是使用vue的计算属性(computed)

如下代码(不能实现的)：

```vue
    <div id="vue_det">
        <input type="number" v-model="text">
        <div>{{textAdd}}</div>
    </div>

	<script type="text/javascript">
		var vm = new Vue({
			el: '#vue_det',
			data: {
				text: 1,
                textAdd:parseInt(this.text) + 1
			}
		})
	</script>

```

div标签里面的值为input中的值+1计算得出。

上面代码中的textAdd = parseInt(this.text) + 1，这种写法肯定访问不到this.text的值。

如若想访问data中的值，且textAdd是有text计算得出，想要实现双向数据绑定，text值变化，textAdd的值动态改变，可以用conputed来实现。代码如下：

```vue
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>vue的data中数据互相访问</title>
    <script src="https://cdn.bootcss.com/vue/2.4.2/vue.min.js"></script>
    <!-- <script src="vue.min.js"></script> -->
</head>
<body>
    <div id="vue_det">
        <input type="number" v-model="text">
        <div>{{textAdd}}</div>
    </div>

	<script type="text/javascript">
		var vm = new Vue({
			el: '#vue_det',
			data: {
				text: 1,
                // textAdd:this.text+1
			},
			computed: {
				textAdd: function() {
					return  (parseInt(this.text) + 1);
				}
			}
		})
	</script>
</body>
</html>

```












