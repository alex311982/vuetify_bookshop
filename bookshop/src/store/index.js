import Vue from 'vue'
import Vuex from 'vuex'
import book from './book'
import cart from './cart'
import user from './user'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    book,
    cart,
    user
  }
})

export default store
