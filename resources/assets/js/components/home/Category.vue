<template>
  <section id="category">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h3 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.3s">Quote from Random Category</h3>
          <span class="line os-animation" data-os-animation="rollIn" data-os-animation-delay="0.4s"></span>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="clearfix">
            <article v-for="(quote, index) in quotes.data" :data-quote-id="quote.id" class="os-animation quote-content" data-os-animation="fadeInDown" data-os-animation-delay="0.5s">
              <h4>{{ quote.category.name }}</h4>
              <p class="innerp">{{ quote.text }}</p>
              <span class="naming">{{ quote.author.name }}</span>

              <p class="hidden">
                <a href="#">
                  <i class="fa fa-copy fa-fw"></i>
                </a>
                <a href="#">
                  <i class="fa fa-twitter fa-fw"></i>
                </a>
              </p>
            </article>
          </div>
          <div>
            <button :disabled="loading" v-if="quotes.next_page_url" @click="load(quotes.next_page_url)" class="reason os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.5s">LOAD MORE</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import _ from 'lodash'

  export default {
    name: 'HomeCategory',

    data () {
      return {
        loading: false,
        quotes: []
      }
    },

    mounted () {
      this.load('/api/quote/category')
    },

    methods: {
      load (url) {
        this.loading = true

        axios.get(url)
          .then(response => {
            
            this.quotes = response.data

            this.loading = false
          })
          .catch(e => {
            console.error(e)

            this.loading = false
          })
      }
    }
  }
</script>