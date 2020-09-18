/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';
import TextareaAutosize from 'vue-textarea-autosize'

Vue.use(TextareaAutosize)
Vue.use( CKEditor );
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('user-info', require('./components/UserInfo.vue').default);
Vue.component('post-content', require('./components/PostContent.vue').default);
Vue.component('comment', require('./components/Comments').default);
Vue.component('post-form', require('./components/PostForm.vue').default);
Vue.component('challenge-item', require('./components/ChallengeItem.vue').default);
Vue.component('quiz-item', require('./components/QuizItem.vue').default);
Vue.component('todo-list', require('./components/TodoList').default);

const app = new Vue({
    el: '#app',
});
