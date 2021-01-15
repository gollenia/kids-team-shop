<template>
    <div>
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
                <button class="toolbutton" title="Code Text [M]" aria-controls="wiki__text" accesskey="m">
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
                </button>
                <button class="toolbutton" title="Interner Link [L]" @click="showLinkPicker = true" v-shortkey.once="['ctrl', 'l']" @shortkey="showLinkPicker = true">
                    <img src="/lib/images/toolbar/link.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Externer Link" aria-controls="wiki__text">
                    <img src="/lib/images/toolbar/linkextern.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Nummerierter Listenpunkt [-]" aria-controls="wiki__text" accesskey="-">
                    <img src="/lib/images/toolbar/ol.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Listenpunkt [.]" aria-controls="wiki__text" accesskey=".">
                    <img src="/lib/images/toolbar/ul.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Horizontale Linie" aria-controls="wiki__text">
                    <img src="/lib/images/toolbar/hr.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Bilder und andere Dateien hinzufügen" aria-controls="wiki__text">
                    <img src="/lib/images/toolbar/image.png" alt="" width="16" height="16">
                </button>
                <button class="toolbutton" title="Smileys" aria-controls="picker1" aria-haspopup="true">
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
                16" height="16"></button>
            </div>
            

            <!-- <a uk-tooltip="Fett (Strg-F)" class="uk-button" @click="textWrap('**', '**')" v-shortkey.once="['ctrl', 'b']" @shortkey="textWrap('**', '**')"><i class="material-icons">format_bold</i></a>
            <a uk-tooltip="Kursiv (Strg-I)" class="uk-button" @click="textWrap('//', '//')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('//', '//')"><i class="material-icons">format_italic</i></a>
            <a uk-tooltip="Unterstrichen (Strg-U)" class="uk-button" @click="textWrap('__', '__')" v-shortkey.once="['ctrl', 'u']" @shortkey="textWrap('__', '__')"><i class="material-icons">format_underline</i></a> -->
        </div>

        <codemirror ref="cm" v-model="code" :options="cmOptions"></codemirror>
        <!-- <codemirror ref="txCodeEdit"
			              :value="page.content" 
			              :options="cmOptions"
			              @ready="onCmReady"
            			@focus="onCmFocus"
            			@input="onCmCodeChange">
  			</codemirror> -->

        <link-picker v-if="showLinkPicker" @select="insertLink($event); showLinkPicker = false"/>

        
    </div>
</template>

<script>
import Vue from 'vue'
import VueCodemirror from 'vue-codemirror'
import VueShortkey from 'vue-shortkey'
import axios from 'axios'
import LinkPicker from './LinkPicker.vue'

import 'codemirror/lib/codemirror.css'

Vue.use(VueCodemirror)
Vue.use(VueShortkey)

export default {
    name: 'Editor',
    components: {
        LinkPicker
    },
    data: () => ({ 
        // page: pageData,
        code: '',
        page: { content: 'xyz' },
        cmOptions: {
            tabSize: 4,
            mode: 'text/javascript',
            theme: 'base16-dark',
            lineNumbers: false,
            line: false,
            lineWrapping: true
        },
        showLinkPicker: false
    }),
    methods: {
        onCmCodeChange(newCode) {
        },
        textWrap: function(before, after) {
            const selection = this.$refs.cm.codemirror.getSelection()
            this.$refs.cm.codemirror.replaceSelection(before + selection + after)
            this.$refs.cm.codemirror.focus()
        },
        insertLink (item) {
            const selection = this.$refs.cm.codemirror.getSelection()
            const text = selection || item.title || item.name
            const link = '[[' + item.id + '|' + text  + ']]'
            this.$refs.cm.codemirror.replaceSelection(link);
        },
        
        // insertImage: function(id) {
        //     this.$refs.cm.codemirror.replaceSelection("{{" + id + "}}");
        // },
        
        // save: function(andReturn) {
        //     axios.post(ajaxUrl, {
        //         controller: "page",
        //         method: "save",
        //         text: this.page.content,
        //         id: this.page.id
        //     }).then(function(response) {
        //         console.log(response);
        //         document.getElementById('save').classList.remove("unsaved");
        //     }).catch(function(error){
        //         console.log(error);
        //     });
        // }
    }
};
</script>

<style>
.alert {
    background: red;
}
</style>
