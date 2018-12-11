
vue-i18n 仓库地址：https://github.com/kazupon/vue-i18n

# 兼容性
支持 Vue.js 2.x 以上版本

# 安装方法
```node
npm install vue-i18n
```

# 使用方法
1. 在main.js中引入vue-i18n(前提是先要引入vue)
```vue
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)
```
2. 准备本地的翻译信息
```vue
const messages = {
    zh: {
      message: {
        hello: '好好学习，天天向上！'
      }
    },
    en: {
      message: {
        hello: 'good good study, day day up!'
      }
    }
}
```
3. 创建带有选项的Vuei18n实例
```vue
const i18n = new VueI18n({
    locale: 'en', // 语言标识
    messages
})
```
4. 把 i18n 挂载到 vue 根实例上
```vue
const app = new Vue({
    router,
    i18n,
    ...App
}).$mount('#app')
```
5. 在 HTML 模板中使用
```vue
<div id="app">
    <h1 style="font-size: 16px; text-align: center;">{{ $t("message.hello") }}</h1>
  </div>
```
我们刚才选定的语言标识是 “en” 英语，现在改成 “zh” 中文，并查看效果
```vue
const i18n = new VueI18n({
    locale: 'zh', // 语言标识
    messages
})
```
这样就可以轻松实现国际化了，实际开发中，页面内容肯定是很多的，我们可以把对应语言的信息保存为不同的 json对象
```vue
const i18n = new VueI18n({
    locale: 'en',  // 语言标识
    messages: {
        'zh': require('./common/lang/zh'),
        'en': require('./common/lang/en')
    }
})
```
zh.js
```vue
// 注意：一定是 exports，不是 export，否则会报错，报错信息是下列的中的内容不是 string
module.exports = {
    message: {
        title: '运动品牌'
    },
    placeholder: {
        enter: '请输入您喜欢的品牌'
    },
    brands: {
        nike: '耐克',
        adi: '阿迪达斯',
        nb: '新百伦',
        ln: '李宁'
    }
}
```
en.js
```vue
module.exports = {
    message: {
        title: 'Sport Brands'
    },
    placeholder: {
        enter: 'Please type in your favorite brand'
    },
    brands: {
        nike: 'Nike',
        adi: 'Adidas',
        nb: 'New Banlance',
        ln: 'LI Ning'
    }
}
```
接下来，在HTML 模板中使用，要特别注意在 js 中的国际化写法
```vue
// HTML
<div id="app">
    <div style="margin: 20px;">
      <h1>{{$t("message.title")}}</h1>
      <input style="width: 300px;" class="form-control" :placeholder="$t('placeholder.enter')">
      <ul>
        <li v-for="brand in brands">{{brand}}</li>
      </ul>
    </div>
</div>

// JS
data () {
    return {
      brands: [this.$t('brands.nike'), this.$t('brands.adi'), this.$t('brands.nb'), this.$t('brands.ln')]
    }
 },
```
在上面的操作中，我们都是通过手动修改 locale 的属性值来切换语言，实际上，更希望浏览器自动识别，这里可以借助于 cookie

1、新建一个 cookie.js 文件，用于读取cookie
```vue
function getCookie(name,defaultValue) {
  var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg))
    return unescape(arr[2]);
  else
    return defaultValue;
}

export {
  getCookie
}
```
2、在 main.js 中引入这个js，并通过 PLAY_LANG 属性来获取浏览器的语言
```vue
const i18n = new VueI18n({
    locale: getCookie('PLAY_LANG','zh'),    // 语言标识
    messages: {
        'zh': require('./common/lang/zh'),
        'en': require('./common/lang/en')
    }
})
```
这里需要注意两个极易出错的地方：

（1）、将 $t() 写成了 $()
（2）、json 中在同一个对象里有同名属性
vue-i18n 提供了一个全局配置参数叫 “locale”，通过改变 locale 的值可以实现不同语种的切换


