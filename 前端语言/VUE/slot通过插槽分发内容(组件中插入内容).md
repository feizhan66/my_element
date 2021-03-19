和 HTML 元素一样，我们经常需要向一个组件传递内容，像这样：

```vue
<alert-box>
  Something bad happened.
</alert-box>
```
渲染出一个错误的弹出提示

Vue 自定义的 <slot> 元素让这变得非常简单：

```vue
Vue.component('alert-box', {
  template: `
    <div class="demo-alert-box">
      <strong>Error!</strong>
      <slot></slot>
    </div>
  `
})
```












