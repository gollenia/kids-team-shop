<template>
    <modal title="Media Manager" @close="$emit('close')">
        <div v-if="tree" class="flex space-x-4 mb-4">
            <div class="flex-1 pr-2" style="border-right: 1px solid #e5e7eb;">
                <media-picker-item
                    v-for="(item, i) in tree"
                    :key="i"
                    :item="item"
                    :selected="ns"
                    @select="onTreeSelect"
                />
            </div>
            
            <div class="flex-1">
                <div
                    v-for="(item, i) in list"
                    :key="i"
                    class="media-file"
                    @click="$emit('select', item)"
                >
                    <span>{{ item.file }}</span>
                    <span @click.stop="del(item)">
                        <svg class="inline w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </span>
                </div>
            </div>
        </div>
        <div v-else>
            Wird geladen..
        </div>

        <hr class="py-2">
        
        <div>
            <input type="file" @change="fileInput = $event.target.files || $event.dataTransfer.files">
            <button v-show="fileInput" @click="upload">Upload</button>
            <div v-show="fileInput">Namespace: <input v-model="ns" type="text"></div>
        </div>
    </modal>
</template>

<script>
import axios from 'axios'
import MediaPickerItem from './MediaPickerItem.vue'
import Modal from './Modal.vue'

export default {
    name: 'MediaPicker',
    components: {
        MediaPickerItem,
        Modal
    },
    data: () => ({
        tree: null,
        ns: '',
        list: null,
        fileInput: null
    }),
    methods: {
        onTreeSelect (item) {
            this.ns = item.id
            this.list = null
            this.load()
        },
        async load () {
            const treeResponse = await axios.get('/?controller=media&method=tree')
            this.tree = treeResponse.data.tree
            const listResponse = await axios.get('/?controller=media&method=list&ns=' + this.ns)
            this.list = listResponse.data
        },
        async upload () {
            const file = this.fileInput[0]
            const formData = new FormData()
            formData.append('file', file, file.name)

            const response = await axios.post('/?controller=media&method=upload&id=' + this.ns, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })

            return this.load()
        },
        async del (item) {
            await axios.delete('/?controller=media&method=delete&id=' + item.id)

            return this.load()
        }
    },
    created () {
      this.load()
    }
};
</script>

<style scoped>
.media-file {
    cursor: pointer;
}
</style>