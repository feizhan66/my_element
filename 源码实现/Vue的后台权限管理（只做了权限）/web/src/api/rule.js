import request from '@/utils/request'

export function getRuleList() {
  return request({
    url: '/api/user_rule/ruleList',
    method: 'post',
    data: {}
  })
}

export function ruleDetail(rule_id) {
  return request({
    url: '/api/user_rule/ruleDetail',
    method: 'post',
    data: {
      rule_id: rule_id
    }
  })
}

export function ruleEdit(param) {
  return request({
    url: '/api/user_rule/ruleEdit',
    method: 'post',
    data: param
  })
}

export function ruleAdd(param) {
  return request({
    url: '/api/user_rule/ruleAdd',
    method: 'post',
    data: param
  })
}

export function ruleDeleteOne(rule) {
  return request({
    url: '/api/user_rule/ruleDeleteOne',
    method: 'post',
    data: {
      rule: rule
    }
  })
}

export function roleList() {
  return request({
    url: '/api/user_rule/roleList',
    method: 'post',
    data: {}
  })
}

export function roleDetail(role_id) {
  return request({
    url: '/api/user_rule/roleDetail',
    method: 'post',
    data: {
      'role_id': role_id
    }
  })
}

export function roleUpdate(form, rules) {
  // 对象转JSON
  return request({
    url: '/api/user_rule/roleUpdate',
    method: 'post',
    data: {
      role_id: form.role_id,
      form: JSON.stringify(form),
      rules: JSON.stringify(rules)
    }
  })
}

export function roleAdd(form, rules) {
  return request({
    url: '/api/user_rule/roleAdd',
    method: 'post',
    data: {
      form: form,
      rules: rules
    }
  })
}

export function roleDelete(roles) {
  return request({
    url: '/api/user_rule/roleDelete',
    method: 'post',
    data: {
      roles: roles
    }
  })
}

export function userList(page) {
  return request({
    url: '/api/user_rule/userList',
    method: 'post',
    data: {
      page: page
    }
  })
}

export function userRoleList(people_id) {
  return request({
    url: '/api/user_rule/userRoleList',
    method: 'post',
    data: {
      people_id: people_id
    }
  })
}

export function alertUserRole(people_id, roles) {
  return request({
    url: '/api/user_rule/alertUserRole',
    method: 'post',
    data: {
      people_id: people_id,
      roles: roles
    }
  })
}
