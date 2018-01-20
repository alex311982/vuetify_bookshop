import axios from '../../api/bookShopApi'
import _ from 'lodash'
import SessionStorage from '../../dao/SessionStorage'

const sessionProvider = new SessionStorage()

const getuser = async function (token) {
  let user

  if (token) {
    let response = await axios.get('user', {headers: {'token': token}})
    user = _.get(response, 'data.data')
  } else {
    throw new Error('Please provide token in order to get user')
  }

  return user
}

export default {
  namespaced: true,
  state: {
    user: null
  },
  mutations: {
    set (state, {type, data}) {
      state[type] = data
    }
  },
  actions: {
    async login ({commit, dispatch}, creds) {
      let token, user

      try {
        if (_.isObject(creds)) {
          let response = await axios.post('auth', creds)
          token = _.get(response, 'data.data.token')
        } else {
          token = sessionProvider.get('token')
        }
        if (token) {
          user = await getuser(token)
        }
      } catch (e) {
        throw new Error(e.message)
      }
      commit('set', {type: 'user', data: user})
      sessionProvider.set('token', token)
    },
    logout ({ commit }) {
      commit('set', {type: 'user', data: null})
      sessionProvider.remove('token')
    }
  },
  getters: {
    getUser (state) {
      return state.user
    }
  }
}
