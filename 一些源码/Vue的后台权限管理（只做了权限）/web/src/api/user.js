import request from '@/utils/request'

export function userList(page) {
  return request({
    url: '/api/user/userList',
    method: 'post',
    data: {
      page: page
    }
  })
}
