
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

const app = new Vue({
    el: '#app',
    data: {
      showmoreclick: false,
      scrollpos: 0,
      hasScrolledOnePage: false
    },
    mounted () {
      this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
      this.hasScrolledOnePage = this.scrollpos > window.innerHeight;
      window.addEventListener('scroll', (e) => {
        this.scrollpos = window.pageYOffset || document.documentElement.scrollTop;
        this.hasScrolledOnePage = this.scrollpos > window.innerHeight;
      });
    }
});

$(".totop").on('click', function (e) {
  e.preventDefault();
  $("html, body").animate({scrollTop: 0}, 400);
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
