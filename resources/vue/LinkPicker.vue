<template>
    <modal title="Seite wählen" @close="$emit('close')">
        <div class="p-4" v-if="tree">
            <link-picker-item
                v-for="(item, i) in tree"
                :key="i"
                :item="item"
                @select="$emit('select', $event)"
            />
        </div>
        <div class="p-4" v-else>
            Wird geladen..
        </div>
        <div class="bg-lightgray-lighter">
            <div class="px-4 py-8 input-text">
            <label>Link-Text</label>
            <input type="text" v-model="title">
        </div>
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
        title: ""
    }),
    async created () {
      const response = await axios.get('/?controller=edit&method=tree')
      this.tree = response.data.tree
    }
};
</script>
