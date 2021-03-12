<template>
    <div v-if="item.folder" class="link-folder">
        <div class="text-gray flex items-center relative" @click="expanded = !expanded">
            <span class="link-folder-icon cursor-pointer"><i class="material-icons">{{ expanded ? 'arrow_drop_down' : 'arrow_right' }}</i></span>
            <span class="link-folder-icon cursor-pointer absolute ml-6"><i class="material-icons">folder</i></span>
            <span class="pl-8 text-sm">{{ item.title || item.name }}</span>
        </div>
        <ul v-if="expanded && item.children.length > 0">
            <li v-for="(child, c) in item.children" :key="c">
                <link-picker-item :item="child" @select="$emit('select', $event)"/>
            </li>
        </ul>
    </div>
    <div v-else class="text-darkgray link-item flex items-center relative" @click="$emit('select', item)">
        <span class="link-folder-icon cursor-pointer absolute"><i class="material-icons">text_snippet</i></span>
        <span class="pl-8 text-sm">{{ item.title || item.name }}</span>
    </div>
</template>

<script>
export default {
    name: 'LinkPickerItem',
    props: {
        item: Object
    },
    data: () => ({
        expanded: false
    })
}
</script>

<style>
.link-folder ul,
.link-item {
    padding-left: 24px;
    list-style-type: none;
}
.link-folder-icon {
    display: inline-block;
    width: 24px;
}
.link-item {
    cursor: pointer;
}
</style>