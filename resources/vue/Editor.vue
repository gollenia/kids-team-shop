<template>
    <div v-shortkey="['esc']" @shortkey="showLinkPicker = false; showMediaPicker = false">
        <div>
            <div class="tool__bar" role="toolbar">
                <button class="toolbutton" title="Fetter Text [B]" @click="textWrap('**', '**')" v-shortkey.once="['ctrl', 'b']" @shortkey="textWrap('**', '**')">
                    <img src="/lib/images/toolbar/bold.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Kursiver Text [I]" @click="textWrap('//', '//')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('//', '//')">
                    <img src="/lib/images/toolbar/italic.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Unterstrichener Text [U]" @click="textWrap('__', '__')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('__', '__')">
                    <img src="/lib/images/toolbar/underline.png" alt="" width="16" height="16">
                </button>
                <!-- <button class="toolbutton" title="Code Text [M]" aria-controls="wiki__text" accesskey="m">
                    <img src="/lib/images/toolbar/mono.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Durchgestrichener Text [D]" aria-controls="wiki__text" accesskey="d">
                    <img src="/lib/images/toolbar/strike.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Überschrift auf selber Ebene [8]" aria-controls="wiki__text" accesskey="8">
                    <img src="/lib/images/toolbar/hequal.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Überschrift eine Ebene runter [9]" aria-controls="wiki__text" accesskey="9">
                    <img src="/lib/images/toolbar/hminus.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Überschrift eine Ebene höher [0]" aria-controls="wiki__text" accesskey="0">
                    <img src="/lib/images/toolbar/hplus.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton pk_hl" title="Wähle eine Überschrift" aria-controls="picker0" aria-haspopup="true">
                    <img src="/lib/images/toolbar/h.png" alt="" width="16" height="16">
                </button> -->
                <button class="toolbutton" title="Überschrift 1" @click="textWrap('======', '======')">
                    <img src="/lib/images/toolbar/h1.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Überschrift 2" @click="textWrap('=====', '=====')">
                    <img src="/lib/images/toolbar/h2.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Überschrift3" @click="textWrap('====', '====')">
                    <img src="/lib/images/toolbar/h3.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Interner Link [L]" @click="showLinkPicker = true" v-shortkey.once="['ctrl', 'l']" @shortkey="showLinkPicker = true">
                    <img src="/lib/images/toolbar/link.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Externer Link"  @click="textWrap('[[', ']]', '[[https://www.example.com|Externer Link]]')">
                    <img src="/lib/images/toolbar/linkextern.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Nummerierter Listenpunkt [-]" @click="textWrap(' - ', '', ' - Nummerierter Listenpunkt')" v-shortkey.once="['ctrl', '-']" @shortkey="textWrap(' - ', '', ' - Nummerierter Listenpunkt')">
                    <img src="/lib/images/toolbar/ol.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Listenpunkt [.]" @click="textWrap(' * ', '', ' * Listenpunkt')" v-shortkey.once="['ctrl', '.']" @shortkey="textWrap(' * ', '', ' - Listenpunkt')">
                    <img src="/lib/images/toolbar/ul.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Horizontale Linie" aria-controls="wiki__text"@click="textWrap('\n----\n')">
                    <img src="/lib/images/toolbar/hr.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Bilder und andere Dateien hinzufügen"  @click="showMediaPicker = true">
                    <img src="/lib/images/toolbar/image.png" alt="" width="16" height="16">
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

        <button class="my-3" @click="save">Speichern</button>

        <link-picker v-if="showLinkPicker" @select="insertLink($event); showLinkPicker = false" @close="showLinkPicker = false"/>

        <media-picker v-if="showMediaPicker" @select="insertMedia($event); showMediaPicker = false" @close="showMediaPicker = false"/>        
    </div>
</template>

<script>
import Vue from 'vue'
import VueCodemirror from 'vue-codemirror'
import VueShortkey from 'vue-shortkey'
import axios from 'axios'
import LinkPicker from './LinkPicker.vue'
import MediaPicker from './MediaPicker.vue'

import 'codemirror/lib/codemirror.css'

Vue.use(VueCodemirror)
Vue.use(VueShortkey)

export default {
    name: 'Editor',
    components: {
        LinkPicker,
        MediaPicker
    },
    data: () => ({
        pageId: '',
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
        showMediaPicker: false
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
        insertMedia (item) {
            const selection = this.$refs.cm.codemirror.getSelection()
            const text = selection || item.file
            const link = '{{:' + item.id + '|' + text  + ']]'
            this.$refs.cm.codemirror.replaceSelection(link)
        },
        async save () {
            const formData = new FormData()
            formData.append('text', this.text)
            
            await axios.post('/?controller=page&method=save&id=' + this.pageId, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })

            // TODO: redirect back to view?
        }
    },
    created () {
        // TODO: simpler way to access page id?
        const urlParams = new URLSearchParams(window.location.search)
        this.pageId = urlParams.get('id')

        axios.get('/?controller=page&method=raw&id=' + this.pageId)
            .then(response => {
                this.text = response.data
            })
    }
};
</script>

<style>
.alert {
    background: red;
}
</style>
