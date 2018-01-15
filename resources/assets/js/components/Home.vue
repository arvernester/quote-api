<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <blockquote class="quote-card red-card">
          <p>{{ quote.text }}</p>
          <cite>{{ quote.author }}</cite>
        </blockquote>

        <button @click="random" class="btn btn-danger">Refresh</button>
        <button class="btn btn-default btn-copy" :data-clipboard-text="quote.text + ' ~~ ' + quote.author">Copy</button>
      </div>
    </div>
  </div>
</template>

<script>
  import Clipboard from 'clipboard'

  const clipboard = new Clipboard('.btn-copy')

  export default {
    name: 'Home',

    data() {
      return {
        quote: {}
      }
    },

    mounted() {
      this.random()
    },

    methods: {
      random() {
        axios.get('/api/quote/random')
          .then(response => {
            this.quote = response.data
          })
          .catch(e => console.error(e))
      }
    }
  }
</script>