<template>
    <div v-shortkey="['esc']" @shortkey="showLinkPicker = false; showMediaPicker = false">
        <div>
            <div class="tool__bar" role="toolbar">
                <button class="toolbutton" title="Fetter Text [B]" @click="textWrap('**', '**')" v-shortkey.once="['ctrl', 'b']" @shortkey="textWrap('**', '**')">
                    <i class="material-icons">format_bold</i>
                </button>
                <button class="toolbutton" title="Kursiver Text [I]" @click="textWrap('//', '//')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('//', '//')">
                    <i class="material-icons">format_italic</i>
                </button>
                <button class="toolbutton" title="Unterstrichener Text [U]" @click="textWrap('__', '__')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('__', '__')">
                    <i class="material-icons">format_underlined</i>
                </button>
                <button class="toolbutton" title="Überschrift 1" @click="textWrap('======', '======')">
                    <i class="material-icons">filter_1</i>
                </button>
                <button class="toolbutton" title="Überschrift 2" @click="textWrap('=====', '=====')">
                    <i class="material-icons">filter_2</i>
                </button>
                <button class="toolbutton" title="Überschrift3" @click="textWrap('====', '====')">
                    <i class="material-icons">filter_3</i>
                </button>
                <button class="toolbutton" title="Interner Link [L]" @click="showLinkPicker = true" v-shortkey.once="['ctrl', 'l']" @shortkey="showLinkPicker = true">
                    <i class="material-icons">insert_link</i>
                </button>
                <button class="toolbutton" title="Externer Link"  @click="textWrap('[[', ']]', '[[https://www.example.com|Externer Link]]')">
                    <i class="material-icons">explore</i>
                </button>
                <button class="toolbutton" title="Nummerierter Listenpunkt [-]" @click="textWrap(' - ', '', ' - Nummerierter Listenpunkt')" v-shortkey.once="['ctrl', '-']" @shortkey="textWrap(' - ', '', ' - Nummerierter Listenpunkt')">
                    <i class="material-icons">format_list_numbered</i>
                </button>
                <button class="toolbutton" title="Listenpunkt [.]" @click="textWrap(' * ', '', ' * Listenpunkt')" v-shortkey.once="['ctrl', '.']" @shortkey="textWrap(' * ', '', ' - Listenpunkt')">
                    <i class="material-icons">format_list_bulleted</i>
                </button>
                <button class="toolbutton" title="Horizontale Linie" aria-controls="wiki__text"@click="textWrap('\n----\n')">
                    <i class="material-icons">horizontal_rule</i>
                </button>
                <button class="toolbutton" title="Bilder und andere Dateien hinzufügen"  @click="showMediaPicker = true">
                    <i class="material-icons">insert_photo</i>
                </button>
                <!-- <button class="toolbutton" title="Smileys" aria-controls="picker1" aria-haspopup="true">
                    <img src="/lib/images/toolbar/smiley.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Sonderzeichen" aria-controls="picker2" aria-haspopup="true">
                    <img src="/lib/images/toolbar/chars.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Unterschrift einfügen [Y]" aria-controls="wiki__text" accesskey="y">
                    <img src="/lib/images/toolbar/sig.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Wrap-Plugin" aria-controls="picker3" aria-haspopup="true">
                    <img src="/lib/images/toolbar/../../plugins/wrap/images/toolbar/picker.png" alt="" width="
                16" height="16"></button> -->
            </div>
        </div>

        <codemirror ref="cm" v-model="text" :options="cmOptions"></codemirror>

        <div class="editor-tags mt-7">
            <input-tag v-model="tags" :before-adding="tag => tag.toLowerCase().replace(' ', '_')" placeholder="Tag hinzufügen"></input-tag>
        </div>

        <div class="mt-5 mb-3 m-auto">
            <button @click="cancel">Abbrechen</button>
            <button @click="save">Speichern</button>
        </div>

        <link-picker v-if="showLinkPicker" @select="insertLink($event); showLinkPicker = false" @close="showLinkPicker = false"/>

        <media-picker v-if="showMediaPicker" @select="insertMedia($event); showMediaPicker = false" @close="showMediaPicker = false"/>        
    </div>
</template>

<script>
import Vue from 'vue'
import VueCodemirror from 'vue-codemirror'
import VueShortkey from 'vue-shortkey'
import InputTag from 'vue-input-tag'
import axios from 'axios'
import LinkPicker from './LinkPicker.vue'
import MediaPicker from './MediaPicker.vue'

import 'codemirror/lib/codemirror.css'

Vue.use(VueCodemirror)
Vue.use(VueShortkey)

export default {
    name: 'Editor',
    components: {
        InputTag,
        LinkPicker,
        MediaPicker
    },
    data: () => ({
        text: '',
        cmOptions: {
            tabSize: 4,
            mode: 'text/javascript',
            theme: 'base16-dark',
            lineNumbers: false,
            line: false,
            lineWrapping: true
        },
        showLinkPicker: false,
        showMediaPicker: false,
        tags: [],
        pageimage: '',
        abstract: ''
    }),
    methods: {
        textWrap: function(before = '', after = '', plain = '') {
            const selection = this.$refs.cm.codemirror.getSelection()
            if (selection || !plain) {
                this.$refs.cm.codemirror.replaceSelection(before + selection + after)
            } else {
                this.$refs.cm.codemirror.replaceSelection(plain)
            }
            this.$refs.cm.codemirror.focus()
        },
        insertLink (item) {
            const selection = this.$refs.cm.codemirror.getSelection()
            const text = selection || item.title || item.name
            const link = '[[' + item.id + '|' + text  + ']]'
            this.$refs.cm.codemirror.replaceSelection(link)
        },
        insertMedia ({ item, align, size }) {
            const selection = this.$refs.cm.codemirror.getSelection()
            const text = selection || item.file
            let link = '{{:'
            link += align === 'center' || align === 'right' ? ' ' : ''
            link += item.id
            link += size ? ('?' + size) : ''
            link += align === 'center' || align === 'left' ? ' ' : ''
            link += '|' + text  + '}}'
            this.$refs.cm.codemirror.replaceSelection(link)
        },
        async cancel () {
            window.location.href = '/?id=' + window.DOKU_ID
        },
        async save () {
            const formData = new FormData()
            formData.append('content', this.text)
            formData.append('tags', JSON.stringify(this.tags))

            await axios.post('/?controller=edit&method=save&id=' + window.DOKU_ID, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            window.location.href = '/?id=' + window.DOKU_ID
        }
    },
    created () {
        
        axios.get('/?controller=edit&method=get&id=' + window.DOKU_ID)
            .then(response => {
                this.text = response.data.content || ''
                this.tags = response.data.tags || []
                this.pageimage = response.data.pageimage || ''
                this.abstract = response.data.abstract
            })

            
    }
};
</script>

<style>
.editor-tags .new-tag {
    width: unset;
    padding-top: 4px !important;
    margin-bottom: 0;
}
</style>