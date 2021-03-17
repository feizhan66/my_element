
在进行vue项目开发时，常用vue-router进行路由的导航，这种方式可以很好的进行路由和组件的匹配，但是当用户手动更改为未进行匹配的url时，系统找不到响应的组件进行页面渲染，就会出现空白页面。这种用户体验并不好，下面总结解决该问题的方法。

## 1.导航守卫

可以使用 router.beforeEach 注册一个全局前置守卫：

```vue
const router = new VueRouter({ ... })
 
router.beforeEach((to, from, next) => {
  // ...
})
```
当一个导航触发时，全局前置守卫按照创建顺序调用。守卫是异步解析执行，此时导航在所有守卫 resolve 完之前一直处于 等待中。

每个守卫方法接收三个参数：

- to: Route: 即将要进入的目标 路由对象

- from: Route: 当前导航正要离开的路由

- next: Function: 一定要调用该方法来 resolve 这个钩子。执行效果依赖 next 方法的调用参数

    next(): 进行管道中的下一个钩子。如果全部钩子执行完了，则导航的状态就是 confirmed (确认的)。
    
    next(false): 中断当前的导航。如果浏览器的 URL 改变了 (可能是用户手动或者浏览器后退按钮)，那么 URL 地址会重置到 from 路由对应的地址。
    
    next('/') 或者 next({ path: '/' }): 跳转到一个不同的地址。当前的导航被中断，然后进行一个新的导航。你可以向 next 传递任意位置对象，且允许设置诸如 replace: true、name: 'home' 之类的选项以及任何用在 router-link 的 to prop 或 router.push 中的选项。
    
    next(error): (2.4.0+) 如果传入 next 的参数是一个 Error 实例，则导航会被终止且该错误会被传递给 router.onError() 注册过的回调。

确保要调用 next 方法，否则钩子就不会被 resolved。

利用该特性，可以使用下面的代码端解决未匹配路由的问题：

```vue
router.beforeEach((to, from, next) => {
  if (to.matched.length ===0) {  //如果未匹配到路由
    from.path? next({ path:from.path}) : next('/');   //如果上级也未匹配到路由则跳转主页面，如果上级能匹配到则转上级路由
  } else {
    next();    //如果匹配到正确跳转
  }
});
```

## 2.匹配所有路由

路由的匹配规则是按照书写的顺序执行的，第一条匹配成功则不去匹配下一条，利用这一特性，可以在所有匹配路由的下面拦截匹配所有路由：

```vue
//创建路由对象并配置路由规则
let router = new VueRouter({
    routes:[
       {path:'/',redirect:{name:"home"}},  // 重定向到主页
       {name:'home',path:'/home',component:Home},
       {name:'login',path:'/login',component:Login},
       {path:'*',component:NotFound},//全不匹配的情况下，匹配NotFound组件，路由按顺序从上到下，依次匹配。最后一个*能匹配全部，
    ]
});
```

## 3.重定向

原理同方法2，只不过在匹配到*时，重定向到根路径：

```vue
//创建路由对象并配置路由规则
let router = new VueRouter({
    routes:[
       {path:'/',redirect:{name:"home"}},  // 重定向到主页
       {name:'home',path:'/home',component:Home},
       {name:'login',path:'/login',component:Login},
       {path:'*',redirect:'/'},//路由按顺序从上到下，依次匹配。最后一个*能匹配全部，然后重定向到主页面
    ]
});
```

























