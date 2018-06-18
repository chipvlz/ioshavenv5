// window.plotly = require('./plotly');

function getRandomArbitrary(min, max) {
  return Math.random() * (max - min) + min;
}

window.a = function a(min, max, l) {
  list = [];
  for (var i = 0; i < l; i++) {
    list.push(getRandomArbitrary(min, max))
  }
  return list
}


window.c = function c(obj) {
  var opt = {
    type: 'scatter',
    mode: 'lines+markers',
    line: {
      width: 2,
      dash: 'solid',
      shape: 'spline',
      simplify: true
    },
    marker: {
      symbol: 'circle',
      size: 5,
    }
    // hoverinfo: 'y'
  }
  Object.keys(obj).forEach(key => {
    opt[key] = obj[key]
  })
  return opt;
}


// downloads = c({
//   y: a(200, 1000, 10),
//   name: 'downloads'
// })
//
// likes = c({
//   y: a(50, 400, 10),
//   name: 'likes'
// })
//
// views = c({
//   y: a(400, 4000, 10),
//   name: 'views'
// })

// data = [
//   downloads, likes, views
// ]

window.plotly_layout = {
  showlegend: true,
  margin: {
    l: 60,
    r: 80,
    t: 60,
    b: 60,
    pad: 0
  },
  yaxis: {
    nticks: 7
  },
  xaxis: {
    nticks: 7,
    rangeslider: {
      visible: true,
      bgcolor: 'rgb(245, 245, 245)',
      bordercolor: 'rgb(208,208,208)',
      borderwidth: 1,
      thickness: 0.15,
      autorange: true
    }
  }
}

window.plotly_options = {
  displayModeBar: false,
  displaylogo: false
}
