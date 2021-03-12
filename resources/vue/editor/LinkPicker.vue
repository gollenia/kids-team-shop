<template>
    <modal title="Seite wählen" @close="$emit('close')">
        <div class="p-4" v-if="tree">
            <link-picker-item
                v-for="(item, i) in tree"
                :key="i"
                :item="item"
                @select="selection = $event"
            />
        </div>
        <div class="p-4" v-else>
            Wird geladen..
        </div>
        <div class="bg-gray-100">
            <div class="px-4 py-8 input-text">
            <label>Link</label>
            <input type="text" v-model="selection.id">
            </div>
            <div class="px-4 py-8 input-text">
            <label>Link-Text</label>
            <input type="text" v-model="selection.title">
            </div>
        </div> 
        
        <div class="p-4 text-right bg-gray-200">
            <button class="button">Abbrechen</button><button class="button bg-primary" @click="save">Übernehmen</button>
        </div>
    </modal>
</template>

<script>
import axios from 'axios'
import LinkPickerItem from './LinkPickerItem.vue'
import Modal from './Modal.vue'

export default {
    name: 'LinkPicker',
    components: {
        LinkPickerItem,
        Modal
    },
    data: () => ({
        tree: null,
        selection: { id: "" },
        title: ''
    }),
    methods: {
        save () {
            this.$emit('select', {
                item: this.selection,
                title: this.title
            })
            this.$emit('close');
        }
    },
    async created () {
      const response = await axios.get('/?controller=edit&method=tree')
      this.tree = response.data.tree
    }
};
</script>
