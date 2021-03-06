/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./quill');

// window.Quill = require('Quill');
window.Vue = require('vue');
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

import BootstrapVue from 'bootstrap-vue'; //Importing
import Vue2Editor from "vue2-editor";
import Multiselect from 'vue-multiselect';
import Slick from 'vue-slick';

import VueFilePond from 'vue-filepond';
import FilePondPluginMediaPreview from 'filepond-plugin-media-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';

window.FilePond = VueFilePond(FilePondPluginMediaPreview, FilePondPluginFileValidateType, FilePondPluginImagePreview, FilePondPluginFileEncode);

import { ValidationProvider } from 'vee-validate/dist/vee-validate.full.esm';
import { ValidationObserver } from 'vee-validate';
// import { ImageResize } from 'quill-image-resize-module';

// Register ImageResize module
// VueQuillEditor.register('modules/imageResize', ImageResize);

Vue.use(BootstrapVue); // Telling Vue to use this in whole application
Vue.use(Vue2Editor);
Vue.use(Slick);
Vue.use(Multiselect);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('create-article-component', require('./components/CreateArticleComponent.vue').default);
Vue.component('slug-widget', require('./components/SlugWidget.vue').default);
Vue.component('multiselect', Multiselect);
Vue.component('slick', Slick);
// Vue.component('article-banner', require('./components/ArticleBannerComponent.vue').default);
// Vue.component('text-editor', require('./components/TextEditor.vue').default);
// Vue.component('ValidationProvider', ValidationProvider);
// Vue.component('ValidationObserver', ValidationObserver);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
