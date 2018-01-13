<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">Categories ({{ categories.length }})</div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Category Name</th>
                    <th>Total Quote</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(category, index) in categories">
                    <td>
                      <router-link :to="{
                        name: 'category.show',
                        params: {
                          id: category.id
                        }
                        }">{{ category.name }}</router-link>
                    </td>
                    <td>{{ category.quotes_count }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CategoryIndex',

  data () {
    return {
      categories: []
    }
  },

  mounted () {
    this.load()
  },

  methods: {
    load () {
      axios.get('/api/category')
        .then(response => {
          this.categories = response.data
        })
        .catch(e => console.error(e))
    }
  }
}
</script>
