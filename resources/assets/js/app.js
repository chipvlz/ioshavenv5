
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

function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0 Bytes';
   var k = 1000,
       dm = decimals || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
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
      toggleDashboard(val) {
        this.showdashboard = val;
        // window.ElementQueries.init();
      }

    },
    mounted () {
      console.log("app mounted");
      this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
      this.hasScrolledOnePage = this.scrollpos > 32;
      window.addEventListener('scroll', (e) => {
        console.log('scrolling');
        this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
        this.hasScrolledOnePage = this.scrollpos > 32;
      });
      $('#dashboard-content').on('scroll', (e) => {
        console.log('scrolling');
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

$("[data-toggle=popover]").popover();
$('[data-toggle="tooltip"]').tooltip();
