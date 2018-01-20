// ------------------------------------------------------
// SessionStorage
// ------------------------------------------------------
function getRandomString (len = 10) {
  let str = ''
  while (len--) {
    str += String.fromCharCode(48 + ~~(Math.random() * 42))
  }

  return str
}

function getKey () {
  let _key = window.sessionStorage.getItem('sessionKey')
  if (!_key) {
    _key = getRandomString()
    window.sessionStorage.setItem('sessionKey', _key)
  }

  return _key
}
// Get all from sessionStorage
function get (key) {
  if (!key) {
    key = getKey()
  }
  let val = JSON.parse(window.sessionStorage.getItem(key))

  return val || {}
}

  // Set all on sessionStorage
function set (key, val) {
  if (!key) {
    key = getKey()
  }
  window.sessionStorage.setItem(key, JSON.stringify(val))
}

export default class SessionStorage {
  get (key) {
    let val = get(key)
    return val[key]
  }

  set (key, value) {
    let val = get(key)
    val[key] = value
    set(key, val)
  }

  exists (key) {
    let val = get(key)
    return key in val
  }

  remove (key) {
    let val = get(key)
    delete val[key]

    set(key, val)
  }

  clear () {
    set(null, {})
  }
}
