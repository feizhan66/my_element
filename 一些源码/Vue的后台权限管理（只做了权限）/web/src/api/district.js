import request from '@/utils/request'

export function getDistrict(params) {
  return request({
    url: '/api/region/district',
    method: 'post',
    data: params
  })
}
