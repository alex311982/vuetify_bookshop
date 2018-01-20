<template>
  <v-container>
    <v-layout>
      <transition-group name="fade" class='layout row wrap align-center' mode="out-in">
        <v-flex xs12 key='loading'>
          <book-info v-if="getIsBookLoaded" :book="getBook"></book-info>
          <skeleton-card v-if="!getIsBookLoaded" class='skeleton-card--opacity' :hasHeader="false" :isHorizontal="true"></skeleton-card>
        </v-flex>
      </transition-group>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import SkeletonCard from 'skeleton-card-vuejs'
import BookInfo from '@/components/BookInfo'

export default {
  name: 'book',
  components: {
    SkeletonCard,
    BookInfo
  },
  methods: {
    ...mapActions('book', ['book'])
  },
  created () {
    const id = this.$route.params.id
    this.book({id})
  },
  computed: mapGetters('book', ['getBook', 'getIsBookLoaded'])
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity .8s
}

.fade-enter,
.fade-leave-to
/* .fade-leave-active below version 2.1.8 */

{
    opacity: 0
}

.skeleton-card--opacity{
    opacity: 0.7;
}
</style>
