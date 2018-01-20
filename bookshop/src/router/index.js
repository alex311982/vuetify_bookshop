import Vue from 'vue'
import Router from 'vue-router'
import Book from '@/components/Book'
import BookList from '@/components/BookList'
import Registration from '@/components/Registration'
import Cart from '@/components/Cart'
import About from '@/components/About'
import Login from '@/components/Login'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      component: BookList
    },
    {
      path: '/books',
      name: 'books',
      component: BookList
    },
    {
      path: '/book/:id',
      name: 'book',
      component: Book
    },
    {
      path: '/registration',
      name: 'registration',
      component: Registration
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/cart',
      name: 'cart',
      component: Cart
    },
    {
      path: '/about',
      name: 'about',
      component: About
    }
  ]
})
