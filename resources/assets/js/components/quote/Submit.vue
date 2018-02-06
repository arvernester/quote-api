<template>
  <section class="post">
    <header class="major">
      <h1>{{ __('Submit Quote') }}</h1>
    </header>

    <hr>

    <div v-if="submitted" class="box">
      <p>{{ __('Thank you! Your quote has been submitted.') }}</p>
    </div>

    <form @submit.prevent="submit" method="post" :action="action" class="alt">
      <div class="row uniform">
        <div v-if="! form.anonymous" class="12u 12u$(xsmall)">
          <input :disabled="form.anonymous" :readonly="form.anonymous" v-model="form.author" name="author" id="author" value="" :placeholder="__('Author Name')" type="text">
        </div>

        <!-- Break -->
        <div class="12u$ 12u$(small)">
          <input v-model="form.anonymous" id="anonymous" name="anonymous" type="checkbox">
          <label for="anonymous">
            {{ __('Anonymous Quote') }}
          </label>
        </div>
        <!-- Break -->
        <div class="12u$">
          <textarea v-model="form.quote" name="quote" id="quote" :placeholder="__('Quote Text')" rows="6"></textarea>
        </div>
        <!-- Break -->
        <div class="12u$">
          <ul class="actions">
            <li>
              <button :disabled="loading" class="special" type="submit">{{ __('Submit Quote') }}</button>
            </li>
            <li>
              <button @click="reset" type="reset">{{ __('Reset') }}</button>
            </li>
            <li v-if="loading">
              <em class="fa fa-spin fa-spinner"></em>
            </li>
          </ul>
        </div>
      </div>
    </form>
  </section>
</template>

<script>
  export default {
    name: 'QuoteSubmit',

    props: {
      action: {
        default: '',
        type: String
      }
    },

    data () {
      return {
        submitted: false,
        loading: false,
        form: {
          author: '',
          anonymous: false,
          quote: ''
        }
      }
    },

    methods: {
      submit (e) {
        this.submitted = false
        this.loading = true

        axios.post(e.target.action, this.form)
          .then(response => {
            this.loading = false
            this.submitted = response.data.status

            this.form = {
              author: '',
              anonymous: false,
              text: ''
            }
          })
          .catch(e => {
            this.loading = false
            console.log(e)
          })
      },

      reset () {
        this.submitted  = false
        this.loading = false
        this.form = {
          author: '',
          anonymous: false,
          text: ''
        }
      }
    }
  }
</script>