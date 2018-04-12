import request from '@/utils/request'

export function login(mobile_phone, password) {
  return request({
    url: '/api/login/login',
    method: 'post',
    data: {
      mobile_phone,
      password
    }
  })
}

export function getInfo(sign_private_token, user_id) {
  return request({
    url: '/api/user/getUserInfo',
    method: 'post',
    data: {
      sign_private_token,
      user_id
    }
  })
}

export function logout() {
  return request({
    url: '/api/login/loginOut',
    method: 'post'
  })
}
