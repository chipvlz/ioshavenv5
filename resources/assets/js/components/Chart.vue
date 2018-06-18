<template lang="html">

  <div class="w-100 chart-wrapper">
    <div class="loader" v-show="loading">
      <i class="fas fa-spinner fa-pulse fa-5x"></i>
    </div>
    <select v-model="timeframe" class="mt-3 mr-3 timeframe custom-select" @change="changeTimeframe">
      <option :value="7">last 7 days</option>
      <option :value="30">last 30 days</option>
      <option :value="90">last 90 days</option>
      <option :value="365">last 12 months</option>
      <option :value="-1">all time</option>
    </select>
    <div :id="'chart-' + _uid" class="chart"></div>
  </div>
</template>

<script>
export default {
  props: ['routes'],
  data() {
    return {
      el: '',
      loading: false,
      timeframe: 7,
      dataset: {},
      raw: {},
      routes2: []
    }
  },
  methods: {
    getDataSet () {
      return Object.keys(this.dataset).map(x => this.dataset[x])
    },
    getRoutes () {
      return this.routes2.map(x => axios.get(x));
    },
    addToDataset(data) {
      this.dataset[data.chart] = c({
        y: JSON.parse(data.count),
        x: JSON.parse(data.dates),
        name: data.chart
      })
    },
    changeTimeframe() {
      this.loading = true
      this.routes.forEach((v,i) => {
        console.log(v,i);
        if (this.timeframe === 7) this.routes2[i] = v + '/Y-_m-_d/7'
        else if (this.timeframe === 30) this.routes2[i] = v + '/Y-_m-_d/30'
        else if (this.timeframe === 90) this.routes2[i] = v + '/Y-_m-_d/90'
        else if (this.timeframe === 365) this.routes2[i] = v + '/Y-_m/12'
        else if (this.timeframe === -1) this.routes2[i] = v + '/Y-_m/10000'
      })

      Promise.all(this.getRoutes()).then(values => {
        values.forEach(res => this.addToDataset(res.data))
        Plotly.newPlot(this.el, this.getDataSet(), plotly_layout, plotly_options)
        this.loading = false
      })
    }
  },
  mounted () {
    this.loading = true
    this.routes2 = this.routes.slice()
    this.el = document.getElementById('chart-' + this._uid)
    Promise.all(this.getRoutes()).then(values => {
      console.log(values);
      values.forEach(res => this.addToDataset(res.data))
      Plotly.newPlot(this.el, this.getDataSet(), plotly_layout, plotly_options)
      this.loading = false
    })
  }
}
</script>

<style lang="css">
.chart-wrapper {
  overflow: auto;
  position: relative;
}
.chart {
  height: 500px;
  width: 900px;
}

.timeframe {
  z-index: 10000;
  position: absolute;
  top: 0;
  right: 0;
  width: auto;
}

.loader {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 20000;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0,0,0,0.7);
  color: white;
}
</style>
