import Cookies from 'js-cookie'

const userIdKey = 'user_id'

export function getUserId() {
  return Cookies.get(userIdKey)
}

export function setUserId(userId) {
  return Cookies.set(userIdKey, userId)
}

export function removeUserId() {
  return Cookies.remove(userIdKey)
}
