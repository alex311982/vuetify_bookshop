<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs12>
        <div v-if="!totalCartNum">EMPTY CART</div>
        <template v-for="(item,index) in items">
          <v-card :color=color(index) class="white--text">
            <v-container fluid grid-list-lg>
              <v-layout row align-center>
                <v-flex xs1>
                  <v-card-media
                    :src=item.image
                    height="70px"
                    contain
                  ></v-card-media>
                </v-flex>
                <v-flex xs3>
                  <v-card-title>
                    <div><span class="title">Title: </span>{{ item.book_name }}</div>
                  </v-card-title>
                </v-flex>
                <v-flex xs2>
                  <v-card-text>
                    <div><span class="title">Authors: </span>{{ item.authors_resolved.join(', ') }}</div>
                    <div><span class="title">Genres: </span>{{ item.genres_resolved.join(', ') }}</div>
                  </v-card-text>
                </v-flex>
                <v-flex xs1.5>
                  <v-card-text>
                    <div><del v-if="item.discount_tax">{{ item.book_price }} $</del></div>
                    <div>{{ item.book_price - (item.book_price / 100 * item.discount_tax) }} $</div>
                  </v-card-text>
                </v-flex>
                <v-flex xs1.5>
                  <v-card-text>
                    <div>{{ item.num }}</div>
                  </v-card-text>
                </v-flex>
                <v-flex xs3>
                  <v-card-actions d-flex>
                    <v-btn fab dark small color="primary" @click="decrement(item.book_id, item.num)">
                      <v-icon dark>remove</v-icon>
                    </v-btn>
                    <v-btn fab dark small color="primary" @click="increment(item.book_id, item.num)">
                      <v-icon dark>add</v-icon>
                    </v-btn>
                    <v-btn round color="primary" dark @click="removeBook(item.book_id)">
                      Remove
                    </v-btn>
                  </v-card-actions>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </template>
        <div v-if="totalCartNum"><span class="display-1">Total: </span><span class="title">{{ totalCartAmount }} $</span></div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    computed: {
      ...mapGetters('cart', {
        'items': 'getCart',
        'totalCartNum': 'getTotalCart'
      }),
      totalCartAmount () {
        return this.items.reduce((sum, p) => sum + (p.num * p.discount_price), 0).toFixed(2)
      }
    },
    methods: {
      ...mapActions('cart', ['removeBook', 'changeNumBook', 'buy']),
      color (i) {
        const colors = ['red', 'pink', 'purple', 'indigo', 'teal']
        return i <= colors.length - 1 ? colors[i] + ' lighten-2' : colors[0] + ' lighten-2'
      },
      decrement (id, num) {
        num--
        this.changeNumBook({id, num})
      },
      increment (id, num) {
        num++
        this.changeNumBook({id, num})
      }
    }
  }
</script>
