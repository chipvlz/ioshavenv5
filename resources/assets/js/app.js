
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('editor', require('./components/Editor.vue'));
Vue.component('file-upload', require('./components/FileUpload.vue'));
Vue.component('load-more', require('./components/LoadMore.vue'));
Vue.component('chart', require('./components/Chart.vue'));

function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0B';
   var k = 1000,
       dm = decimals || 2,
       sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + sizes[i];
}

function formatNum(bytes,decimals) {
   if(bytes == 0) return '0'
   var k = 1000,
       dm = decimals || 2,
       sizes = ['', 'K', 'M', 'B', 'T', 'P', 'E', 'Z', 'Y'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + sizes[i];
}

window.paramsToJson = function (url) {
  let params = url.split('?').reverse()[0].split('&');
  let data = {};
  params.forEach(param => {
    var [key, value] = param.split('=');
    data[key] = value;
  })
  return data;
}

window.nodeFromString = function(html) {
  var template = document.createElement('div')
  template.innerHTML = html;
  return template;
}

const app = new Vue({
    el: '#app',
    data: {
      showdashboard: false,
      showmoreclick: false,
      scrollpos: 0,
      hasScrolledOnePage: false,
      apps: [],
      users: [],
      logs: [],
      readyForDynamicContent: false
    },
    methods: {
      iconSuccess (data) {
        console.log(data);
        $('#icon-image').attr('src', data.image);
        $('#icon-image-input').val(data.path);
      },
      bannerSuccess (data) {
        $('#banner-image').attr('src', data.image);
        $('#banner-image-input').val(data.path);
      },
      apkSuccess (data) {
        $('#size').html(formatBytes(data.size));
        $('#apk-input').val(data.path);
      },
      unsignedSuccess (data) {
        $('#size').html(formatBytes(data.size));
        $('#unsigned-size').val(data.size);
        $('#unsigned-input').val(data.path);
      },
      avatarSuccess (data) {
        $('#avatar-image').attr('src', data.avatar);
      },
      storySuccess (data) {
        $('#story-image').attr('src', data.image);
        $('#story-image-input').val(data.path);
      },
      addApps(data) {
        this.apps.push.apply(this.apps, data);
      },
      addUsers(data) {
        this.users.push.apply(this.users, data);
      },
      addLogs(data) {
        this.logs.push.apply(this.logs, data);
      },
      toggleDashboard(val) {
        this.showdashboard = val;
      },
      getLogClass (level) {
        if (level === 'danger' || level === 'warning') return 'table-' + level;
        return level === 'success' ? 'text-' + level : ''
      }

    },
    mounted () {
      console.log("app mounted");
      this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
      this.hasScrolledOnePage = this.scrollpos > 32;
      window.addEventListener('scroll', (e) => {
        // console.log('scrolling');
        this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
        this.hasScrolledOnePage = this.scrollpos > 32;
      });
      $('#dashboard-content').on('scroll', (e) => {
        this.scrollpos = $('#dashboard-content').scrollTop();
        this.hasScrolledOnePage = this.scrollpos > 32;
      });
    }
});



$(".totop").on('click', function (e) {
  e.preventDefault();
  $("html, body, #dashboard-content").animate({scrollTop: 0}, 400);
});

$('.logout').on('click', function (e) {
  e.preventDefault();
  $('#logout').submit();
})

$('.locale').on('click', function (e) {
  e.preventDefault();
  $('#locale-value').val($(this).data('value'));
  // console.log($('#locale').serialize());
  $('#locale').submit();
})

$('#loadmore').on('submit', function (e) {
  e.preventDefault();
  console.log(e.target.action);
})

$('.story p br').each(function(index) {
  $(this).remove()
})

$('.story p').each(function(index) {
  if($(this).html() === '') {
    $(this).remove()
  }
})

$('#logModal').on('show.bs.modal', function(event) {
  let btn = $(event.relatedTarget);
  let level = btn.data('level');
  let message = btn.data('message');
  let data = btn.data('data');
  let method = btn.data('method');
  $(this).find('.level').html('"' + level + '"').addClass('text-' + level);
  $(this).find('.message').html('"' + message + '"');
  $(this).find('.data').html(JSON.stringify(data, null, 2));
  $(this).find('.method').html('"' + method + '"');
  console.log(level, message, data, method);
});

$("[data-toggle=popover]").popover();
$('[data-toggle="tooltip"]').tooltip();

$('[data-like]').on('click', function () {
  $(this).toggleClass('liked')
  axios.post('/action/like', {
    table: $(this).data('like'),
    uid: $(this).data('uid')
  }).then(res => {
    // console.log($(this).find('.likes'));
    console.log(res, res.data.likes, formatNum(res.data.likes));
    $(this).find('.likes').text(formatNum(res.data.likes))
  })
})

function countDown(i) {
    return new Promise((resolve, reject) => {
      var int = setInterval(function() {
          $('#time-remaining').html(i + ' seconds');
          i-- || (clearInterval(int), resolve());
      }, 1000);
    });
}

// console.log();
if ($('#download-page').length > 0) {
  $('#download-page').ready(function() {
      let el = $('#download-page');
      axios.post('/download/app', {
        uid: el.data('uid'),
        vid: el.data('vid'),
        type: el.data('type'),
        force: true
      }).then(res => {
        $('#download-status').html("Your download will start in...")
        $('#time-remaining').html('5 seconds');
        console.log(res.data);
        return countDown(5)
      }).then(() => {
        $('#time-remaining').html('loading...');
        return axios.post('/download/app', {
          uid: el.data('uid'),
          vid: el.data('vid'),
          type: el.data('type'),
          force: false
        });
      }).then(res=> {
        if(res.data.link) {
          if (res.data.isSigned) {
            $('#time-remaining').html('installing app...');
          } else {
            $('#time-remaining').html('installing duplicate...');
          }
          window.location.href = res.data.link
        } else if(res.data.download) {
          $('#time-remaining').html('downloading...');
          window.location.href = res.data.download
        }
        else {
          $('#time-remaining').html('error');
        }
      })

  })
}
