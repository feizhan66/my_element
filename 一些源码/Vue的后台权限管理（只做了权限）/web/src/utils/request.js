import axios from 'axios'
import { Message, MessageBox } from 'element-ui'
import store from '../store'
import MD5 from 'md5'
// import { getToken } from '@/utils/auth'

// 创建axios实例
const service = axios.create({
  // 获取配置
  baseURL: process.env.BASE_API, // api的base_url
  timeout: 15000 // 请求超时时间
})

// request拦截器
service.interceptors.request.use(config => {
  // 对请求参数进行排序
  if (!sessionStorage.sign_equipment_sn) {
    sessionStorage.sign_equipment_sn = 'web' + (new Date()).getTime().toString()
  }
  const sign_equipment_sn = sessionStorage.sign_equipment_sn
  const params = config.data ? config.data : []

  // 判断用户是否登录
  if (config.user_tid) {
    params.user_tid = config.user_tid.toString()
    params.sign_private_token = store.getters.token
  }
  if (store.getters.token) {
    params.sign_private_token = store.getters.token
  }

  params.sign_public_token = 'qwertipljdasdasjdhasjhduihuhufhgafdyusgyurvdyfvb'
  params.equipment_sn = sign_equipment_sn
  params.sign_request_time = (Date.parse(new Date()) / 1000).toString()
  params.login_type = '1'
  params.sign_platform_type = '2'
  params.sign_api_versions = '1.0.0'
  params.platform_type = '2'
  params.sign_equipment_sn = sign_equipment_sn
  // 对密码进行MD5加密
  if (params.password) {
    params.password = MD5(config.data.password)
  }
  // JS字典排序
  const keys = Object.keys(params).sort()
  const sign_value = []

  // 遍历params属性
  for (var key in keys) {
    const param_key = keys[key]
    const param_value = params[param_key]
    if (param_value !== undefined && param_value !== 'undefined') {
      sign_value.push(param_key + '=' + param_value.toString())
    }
  }
  params.sign_value = MD5(sign_value.join('&'))

  // 删除公钥私钥
  delete params.sign_public_token
  delete params.sign_private_token
  config.data = params
  return config
}, error => {
  // Do something with request error
  console.log(error) // for debug
  Promise.reject(error)
})

// respone拦截器
service.interceptors.response.use(
  response => {
  /**
  * code为非20000是抛错 可结合自己业务进行修改
  */
    const res = response.data
    if (res.code !== 200) {
      Message({
        message: res.message,
        type: 'error',
        duration: 5 * 1000
      })

      // 50008:非法的token; 50012:其他客户端登录了;  50014:Token 过期了;
      if (res.code === 50008 || res.code === 50012 || res.code === 50014) {
        MessageBox.confirm('你已被登出，可以取消继续留在该页面，或者重新登录', '确定登出', {
          confirmButtonText: '重新登录',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          store.dispatch('FedLogOut').then(() => {
            location.reload()// 为了重新实例化vue-router对象 避免bug
          })
        })
      }
      return Promise.reject('error')
    } else {
      return response.data
    }
  },
  error => {
    console.log('err' + error)// for debug
    Message({
      message: error.message,
      type: 'error',
      duration: 5 * 1000
    })
    return Promise.reject(error)
  }
)

export default service
