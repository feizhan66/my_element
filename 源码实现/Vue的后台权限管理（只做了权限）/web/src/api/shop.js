import request from '@/utils/request'

export function createShop(form) {
  return request({
    url: '/api/shop/shopCreate',
    method: 'post',
    data: form
  })
}

export function updateShop(form) {
  return request({
    url: '/api/shop/shopUpdate',
    method: 'post',
    data: form
  })
}
