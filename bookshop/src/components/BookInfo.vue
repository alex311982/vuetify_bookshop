<template>
  <v-card>
    <v-card-title>
      <v-flex>
        <div>
          <div class="headline">{{book.book_name}}</div>
          <br/>
          Авторы:
          <ul>
            <li v-for="author in book.authors_resolved" :key="author">
              {{author}}
            </li>
          </ul>
        </div>
      </v-flex>
      <v-spacer></v-spacer>
      <img :src=book.image class='book_image'></img>
    </v-card-title>
    <v-card-text>
      {{book.book_description}}
    </v-card-text>
    <v-card-actions>
      <v-chip>
        {{book.genres_resolved.join(', ')}}
      </v-chip>
      <v-spacer></v-spacer>
      <v-btn flat @click.native="addToCart">
        ADD TO CART
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>

import { mapActions } from 'vuex'

export default {
  name: 'book_info',
  props: {
    book: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapActions('cart', ['addToCart'])
  }
}

</script>

<style scoped>
.book_image{
    height: 150px;
}

</style>