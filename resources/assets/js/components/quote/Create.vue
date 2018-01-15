<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
          <div class="panel-heading">Add New Quote</div>
          <div class="panel-body">

            <div v-if="alert.message" :class="['alert', 'alert-' + alert.type]">
              {{ alert.message }}
            </div>

            <form @submit.prevent="store" action="/api/quote" method="post">

              <div :class="['form-group', errors.category ? 'has-error': '']">
                <label for="text">Category</label>
                <select v-model="quote.category" class="form-control">
                  <option value="">Select Category</option>
                  <option v-for="category in categories" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
                <span v-if="errors.category" class="text-danger">
                  {{ errors.category[0] }}
                </span>
              </div>

              <div :class="['form-group', errors.language ? 'has-error': '']">
                <label for="text">Language</label>
                <select v-model="quote.language" class="form-control">
                  <option value="">Select Language</option>
                  <option v-for="language in languages" :value="language.id">
                    {{ language.name }} - {{ language.native_name }}
                  </option>
                </select>
                <span v-if="errors.language" class="text-danger">
                  {{ errors.language[0] }}
                </span>
              </div>

              <div :class="['form-group', errors.text ? 'has-error': '']">
                <label for="text">Text</label>
                <textarea v-model="quote.text" class="form-control"></textarea>
                <span v-if="errors.text" class="text-danger">
                  {{ errors.text[0] }}
                </span>
              </div>

              <div :class="['form-group', errors.author ? 'has-error' : '']">
                <label for="text">Author</label>
                <input :disabled="quote.anonymous" v-model="quote.author" type="text" class="form-control">
                <span v-if="errors.author" class="text-danger">
                  {{ errors.author[0] }}
                </span>
              </div>

              <div class="form-group">
                <label for="anonymous">
                  <input type="checkbox" v-model="quote.anonymous">
                  This quote is anynomous
                </label>
              </div>

              <div class="form-group">
                <button :disabled="loading" @click="store" class="btn btn-primary">Save</button>
                <button @click="cancel" class="btn">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'QuoteCreate',

    data() {
      return {
        alert: {
          type: 'success',
          message: ''
        },
        loading: false,
        errors: [],
        categories: [],
        languages: [],
        quote: {
          category: '',
          language: '',
          text: '',
          author: '',
          anonymous: false
        }
      }
    },

    mounted () {
      this.loadCategory()
      this.loadLanguage()
    },

    methods: {
      loadCategory () {
        axios.get('/api/category')
          .then(response => {
            this.categories = response.data
          })
      },

      loadLanguage () {
        axios.get('/api/language')
          .then(response => {
            this.languages = response.data
          })
          .catch(e => console.error(e))
      },

      store(e) {
        this.loading = true
        this.errors = []

        this.alert.message = ''

        axios.post(e.target.action, this.quote)
          .then(response => {
            this.loading = false

            this.quote = {
              category: '',
              text: '',
              author: ''
            }

            this.alert = {
              type: 'success',
              message: 'Thank you! Quote has been stored.'
            }
          })
          .catch(error => {
            if (error.response.status == 422) {
              this.errors = error.response.data.errors
            }

            this.loading = false
          })
      },

      cancel() {
        this.$router.push({
          name: 'home'
        })
      }
    },

    watch: {
      'quote.anonymous' (val) {
        if (val == true) {
          this.quote.author = ''
        }
      }
    }
  }
</script>