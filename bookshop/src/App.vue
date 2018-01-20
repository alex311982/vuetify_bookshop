<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      clipped
      app
      v-model="drawer"
    >
      <v-list dense>
        <template v-for="(item, i) in resolvedItems">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="i"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
          </v-layout>
          <v-list-group v-else-if="item.children" v-model="item.model" no-action>
            <v-list-tile slot="item" @click="">
              <v-list-tile-action>
                <v-icon>{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
              @click="goTo(child.path_name, child.id, child.filter_by)"
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else @click="goTo(item.path_name, null, null)">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar
      color="blue darken-3"
      dark
      app
      clipped-left
      fixed
    >
      <v-toolbar-title :style="$vuetify.breakpoint.smAndUp ? 'width: 300px; min-width: 250px' : 'min-width: 72px'" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-xs-only">Google Contacts</span>
      </v-toolbar-title>
      <search></search>
      <div class="d-flex align-center" style="margin-left: auto">
        <v-btn icon>
          <v-icon>favorite</v-icon>
        </v-btn>
        <v-btn icon @click="goTo('cart')">
          <v-badge right>
            <span slot="badge">{{ totalCartItems }}</span>
            <v-icon>shopping_cart</v-icon>
          </v-badge>
        </v-btn>
        <v-btn icon large>
          <v-avatar size="32px" tile>
            <img
              src="https://vuetifyjs.com/static/doc-images/logo.svg"
              alt="Vuetify"
            >
          </v-avatar>
        </v-btn>
      </div>
    </v-toolbar>
    <v-content>
      <v-container fluid fill-height>
        <v-layout justify-center align-center>
          <router-view></router-view>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Search from '@/components/Search'

export default {
  name: 'App',
  data: () => ({
    drawer: null,
    items: [
      {
        id: 'genres',
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Genres',
        show: true,
        isResolved: false,
        children: [
          { text: 'Все', path_name: 'books', id: null, filter_by: null }
        ]
      },
      {
        id: 'authors',
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Authors',
        show: true,
        isResolved: false,
        path: '/book',
        children: [
          { text: 'Все', path_name: 'books', id: null, filter_by: null }
        ]
      },
      {
        id: 'login',
        icon: 'history',
        text: 'Login',
        isResolved: true,
        path_name: 'login',
        show: true
      },
      {
        id: 'registration',
        icon: 'history',
        text: 'Registration',
        isResolved: true,
        path_name: 'registration',
        show: true
      }
    ]
  }),
  props: {
    source: String
  },
  components: {
    Search
  },
  computed: {
    ...mapGetters('book', ['getAuthors', 'getGenres']),
    ...mapGetters('cart', ['getCart']),
    resolvedItems () {
      let genres = this.getGenres
      let authors = this.getAuthors
      let dataGenres

      dataGenres = this.items.map(function (item) {
        if (item.id === 'genres' && !item.isResolved && genres.length > 0) {
          let result = genres.map(function (genre) {
            return {text: genre.genre_name, id: genre.genre_id, path_name: 'books', filter_by: 'genres'}
          })

          item.children = [...item.children, ...result]
          item.isResolved = true
        }

        if (item.id === 'authors' && !item.isResolved && authors.length > 0) {
          let result = authors.map(function (author) {
            return {text: author.author_name, id: author.author_id, path_name: 'books', filter_by: 'authors'}
          })

          item.children = [...item.children, ...result]
          item.isResolved = true
        }

        return item
      })

      return dataGenres
    },
    totalCartItems () {
      return this.getCart.reduce((items, p) => items + p.num, 0)
    }
  },
  methods: {
    ...mapActions('book', ['genres', 'authors', 'setFilter']),
    goTo (pathName, id, filterBy) {
      let filter
      let filterName = `${this.$options.name} filter`

      if (filterBy && id) {
        let cb = (ids, filterBy) => book => ids.reduce((r, a) => book[filterBy].includes(a) && (r = r || true) || r, false)
        filter = cb([id], filterBy)
        this.setFilter({ filterName, filter })
      } else {
        filter = book => book
        this.setFilter({ filterName, filter })
      }

      pathName = !pathName ? 'home' : pathName
      this.$router.push({ name: pathName })
    }
  },
  created () {
    this.genres()
    this.authors()
  }
}
</script>