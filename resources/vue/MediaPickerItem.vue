<template>
    <div class="media-folder">
        <div class="flex items-center" :class="{ selected: selected === item.id }">
            <span v-if="item.id && item.children" class="icon" @click="expanded = !expanded"><i class="material-icons">{{ expanded ? 'arrow_drop_down' : 'arrow_right' }}</i></span>
            <span v-else-if="item.id" class="icon"></span>
            <span class="text-sm" @click="$emit('select', item)">{{ item.title }}</span>
        </div>
        <ul v-if="expanded">
            <li v-for="(child, c) in item.children" :key="c">
                <media-picker-item :item="child" :selected="selected" @select="$emit('select', $event)"/>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'MediaPickerItem',
    props: {
        item: Object,
        selected: String
    },
    data: () => ({
        expanded: false
    }),
    methods: {
        // Obsolete? Title is given my item Object
        getItemName (id) {
            if (!id) return 'root'
            const lastColon = id.lastIndexOf(':')
            return lastColon > -1 ? id.substr(lastColon + 1) : id
        }
    },
    created () {
        if (!this.item.id) {
            // auto-expand root
            this.expanded = true
        } else if (this.selected && this.selected.indexOf(this.item.id) > -1) {
            // auto-expand current path
            this.expanded = true
        }
    }
}
</script>

<style>
.media-folder {
    cursor: pointer;
}
.media-folder ul {
    padding-left: 20px;
    list-style-type: none;
}
.media-folder .icon {
    display: inline-block;
    width: 20px;
}
.media-folder .selected {
    font-weight: bold;
}
</style>