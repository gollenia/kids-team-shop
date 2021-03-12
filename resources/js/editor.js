import Vue from 'vue'
import Editor from '../vue/editor/Editor.vue'


if(document.getElementById('vue-editor')) {
  new Vue({
    el: '#vue-editor',
    render: h => h(Editor)
  })
}