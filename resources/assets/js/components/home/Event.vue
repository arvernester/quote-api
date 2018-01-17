<template>
  <section id="event">
    <div v-if="quote" class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h3 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.3s">{{ quote.text }}</h3>
          <p class="regular os-animation" data-os-animation="fadeInRight" data-os-animation-delay="0.4s">Quote of the day, from
            <a class="addborder" href="#">{{ quote.author }}</a> in <a v-if="quote.category" href="#" class="addborder">{{ quote.category.name }}</a>
          </p>
        </div>
      </div>
    </div>
  </section>
</template>


<script>
  export default {
    name: 'HomeEvent',

    data () {
      return {
        quote: {}
      }
    },

    mounted () {
      const params = {
        category: 'Love'
      }

      axios.get('/api/quote/of-the-day', { params })
        .then(response => {
          this.quote = response.data
        })
    }
  }
</script>