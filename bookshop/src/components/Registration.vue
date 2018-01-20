<template>
  <div>
    <v-form v-model="valid" ref="form" lazy-validation>
      <v-text-field
        label="Name"
        v-model="name"
        :rules="nameRules"
        :counter="10"
        required
      ></v-text-field>
      <v-text-field
        label="E-mail"
        v-model="email"
        :rules="emailRules"
        required
      ></v-text-field>
      <v-text-field
        label="Password"
        v-model="password"
        :rules="passwordRules"
        required
      ></v-text-field>
      <v-text-field
        label="Confirm Password"
        v-model="passwordConfirm"
        :rules="passwordConfirmRules"
      ></v-text-field>
      <v-btn
        @click="submit"
        :disabled="!valid">
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>
    </v-form>
  </div>
</template>


<script>
  import axios from '../api/bookShopApi'
  export default {
    name: 'registration',
    data () {
      return {
        valid: true,
        name: '',
        email: '',
        password: '',
        passwordConfirm: '',
        nameRules: [
          v => !!v || 'Name is required'
        ],
        emailRules: [
          v => !!v || 'E-mail is required',
          v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ],
        passwordRules: [
          v => v && v.length > 8 || 'Password must be more than 8 characters'
        ],
        passwordConfirmRules: [
          v => v === this.password || 'Passwords must be equal'
        ]
      }
    },
    methods: {
      async submit () {
        if (this.$refs.form.validate()) {
          let {data: {success, data: {token}}} = await axios.post('registration', {
            name: this.name,
            login: this.email,
            password: this.password
          })
          if (success) {
            if (token) {
              sessionStorage.setItem('token', token)
              this.$store.commit('set', {type: 'isLoggedIn', items: true})
            }
          }
        }
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>
