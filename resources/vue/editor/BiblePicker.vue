<template>
    <modal title="Bibelstelle wählen" @close="$emit('close')" boxClass="sm:max-w-5xl">
        <div class="grid grid-cols-3">
            <div class="p-4">
                <h5>Buch wählen</h5>
                <ul class="list-none p-0">
                    <li @click="selection.book = item; chapters = item.chapters"  v-text="item.long_name" v-for="(item, index) in books" :key="index" v-if="item.testament == 'ot'"
                        class="text-xs bg-gray-200 hover:bg-primary hover:text-white inline-block py-0.5 px-1 m-0.5" :class="{'bg-gray-700 text-white': selection.book.id == item.id}"
                    >
                        
                    </li>
                </ul>
                <ul class="list-none p-0">
                    <li @click="selection.book = item; chapters = item.chapters"  v-text="item.long_name" v-for="(item, index) in books" :key="index" v-if="item.testament == 'nt'"
                        class="text-xs bg-gray-100 hover:bg-primary hover:text-white inline-block py-0.5 px-1 m-0.5" :class="{'bg-gray-700 text-white': selection.book.id == item.id}"
                    >
                        
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h5>Kapitel wählen</h5>
                <ul class="list-none p-0">
                    <li @click="setChapter(item)" v-text="item" v-for="(item, index) in selection.book.chapters" :key="index" class="text-xs bg-gray-200 hover:bg-primary rounded-full hover:text-white inline-block py-0.5 px-1 m-0.5"
                    :class="{'bg-gray-700 text-white': selection.chapter == item}"
                    >
                        
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h5>Vers wählen</h5>
                <ul class="list-none p-0">
                    <li @click="toogleVerse(item)" v-text="item" v-for="(item, index) in verses" :key="index" class="text-xs bg-gray-200 hover:bg-primary rounded-full hover:text-white inline-block py-0.5 px-1 m-0.5"
                    :class="{'bg-gray-700 text-white': selection.verses.includes(item)}"
                    >
                        
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-4 text-right bg-gray-200">
            <button @click="$emit('close')" class="button">Abbrechen</button><button class="button bg-primary" @click="save">Übernehmen</button>
        </div>
    </modal>
</template>

<script>
import axios from 'axios'
import Modal from '../editor/Modal.vue'

export default {
    name: 'BiblePicker',
    components: {
        Modal
    },
    data: () => ({
        books: [],
        chapters: [],
        verses: [],
        selection: { 
            book: {title: "", id: ""} ,
            chapter: 0,
            verses: []
        }        
    }),
    methods: {
        save () {
            this.$emit('select', {
                item: this.selection
            })
        },

        async setChapter(chapter) {
            this.selection.chapter = chapter;
            const response = await axios.get('?controller=bibleView&method=count_verses&book=' + this.selection.book.short_name + '&chapter=' + this.selection.chapter)
            this.verses = response.data
        },

        toogleVerse(verse) {
            if(this.selection.verses.includes(verse)) {
                delete this.selection.verses[verse];
                return;
            }
            this.selection.verses.push(verse);
        },
    },
    async created () {
      const response = await axios.get('?controller=bibleView&method=get_books')
      this.books = response.data
    }
};
</script>
