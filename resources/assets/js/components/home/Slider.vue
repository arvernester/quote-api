<template>
  <div v-if="quotes" id="slidenew">
    <ul class="slider">
      <li v-for="(quote, index) in quotes">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
              <article class="os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0.3s">
                <h3>{{ quote.text }}</h3>
                <span class="lighted">{{ quote.author.name }}</span>
              </article>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
              <img :src="quote.author.full_image_path" alt="" class="os-animation" data-os-animation="fadeInRight" data-os-animation-delay="0.4s">
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'HomeSlider',

    data() {
      return {
        sliderOptions: {

        },
        quotes: []
      }
    },

    mounted() {
      this.load()
    },

    methods: {
      load() {
        axios.get('/api/quote/author')
          .then(response => {
            this.quotes = response.data

            this.$nextTick(() => {
              $('.slider').bxSlider(this.sliderOptions)
            })
          })
      }
    }
  }
</script>