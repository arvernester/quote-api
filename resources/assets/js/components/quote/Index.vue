<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="pagination">
          <li v-if="quotes.prev_page_url">
            <a @click.prevent="load(quotes.prev_page_url)" :href="quotes.prev_page_url">&laquo; Previous</a>
          </li>
          <li v-if="quotes.next_page_url">
            <a @click.prevent="load(quotes.next_page_url)" :href="quotes.next_page_url">Next &raquo;</a>
          </li>
        </ul>

        <blockquote v-for="(quote, index) in quotes.data" class="quote-card blue-card">
          <p>{{ quote.text }}</p>
          <cite>{{ quote.author }}</cite>
        </blockquote>

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