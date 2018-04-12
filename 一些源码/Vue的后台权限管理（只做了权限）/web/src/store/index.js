import Vue from 'vue'
import Vuex from 'vuex'
import app from './modules/app'
import user from './modules/user'
import getters from './getters'

Vue.use(Vuex)

// 这里保证全局只有一个store
const store = new Vuex.Store({
  modules: {
    app,
    user
  },
  getters
})

export default store
