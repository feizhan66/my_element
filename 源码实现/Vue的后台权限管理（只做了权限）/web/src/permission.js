import router from './router'
import store from './store'
import NProgress from 'nprogress' // Progress 进度条
import 'nprogress/nprogress.css'// Progress 进度条样式
import { Message } from 'element-ui'
import { getToken } from '@/utils/auth' // 验权
// 这里的作用是进行全局拦截

const whiteList = ['/login'] // 不重定向白名单
// 每个路由进入前进行判断，满足条件才进行跳转，否则跳转到特定的页面【这是router定义的功能】
router.beforeEach((to, from, next) => {
  // 这是导航加载的进度条，在切换页面时的右上角有显示
  NProgress.start()
  if (getToken()) {
    if (to.path === '/login') {
      next({ path: '/' })
    } else {
      // 这个在 vuex 的getters文件里面【由store引入】
      if (store.getters.roles.length === 0) {
        // 这是一个vuex的语法，调用预定义的getInfo方法
        store.dispatch('GetInfo', store.getters.user_id).then(res => { // 拉取用户信息
          next()
        }).catch(() => {
          // 获取用户信息不成功就调用注销用户的方法
          store.dispatch('FedLogOut').then(() => {
            Message.error('验证失败,请重新登录')
            next({ path: '/login' })
          })
        })
      } else {
        next()
      }
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      next()
    } else {
      next('/login')
      NProgress.done() // 结束进度条
    }
  }
})

router.afterEach(() => {
  NProgress.done() // 结束Progress
})
