import { login, logout, getInfo } from '@/api/login'
import { getToken, setToken, removeToken } from '@/utils/auth'
import { getUserId, setUserId, removeUserId } from '@/utils/userid'

const user = {
  state: {
    token: getToken() ? getToken() : '',
    name: '',
    avatar: '',
    roles: [],
    user_id: getUserId()
  },

  mutations: {
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_NAME: (state, name) => {
      state.name = name
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles
    },
    SET_USER_ID: (state, user_id) => {
      state.user_id = user_id
    }
  },

  actions: {
    // 登录
    Login({ commit, state }, userInfo) {
      const username = userInfo.mobilephone.trim()
      const password = userInfo.password
      return new Promise((resolve, reject) => {
        login(username, password).then(response => {
          const data = response.data
          // @/utils/auth里面定义的事件
          setToken(data.token)
          setUserId(data.user_id)
          commit('SET_USER_ID', data.user_id)
          commit('SET_TOKEN', data.token)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },

    // 获取用户信息
    GetInfo({ commit, state }, user_id) {
      // 这个是js异步响应的方法
      return new Promise((resolve, reject) => {
        // 请求了一个API
        getInfo(state.token, user_id).then(response => {
          const data = response.data
          commit('SET_NAME', data.user_name)
          commit('SET_AVATAR', data.avatar)
          // 这是成功的返回
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },

    // 登出
    LogOut({ commit, state }) {
      return new Promise((resolve, reject) => {
        logout(state.token).then(() => {
          commit('SET_TOKEN', '')
          commit('SET_ROLES', [])
          removeToken()
          removeUserId()
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },

    // 前端 登出
    FedLogOut({ commit }) {
      console.log('前端登出？')
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        removeToken()
        removeUserId()
        resolve()
      })
    }
  }
}

export default user
