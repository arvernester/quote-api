<template>
  <section>
    <h2>{{ __('Contact us') }}</h2>
    <form @submit.prevent="send" method="post" action="/contact/post">
      <div class="field">
        <label for="name">{{ __('Name') }}</label>
        <input v-model="form.name" v-validate="'required|max:50|alpha_spaces'" type="text" name="name" id="name" :class="{'is-danger': errors.has('name')}" />
      </div>
      <div class="field">
        <label for="email">{{ __('Email') }}</label>
        <input v-model="form.email" v-validate="'required|email'" :class="{'is-danger': errors.has('email')}" type="text" name="email" id="email" />
      </div>
      <div class="field">
        <label for="message">{{ __('Message') }}</label>
        <textarea v-model="form.message" v-validate="'required|min:10'" :class="{'is-danger': errors.has('message') }" name="message" id="message" rows="3"></textarea>
      </div>
      <ul class="actions">
        <li>
          <button :disabled="loading" type="submit">{{ __('Send') }}</button>
        </li>
        <li v-if="loading">
          <em class="fa fa-spin fa-spinner"></em>
        </li>
        <li v-if="sent">
          {{ __('Your message has been sent successfully.') }}
        </li>
      </ul>
    </form>
  </section>
</template>

<script>
  import VeeValidate from 'vee-validate' 
  import { ErrorBag } from 'vee-validate'

  Vue.use(VeeValidate)

  export default {
    name: 'ContactForm',

    data() {
      return {
        loading: false,
        sent: false,
        form: {
          name: '',
          email: '',
          message: ''
        }
      }
    },

    methods: {
      send(e) {
        this.sent = false
        this.loading = true

        this.$validator.validateAll().then(result => {
          if (result) {
            axios.post(e.target.action, this.form)
              .then(response => {
                this.sent = response.data.status
                this.loading = !response.data.status
                this.form = {
                  name: '',
                  email: '',
                  message: ''
                }

                const bag = new ErrorBag();
                bag.clear()
              })
          }
          else {
            this.loading = false
          }
        })
      }
    }
  }
</script>

<style scoped>
  input.is-danger, textarea.is-danger {
    border: 2px solid #c0392b !important;
  }
</style>
