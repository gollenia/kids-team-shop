<template>
    <modal title="Seite wählen" @close="$emit('close')">
        <div v-if="tree">
            <link-picker-item
                v-for="(item, i) in tree"
                :key="i"
                :item="item"
                @select="$emit('select', $event)"
            />
        </div>
        <div v-else>
            Wird geladen..
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
        tree: null
    }),
    async created () {
      const response = await axios.get('/?controller=index&method=tree')
      this.tree = response.data.tree
    }
};
</script>
