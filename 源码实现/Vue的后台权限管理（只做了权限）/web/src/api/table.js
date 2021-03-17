import request from '@/utils/request'

export function getList(params) {
  return request({
    url: '/api/table/tableList',
    method: 'get',
    params
  })
}
