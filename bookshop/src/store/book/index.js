import axios from '../../api/bookShopApi'

export default {
  namespaced: true,
  state: {
    books: {
      'data': [],
      'isLoaded': false
    },
    book: {
      'data': {},
      'isLoaded': false
    },
    genres: {
      'data': [],
      'isLoaded': false
    },
    authors: {
      'data': [],
      'isLoaded': false
    },
    filters: {}
  },
  mutations: {
    set (state, {type, data}) {
      state[type] = data
    }
  },
  actions: {
    setFilter ({commit, getters}, {filterName, filter}) {
      if (typeof filter === 'function' && filterName) {
        let filters = {...getters.getFilters, ...{[filterName]: filter}}
        commit('set', {type: 'filters', data: filters})
      }
    },
    async booklist ({commit, dispatch, getters}) {
      try {
        let {data: {data: books}} = await axios.get('getBooks')
        if (!getters.getIsGenresLoaded) {
          await dispatch('genres')
        }
        if (!getters.getIsAuthorsLoaded) {
          await dispatch('authors')
        }
        // calculate price with book`s discount
        books = books.map((book) =>
        ({
          ...book,
          ...{
            discount_price: ((100 - book.discount_tax) * book.book_price / 100).toFixed(2),
            genres_resolved: book.genres.map(value => getters.getGenreNameById(value)),
            authors_resolved: book.authors.map(value => getters.getAuthorNameById(value)),
            image: 'https://cdn.css-tricks.com/wp-content/uploads/2017/03/svg-animations.png'
          }
        }))
        // calculate search string
        let includedToSearchStringIndexes = ['book_description', 'book_name', 'book_price', 'discount_price', 'discount_tax', 'genres_resolved', 'authors_resolved']
        books = books.map((book) =>
        ({
          ...book,
          ...{
            resolved_search_string: includedToSearchStringIndexes.reduce((r, a) => (!Array.isArray(book[a]) && (r = r + ' ' + book[a])) || (Array.isArray(book[a]) && (r = r + ' ' + book[a].join(' '))) || r, '')
          }
        }))
        commit('set', {type: 'books', data: {data: books, isLoaded: true}})
      } catch (e) {

      }
    },
    async book ({commit, dispatch, getters}, {id}) {
      commit('set', {type: 'book', data: {data: {}, isLoaded: false}})

      let book

      try {
        if (!getters.getIsBooksLoaded) {
          await dispatch('booklist')
        }

        book = getters.getBooks.find(book => book.book_id === id)

        if (book === undefined) {
          throw new Error('not book')
        }
      } catch (e) {

      }
      commit('set', {type: 'book', data: {data: book, isLoaded: true}})
    },
    async genres ({commit}) {
      try {
        let {data: {data: genres}} = await axios.get('getGenres')
        commit('set', {type: 'genres', data: {data: genres, isLoaded: true}})
      } catch (e) {

      }
    },
    async authors ({commit}) {
      try {
        commit('set', {type: 'authors', data: {data: [], isLoaded: false}})
        let {data: {data: authors}} = await axios.get('getAuthors')
        commit('set', {type: 'authors', data: {data: authors, isLoaded: true}})
      } catch (e) {

      }
    }
  },
  getters: {
    getBooks (state) {
      return state.books.data
    },
    getIsBooksLoaded (state) {
      return state.books.isLoaded
    },
    getIsBookLoaded (state) {
      return state.book.isLoaded
    },
    getBook (state) {
      return state.book.data
    },
    getGenres (state) {
      return state.genres.data
    },
    getGenreNameById: (state) => (id) => {
      let genre = state.genres.data.find(value => value.genre_id === id)

      return genre.genre_name
    },
    getAuthorNameById: (state) => (id) => {
      let author = state.authors.data.find(value => value.author_id === id)

      return author.author_name
    },
    getIsGenresLoaded (state) {
      return state.genres.isLoaded
    },
    getAuthors (state) {
      return state.authors.data
    },
    getIsAuthorsLoaded (state) {
      return state.authors.isLoaded
    },
    getFilters (state) {
      return state.filters
    }
  }
}
