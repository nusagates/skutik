/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('user-info', require('./components/UserInfo.vue').default);
Vue.component('post-content', require('./components/PostContent.vue').default);
Vue.component('comment', require('./components/Comments').default);
Vue.component('post-comment', require('./components/PostComment.vue').default);
Vue.component('post-form', require('./components/PostForm.vue').default);

const app = new Vue({
    el: '#app',
});
