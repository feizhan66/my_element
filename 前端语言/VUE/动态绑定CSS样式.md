# 第一种方法

```vue
v-bind:class="{a:b,c:b}"     a c 代表CSS样式表里相应的样式名       b 代表true(启用此样式)/false(不启用此样式)
```

html:
```html
    <!--vue-app是根容器-->
    <div id="vue-app">
        <input type="button" v-on:click="a=!a" v-bind:class="{changeColor:a,changeWidth:a}" value="change!">
    </div>
```
css
```css
.changeColor{
    background: brown;
    color: #ffffff;
}
.changeWidth{
    width: 200px;
}
```
js
```js
//实例化vue对象
new Vue({
    el:"#vue-app",
    data:{
        a:false
    },
    methods:{},
    computed:{}
});
```

# 第二种方法

html
```html
    <!--vue-app是根容器-->
    <div id="vue-app">
        <input type="button" v-on:click="a=!a" v-bind:class="change" value="change">
    </div>
```
css文件与上面一样

js
```javascript
//实例化vue对象
new Vue({
    el:"#vue-app",
    data:{
        a:false
    },
    methods:{},
    computed:{
        change:function(){
            return {
                changeColor:this.a,
                changeWidth:this.a
            }
        }
    }
});

```








