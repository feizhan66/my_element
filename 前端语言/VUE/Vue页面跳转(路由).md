# 在template中的常见写法

```vue
<router-link to="/path">
    <button>跳转</button>
</router-link>
```

# 在js中设置跳转（在方法中跳转界面并传参，两种方式：params，query）

有时候我们需要的是点击按钮跳出弹窗，选择判断后进行跳转，我们常用.$router.push 跳转 传参：

```vue
<button @click = "func()">跳转</button>

//js
<script>
    export default{
        methods:{
            func (){
                this.$router.push({name: '/order/page1',params:{ id:'1'}});
            }
        }
    }
</script>
```

另有
```vue
this.$router.push({path: ''/order/index''});
this.$router.push({path: '/order/page1',query:{ id:'2'}});
this.$router.push({name: '/order/page2',params:{ id:'6'}});

//  path:'路由里配置的index.vue的路径'
//  params:{id:'1',name:'eva'} /query:{id:'5'}  需要传递的参数和值
```

路由传参params 和query两种方式的区别：　　

　　1、用法上的

　　　　刚才已经说了，query要用path来引入，params要用name来引入，接收参数都是类似的，分别是this.$route.query.name和this.$route.params.name。

　　注意接收参数的时候，已经是$route而不是$router了哦！！

　　2、展示上的

　　　　query更加类似于我们ajax中get传参，params则类似于post，说的再简单一点，前者在浏览器地址栏中显示参数，后者则不显示

三、路由参数的取值：

{{this.$route.params.参数名}}

　　注：注意接收参数的时候，已经是$route而不是$router了哦！！


