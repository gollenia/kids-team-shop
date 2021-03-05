<template>
    <div class="bg-gray-100" v-shortkey="['esc']" @shortkey="showLinkPicker = false; showMediaPicker = false; showPageImagePicker = false">
         <header class="bg-secondary relative" style="padding-top: 20vh;">
            <img class="object-cover absolute inset-0 w-full h-full" v-if="media.src != '/_media/'" :src="media.src">
            <div class="absolute bottom-0 right-0 text-right p-4">
            <button class="bg-lightgray text-black mr-4" @click="showPageImagePicker = true"><i class="material-icons">image</i></button>
            <button class="bg-lightgray text-black" @click="pageimage = ''"><i class="material-icons">delete</i></button>
            </div>
        <div class="max-w-screen-xl mx-auto">        
        <div class="relative inline-block bg-primary-transparent bg-opacity-75 bg-blur  rounded-tr-3xl text-white text-right" style="margin-left: -2000px; padding: 50px 50px 50px 2000px;">
            <div class="text-3xl ml-4 lg:ml-0 lg:text-5xl xl:mr-0 font-script pl-4 md:pl-8 xl:pl-0">
                {{page.title}}
            </div>
        </div>
        </div>
        </header>
                
        <pageimage-picker v-if="showPageImagePicker" @select="insertPageImage($event); showPageImagePicker = false" @close="showPageImagePicker = false"/>

        <div class="max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8">
            
            <div class="input-text">
                <label>Titel</label>
                <input type="text" class="w-full border-2 outline-none" v-model="page.title" required>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8">
            
            <div class="input-select">
                <label>Vorlage</label>
                <select type="text" class="w-full border-2 outline-none" v-model="page.template" required>
                    <option v-for="(template, c) in templates" :value="template.id" v-text="template.title" :key="c"></option>
                </select>
            </div>
        </div>

        <div class="editor max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8">
            <div class="mt-4 px-4 bg-gray-200 rounded-tl-md">
                <div class="tool__bar" role="toolbar">
                    <button class="toolbutton button" title="Fetter Text [B]" @click="textWrap('**', '**')" v-shortkey.once="['ctrl', 'b']" @shortkey="textWrap('**', '**')">
                        <i class="material-icons">format_bold</i>
                    </button>
                    <button class="toolbutton button" title="Kursiver Text [I]" @click="textWrap('//', '//')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('//', '//')">
                        <i class="material-icons">format_italic</i>
                    </button>
                    <button class="toolbutton button" title="Unterstrichener Text [U]" @click="textWrap('__', '__')" v-shortkey.once="['ctrl', 'i']" @shortkey="textWrap('__', '__')">
                        <i class="material-icons">format_underlined</i>
                    </button>
                    <button class="toolbutton button" title="Überschrift 1" @click="textWrap('======', '======')">
                        <i class="material-icons">filter_1</i>
                    </button>
                    <button class="toolbutton button" title="Überschrift 2" @click="textWrap('=====', '=====')">
                        <i class="material-icons">filter_2</i>
                    </button>
                    <button class="toolbutton button" title="Überschrift3" @click="textWrap('====', '====')">
                        <i class="material-icons">filter_3</i>
                    </button>
                    <button class="toolbutton button" title="Interner Link [L]" @click="showLinkPicker = true" v-shortkey.once="['ctrl', 'l']" @shortkey="showLinkPicker = true">
                        <i class="material-icons">insert_link</i>
                    </button>
                    <button class="toolbutton button" title="Externer Link"  @click="textWrap('[[', ']]', '[[https://www.example.com|Externer Link]]')">
                        <i class="material-icons">explore</i>
                    </button>
                    <button class="toolbutton button" title="Nummerierter Listenpunkt [-]" @click="textWrap(' - ', '', ' - Nummerierter Listenpunkt')" v-shortkey.once="['ctrl', '-']" @shortkey="textWrap(' - ', '', ' - Nummerierter Listenpunkt')">
                        <i class="material-icons">format_list_numbered</i>
                    </button>
                    <button class="toolbutton button" title="Listenpunkt [.]" @click="textWrap(' * ', '', ' * Listenpunkt')" v-shortkey.once="['ctrl', '.']" @shortkey="textWrap(' * ', '', ' - Listenpunkt')">
                        <i class="material-icons">format_list_bulleted</i>
                    </button>
                    <button class="toolbutton button" title="Horizontale Linie" aria-controls="wiki__text"@click="textWrap('\n----\n')">
                        <i class="material-icons">horizontal_rule</i>
                    </button>
                    <button class="toolbutton button" title="Bilder und andere Dateien hinzufügen"  @click="showMediaPicker = true">
                        <i class="material-icons">insert_photo</i>
                    </button>
                    <button class="toolbutton button" title="Bilder und andere Dateien hinzufügen"  @click="showBiblePicker = true">
                        <i class="material-icons">menu_book</i>
                    </button>
                </div>
            </div>

            <codemirror class="border-r-2 border-l-2 border-b-2 p-4 rounded-br-md bg-white" ref="cm" v-model="page.content" :options="cmOptions" @keyHandled="cmOnKeyHandle($event)"></codemirror>
        </div>

        <div class="input-text max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8">
            
            <div class="editor-tags">
                <label>Zusammenfassung</label>
                <textarea class="w-full border-2 border-lightgray rounded-tl-md p-4 rounded-br-md outline-none" v-model="page.abstract"></textarea>
            </div>
        </div>
        
        
        
        <div class="input-text max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8">
            
            <div class="editor-tags input-text">
                <label>Schlagworte</label>
                <input-tag v-model="page.tags" :before-adding="tag => tag.toLowerCase().replace(' ', '_')" placeholder="Tag hinzufügen"></input-tag>
            </div>
        </div>

        <div class="bg-primary-light">
            <div class="max-w-screen-xl mx-auto px-4 md:px-8 xl:px-0 py-8 text-right">
                <button class="bg-primary-light text-primary" @click="cancel">Zurück</button>
                <button @click="save">Speichern</button>
            </div>
        </div>
        

        <link-picker v-if="showLinkPicker" @select="insertLink($event); showLinkPicker = false" @close="showLinkPicker = false"/>

        <bible-picker v-if="showBiblePicker" @select="insertBible($event); showBiblePicker = false" @close="showBiblePicker = false"/>

        <media-picker v-if="showMediaPicker" @select="insertMedia($event); showMediaPicker = false" @close="showMediaPicker = false"/>
    </div>
</template>

<script>
import Vue from 'vue'
import VueCodemirror from './codereflector'
import VueShortkey from 'vue-shortkey'
import InputTag from 'vue-input-tag'
import axios from 'axios'
import LinkPicker from './LinkPicker.vue'
import BiblePicker from './BiblePicker.vue'
import MediaPicker from './MediaPicker.vue'
import PageimagePicker from './PageimagePicker.vue'

import 'codemirror/lib/codemirror.css'

Vue.use(VueCodemirror, {events: ["keyHandled"]})
Vue.use(VueShortkey)

export default {
    name: 'Editor',
    components: {
        InputTag,
        LinkPicker,
        MediaPicker,
        BiblePicker,
        PageimagePicker
    },
    data: () => ({
        cmOptions: {
            tabSize: 4,
            mode: {
                name: 'tiki'
            },
            
            lineNumbers: false,
            line: false,
            lineWrapping: true
        },
        showLinkPicker: false,
        showMediaPicker: false,
        showPageImagePicker: false,
        showBiblePicker: false,
        templates: [],
        page: {
            abstract: "",
            content: "",
            date: "",
            template: "",
            id: "start",
            minor_change: false,
            pageimage: "",
            summary: "",
            tags: [],
            title: "",
            user: ""
        },
        media: {
            extension: "",
            file: "",
            id: "",
            modified: "",
            path: "",
            size: "",
            src: "",
            thumbnail: "",
            writable: false
        }
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
        insertLink ({ item, title }) {
            const selection = this.$refs.cm.codemirror.getSelection()
            const text = title || selection || item.title || item.name
            const link = '[[' + item.id + '|' + text  + ']]'
            this.$refs.cm.codemirror.replaceSelection(link)
        },
        insertBible ( {item}) {
            const selection = this.$refs.cm.codemirror.getSelection()
            var verse = item.book.short_name + ":" + item.chapter + "," + item.verses.join(';')
            var title = item.book.long_name + " " + item.chapter + "," + item.verses.join(';')
            if(selection) {
                title = selection
            }
            this.$refs.cm.codemirror.replaceSelection("<bible " + verse + ">" + title + "</bible>")
        },
        cmOnKeyHandle(event) {
            if(event[1] === "Enter") {
                this.newLine();
                console.log("newLine");
            }
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
        insertPageImage ({ item }) {
            this.page.pageimage = item.id || ''
            axios.get('/?controller=media&method=get&id=' + this.page.pageimage)
            .then(response => {
                this.media = response.data
            });
        },
      
        newLine() {
            var lastLine = this.$refs.cm.codemirror.getCursor()
            
            var lastLineContent = this.$refs.cm.codemirror.getLine(lastLine.line - 1);
            console.log(lastLineContent);
            if (lastLineContent.match(/\s{2,}\*\s/g)) {
                this.$refs.cm.codemirror.replaceSelection("* ")
            }
            if (lastLineContent.match(/\s{2,}\-\s/g)) {
                this.$refs.cm.codemirror.replaceSelection("- ")
            }
        },
        async cancel () {
            window.location.href = '/?id=' + window.DOKU_ID;
        },
        async save () {
            const formData = new FormData()
            formData.append('page', JSON.stringify(this.page))

            await axios.post('/?controller=edit&method=save&id=' + window.DOKU_ID, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        }
    },
    async created () {
        await axios.get('/?controller=edit&method=get&id=' + window.DOKU_ID)
            .then(response => {
                this.page = response.data
        });

        axios.get('/?controller=media&method=get&id=' + this.page.pageimage)
            .then(response => {
                this.media = response.data
        });

        axios.get('/?controller=edit&method=list&id=system:templates')
            .then(response => {
                this.templates = response.data
        });
    }
};
</script>