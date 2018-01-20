export default class Cart {

  static addToCart (items, item) {
    let itemAddToCart = item
    const cart = {}
    const map = new Map(Object.entries(items))

    if (map.has(item.book_id)) {
      itemAddToCart = map.get(item.book_id)
      itemAddToCart.num++
    } else {
      itemAddToCart.num = 1
    }

    map.set(item.book_id, itemAddToCart)

    map.forEach(function (value, key) {
      cart[key] = value
    })

    return cart
  }

  static updateBookNum (items, id, num) {
    let itemUpdate
    const cart = {}
    const map = new Map(Object.entries(items))

    if (map.has(id) && Number.isInteger(num) && num > 0) {
      itemUpdate = map.get(id)
      itemUpdate.num = num
      map.set(id, itemUpdate)
    } else if (Number.isInteger(num) && num <= 0) {
      map.delete(id)
    }

    map.forEach(function (value, key) {
      cart[key] = value
    })

    return cart
  }

  static processToArray (items) {
    const cartArray = []
    const map = new Map(Object.entries(items))

    map.forEach(function (value, key) {
      cartArray.push(value)
    })

    return cartArray
  }

  static removeFromCart (items, id) {
    const cart = {}
    const map = new Map(Object.entries(items))

    map.delete(id)

    map.forEach(function (value, key) {
      cart[key] = value
    })

    return cart
  }

  static loadCart (sessionManager) {
    let cart = sessionManager.get('cart') || '{}'
    cart = JSON.parse(cart)
    return cart
  }

  static clearCart (sessionManager) {
    sessionManager.clear()
  }

  static saveCart (cart, sessionManager) {
    sessionManager.set('cart', JSON.stringify(cart))
  }

  static totalCart (items) {
    const map = new Map(Object.entries(items))

    return map.size
  }
}
