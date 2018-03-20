# $store 与 store 的使用

```
<router-link to="/login">{{ $store.state.userName }}</router-link>
<router-link to="/login">{{ store.state.userName }}</router-link>
<router-link to="/login">{{ this.store.state.userName }}</router-link>
<router-link to="/login">{{ this.$store.state.userName }}</router-link>

$store 是挂载在 Vue 实例上的（即Vue.prototype），而组件也其实是一个Vue实例，在组件中可使用 this 访问原型上的属性，template 拥有组件实例的上下文，可直接通过 {{ $store.state.userName }} 访问，等价于 script 中的 this.$store.state.userName。
至于 {{ store.state.userName }}，script 中的 data 需声明过 store 才可访问。

```