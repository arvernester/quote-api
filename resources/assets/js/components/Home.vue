<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Quote of the Day</div>
          <div class="panel-body">
            <blockquote>
              <p>{{ quote.text }}</p>
              <strong>{{ quote.author }}</strong>
            </blockquote>

            <div class="actions">
              <button @click="random" class="btn btn-primary">
                <i class="fa fa-refresh fa-fw"></i> Refresh
              </button>
              <button class="btn btn-default copy" :data-clipboard-text="quote.text + ' ~~ ' + quote.author">
                <i class="fa fa-copy fw-fw"></i> Copy
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Clipboard from 'clipboard'

  const clipboard = new Clipboard('.copy')

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