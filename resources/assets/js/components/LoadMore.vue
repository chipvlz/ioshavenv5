<template lang="html">
  <div class="d-flex justify-content-center mt-5" v-if="page < last_page">
    <div class="card col-lg-4 col-md-6 col-12">
        <button type="submit" class="btn btn-link" @click="loadmore">
          <slot>
            Load more apps
          </slot>
        </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['search', 'query', 'current', 'last', 'array'],
  data () {
    return {
      page: this.current,
      last_page: this.last
    }
  },
  methods: {
    loadmore () {
      this.page += 1;
      axios.get(encodeURI(`${this.search}?page=${this.page}&q=${this.query}&json=true`))
      .then(res => {
        this.page = res.data[this.array].current_page;
        this.last_page = res.data[this.array].last_page;
        this.$emit('update', res.data[this.array].data);
      })
      .then(() => {
        $('.dynamic-content').removeClass('d-none')
      })
    }
  },
  mounted () {
    this.$parent.readyForDynamicContent = true
  }
}
</script>

<style lang="css">
</style>
