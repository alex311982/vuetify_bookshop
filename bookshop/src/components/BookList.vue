<template>
  <div>
    <v-data-table :items="allBooks"
                  v-bind:headers="headers()"
                  hide-actions
                  :loading="!getIsBooksLoaded"
                  class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.item.book_name }}</td>
        <td class="text-xs-center">{{ props.item.authors_resolved.join(', ') }}</td>
        <td class="text-xs-center">{{ props.item.genres_resolved.join(', ') }}</td>
        <td class="text-xs-center">{{ props.item.book_description }}</td>
        <td class="text-xs-center">
          <del v-if="props.item.discount_tax">{{ props.item.book_price }}</del>
          {{ props.item.book_price - (props.item.book_price / 100 * props.item.discount_tax)  }}
        </td>
        <td class="text-xs-center">{{ +props.item.discount_tax }}%</td>
        <td><router-link :to="{ name: 'book', params: {id: props.item.book_id} }" class="nav-item nav-link">Details</router-link></td>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'booklist',
  computed: {
    ...mapGetters('book', ['getIsBooksLoaded', 'getBooks', 'getFilters']),
    allBooks () {
      let books = this.getBooks
      let filters = Object.values(this.getFilters)

      filters.forEach(function (filter) {
        books = books.filter(filter)
      })

      return books
    }
  },
  methods: {
    ...mapActions('book', ['booklist', 'genres', 'authors']),
    headers () {
      return [
          { text: 'Book', value: 'book_name', align: 'center' },
          { text: 'Author', value: 'authors', align: 'center' },
          { text: 'Genre', value: 'genres', align: 'center' },
          { text: 'Description', value: 'book_description', align: 'center', sortable: false },
          { text: 'Price', value: 'book_price', align: 'center' },
          { text: 'Discount', value: 'discount_tax', align: 'center' }
      ]
    }
  },
  created () {
    this.booklist()
    this.genres()
    this.authors()
  }
}
</script>
