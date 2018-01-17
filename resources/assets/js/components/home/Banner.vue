<template>
  <div v-if="banners.length >= 1" id="banner">
    <ul class="banner">
      <li v-for="(banner, index) in banners">
        <div class="oneslide">
          <img :src="banner.full_path" :alt="banner.title" />
          <div class="maincontent">
            <h1 class="os-animation" data-os-animation="zoomIn" data-os-animation-delay="0.3s">{{ banner.title }}</h1>
            <h2 class="os-animation" data-os-animation="fadeInRight" data-os-animation-delay="0.4s">{{ banner.description }}</h2>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'HomeBanner',

    data () {
      return {
        sliderOptions: {

        },
        banners: []
      }
    },

    mounted () {
      this.load()
    },

    methods: {
      load () {
        axios.get('/api/banner/latest')
          .then(response => {
            this.banners = response.data

            this.$nextTick(() => {
              $('.banner').bxSlider(this.sliderOptions)
            })
          })
      }
    }
  }
</script>