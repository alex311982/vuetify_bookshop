import axios from '../../api/bookShopApi'
import Cart from '../../dao/Cart'
import SessionStorage from '../../dao/SessionStorage'
import _ from 'lodash'

const sessionProvider = new SessionStorage()

export default {
  namespaced: true,
  state: {
    cart: {}
  },
  mutations: {
    setCart (state, items) {
      state.cart = items
    },
    addToCart (state, {item}) {
      state.cart = Cart.addToCart(state.cart, item)
    },
    removeFromCart (state, {id}) {
      state.cart = Cart.removeFromCart(state.cart, id)
    },
    updateBookNum (state, {id, num}) {
      state.cart = Cart.updateBookNum(state.cart, id, num)
    }
  },
  actions: {
    addToCart ({ commit, state, rootGetters }) {
      let item = rootGetters['book/getBook']
      if (_.isEmpty(item)) {
        throw new Error('not book to add to cart')
      }
      commit('addToCart', {item})
      Cart.saveCart(state.cart, sessionProvider)
    },
    removeBook ({ commit, state }, id) {
      commit('removeFromCart', {id})
      Cart.saveCart(state.cart, sessionProvider)
    },
    changeNumBook ({ commit, state }, {id, num}) {
      commit('updateBookNum', {id, num})
      Cart.saveCart(state.cart, sessionProvider)
    },
    clearCart ({commit}) {
      commit('setCart', {})
      Cart.clearCart(sessionProvider)
    },
    async buy () {
      let order = this.$store.getters.cart.map(book => { return {id: book.book_id, count: book.num} })
      let token = sessionStorage.getItem('token')
      let {data: {success}} = await axios.put('order', {book: order}, {headers: {token}})
      if (success) {
        this.$store.dispatch('clearCart')
      }
    }
  },
  getters: {
    getCart (state) {
      state.cart = !_.isEmpty(state.cart) ? state.cart : Cart.loadCart(sessionProvider)

      return Cart.processToArray(state.cart)
    },
    getTotalCart (state) {
      return Cart.totalCart(state.cart)
    }
  }
}
