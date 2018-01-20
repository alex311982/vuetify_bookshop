<template>
    <div id="login">

      <div v-if="!isLoggedIn" class="form-group">

        <v-form v-model="valid" ref="form" lazy-validation>

          <v-text-field
            label="E-mail"
            v-model="email"
            :rules="emailRules"
            required
          ></v-text-field>

          <v-text-field
            label="Password"
            type="password"
            v-model="password"
            :rules="passwordRules"
            :counter="8"
            required
          ></v-text-field>

          <v-btn
            @click="singin"
            :disabled="!valid"
          >
            submit
          </v-btn>
          <v-btn @click="clear">clear</v-btn>

        </v-form>
        <router-link :to="{ name: 'registration' }">Registration</router-link>

      </div>
      <div v-else>
        Hi, <span v-if="user">{{user.name}}</span>
        <v-btn @click="logOut" >Log Out</v-btn>
      </div>

    </div>
</template>

<script>
  export default {
    name: 'login',
    data () {
      return {
        valid: false,
        password: '',
        passwordRules: [
          (v) => !!v || 'Password is required',
          (v) => v.length >= 8 || 'Passsword must be more than 10 characters'
        ],
        email: '',
        emailRules: [
          (v) => !!v || 'E-mail is required',
          (v) => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ]
      }
    },
    computed: {
      isLoggedIn () {
        return this.$store.getters.isLoggedIn
      },
      user () {
        return this.$store.getters.user
      }
    },
    methods: {
      singin () {
        if (this.$refs.form.validate()) {
          this.$store.dispatch('login', {login: this.email, password: this.password})
        }
      },
      logOut () {
        this.$store.dispatch('logout')
      },
      clear () {
        this.$refs.form.reset()
      }
    }
  }
</script>

