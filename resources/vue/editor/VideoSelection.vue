<template>
    <modal title="Youtube-Video einfügen" @close="$emit('close')">
        <div class="p-10">
            <div class="input-text">
                <label class="label">Video Url</label>
                <input type="text" v-model="videoUrl">
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
        videoUrl: ""
    }),
    methods: {
        save () {
            var video_id = this.videoUrl.split('v=')[1];
            var ampersandPosition = video_id.indexOf('&');
            if(ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
            }
            this.$emit('select', {
                videoID: video_id
            })
            this.$emit('close');
        }
    }
};
</script>
