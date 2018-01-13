<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">Quotes ({{ quotes.total }})</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Quote</th>
                    <th>Author</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(quote, index) in quotes.data">
                    <td>{{ quote.category.name }}</td>
                    <td>{{ quote.text }}</td>
                    <td>{{ quote.author }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
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