<template>
    <modal title="Media Manager" box-class="max-w-4xl" @close="$emit('close')">
        <div class="flex space-x-4 text-left" style="min-height: 400px">
            <div class="flex-1 p-4 border-r border-gray-200">
                <media-picker-item
                    v-for="(item, i) in tree"
                    :key="i"
                    :item="item"
                    :selected="ns"
                    @select="onTreeSelect"
                />
            </div>
            
            <div style="flex: 1.5">
                <div
                    v-for="(item, i) in list"
                    :key="i"
                    class="media-file"
                    @click="file = item"
                    @dblclick="select(item)"
                >
                    <span><img v-if="item.src" :src="item.src"/></span>
                    <span class="overflow-clip text-sm overflow-hidden flex-grow">{{ item.file }}</span>
                    <span><button class="block m-auto" @click="$emit('delete', item)"><i class="text-gray-400 text-sm material-icons">delete</i></button></span>
                </div>
            </div>

            <div class="flex-1 p-4 border-l border-gray-200 flex flex-col">
                
                <div class="flex-grow" v-if="file && file.src">
                    <img :src="file.src" class="block m-auto mb-4" style="max-width: 220px; max-height: 180px;">
                    <div class="mb-4">
                        Ausrichtung:<br>
                        <img src="/lib/images/media_align_noalign.png" alt="Keine" title="Keine" class="inline w-6 h-6 ml-1" :class="{ border: align === '' }" @click="align = ''">
                        <img src="/lib/images/media_align_left.png" alt="Links" title="Links" class="inline w-6 h-6 ml-1" :class="{ border: align === 'left' }" @click="align = 'left'">
                        <img src="/lib/images/media_align_center.png" alt="Mitte" title="Mitte" class="inline w-6 h-6 ml-1" :class="{ border: align === 'center' }" @click="align = 'center'">
                        <img src="/lib/images/media_align_right.png" alt="Rechts" title="Rechts" class="inline w-6 h-6 ml-1" :class="{ border: align === 'right' }" @click="align = 'right'">
                    </div>
                    <div class="mb-4">
                        Grösse:<br>
                        <img src="/lib/images/media_size_small.png" alt="Klein" title="Klein" class="inline w-4 h-4 ml-2" :class="{ border: size === '200' }" @click="size = '200'">
                        <img src="/lib/images/media_size_medium.png" alt="Mittel" title="Mittel" class="inline w-4 h-4 ml-2" :class="{ border: size === '400' }" @click="size = '400'">
                        <img src="/lib/images/media_size_large.png" alt="Gross" title="Gross" class="inline w-4 h-4 ml-2" :class="{ border: size === '600' }" @click="size = '600'">
                        <img src="/lib/images/media_size_original.png" alt="Original" title="Original" class="inline w-4 h-4 ml-2" :class="{ border: size === '' }" @click="size = ''">
                    </div>
                </div>
                <div v-if="file">
                    <div><button class="block border m-auto" @click="select(file)">Einfügen</button></div>
                    
                </div>
            </div>
            
        </div>
        
        <div class="p-4 bg-gray-200">
            Hochladen: 
            <input type="file" @change="fileInput = $event.target.files || $event.dataTransfer.files">
            <button v-show="fileInput" class="border" @click="upload">Upload</button>
            <div v-show="fileInput" class="input-text"><label>Namespace</label><input v-model="ns" type="text"></div>
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
        ns: '',
        tree: null,
        list: null,
        file: null,
        align: '',
        size: '',
        fileInput: null
    }),
    methods: {
        onTreeSelect (item) {
            this.ns = item.id
            this.list = null
            this.load(false)
        },
        select (item) {
            this.$emit('select', {
                item,
                align: this.align,
                size: this.size
            })
        },
        async load (tree = true) {
            if (tree) {
                const treeResponse = await axios.get('/?controller=media&method=tree')
                this.tree = treeResponse.data.tree
            }
            const listResponse = await axios.get('/?controller=media&method=list&ns=' + this.ns)
            this.list = listResponse.data
        },
        async upload () {
            const sec_response = await axios.post('/?controller=media&method=token');
            var sectok = sec_response.data
            const file = this.fileInput[0]
            const formData = new FormData()
            formData.append('upload', file, file.name)
            formData.append('sectok', sectok)

            const response = await axios.post('/?controller=media&method=upload&id=' + this.ns, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            console.log(response);
            return this.load()
        },
        async delete(item) {
            await axios.delete('/?controller=media&method=delete&id=' + item.id)
            return this.load()
        }
    },
    created () {
        const nsStart = window.DOKU_ID.indexOf(':start')
        this.ns = nsStart > -1 ? window.DOKU_ID.substr(0, nsStart) : window.DOKU_ID
        this.load()
    }
};
</script>

<style scoped>
.media-file {
    cursor: pointer;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    padding: 5px 0;
}
.media-file >>> span:first-child {
    width: 60px;
    padding-right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.media-file img {
    max-width: 48px;
    max-height: 48px;
}
</style>