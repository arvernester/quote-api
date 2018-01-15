<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div v-for="(quote, index) in quotes.data" class="card">

          <div class="card-content">
            <blockquote>
              <p>{{ quote.text }}</p>

            </blockquote>
              <p class="author"><strong>{{ quote.author }}</strong></p>
          </div>
        </div>

        <ul class="pagination">
          <li v-if="quotes.prev_page_url">
            <a @click.prevent="load(quotes.prev_page_url)" :href="quotes.prev_page_url">&laquo; Previous</a>
          </li>
          <li v-if="quotes.next_page_url">
            <a @click.prevent="load(quotes.next_page_url)" :href="quotes.next_page_url">Next &raquo;</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'QuoteIndex',

    data() {
      return {
        quotes: []
      }
    },

    mounted() {
      this.load()
    },

    methods: {
      load(url = '/api/quote') {
        axios.get(url)
          .then(response => {
            this.quotes = response.data
          })
          .catch(e => console.error(e))
      }
    }
  }
</script>

<style scoped>
  .card {
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  }

  .card {
    margin-top: 10px;
    box-sizing: border-box;
    border-radius: 2px;
    background-clip: padding-box;
  }

  .card span.card-title {
    color: #fff;
    font-size: 24px;
    font-weight: 300;
    text-transform: uppercase;
  }

  .card .card-image {
    position: relative;
    overflow: hidden;
  }

  .card .card-image img {
    border-radius: 2px 2px 0 0;
    background-clip: padding-box;
    position: relative;
    z-index: -1;
  }

  .card .card-image span.card-title {
    position: absolute;
    bottom: 0;
    left: 0;
    padding: 16px;
  }

  .card .card-content {
    padding: 16px;
    border-radius: 0 0 2px 2px;
    background-clip: padding-box;
    box-sizing: border-box;
    background-color: #fff;
  }

  .card .card-content p {
    margin: 0;
    color: inherit;
  }

  .card .card-content span.card-title {
    line-height: 48px;
  }

  .card .card-action {
    border-top: 1px solid rgba(160, 160, 160, 0.2);
    padding: 16px;
  }

  .card .card-action a {
    color: #ffab40;
    margin-right: 16px;
    transition: color 0.3s ease;
    text-transform: uppercase;
  }

  .card .card-action a:hover {
    color: #ffd8a6;
    text-decoration: none;
  }
</style>