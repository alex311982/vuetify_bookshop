<template>
  <v-icon>shopping_cart</v-icon>
  <span>{{getTotalItems}}</span>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
  name: 'mini_cart',
  methods: {
    ...mapGetters('cart', ['getTotalItems'])
  }
}

</script>
