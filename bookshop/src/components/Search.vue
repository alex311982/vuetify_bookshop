<template>
  <v-text-field
    light
    solo
    prepend-icon="search"
    placeholder="Search"
    v-model="search"
    style="max-width: 500px; min-width: 128px"
  ></v-text-field>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'Search',
  data: () => ({
    search: ''
  }),
  methods: {
    ...mapActions('book', ['setFilter'])
  },
  watch: {
    search: function (searchString) {
      let filter
      let filterName = `${this.$options.name} filter`

      searchString = searchString.trim().toLowerCase()

      if (searchString) {
        let cb = (searchString, filterBy) => book => book[filterBy].toLowerCase().indexOf(searchString) !== -1
        filter = cb(searchString, 'resolved_search_string')
        this.setFilter({filterName, filter})
      } else {
        filter = book => book
        this.setFilter({ filterName, filter })
      }
    }
  }
}
</script>
