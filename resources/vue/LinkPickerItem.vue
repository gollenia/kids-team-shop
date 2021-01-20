<template>
    <div v-if="item.folder" class="link-folder">
        <div @click="expanded = !expanded">
            <span class="link-folder-icon">{{ expanded ? '-' : '+' }}</span>
            <span>{{ item.title || item.name }}</span>
        </div>
        <ul v-if="expanded">
            <li v-for="(child, c) in item.children" :key="c">
                <link-picker-item :item="child" @select="$emit('select', $event)"/>
            </li>
        </ul>
    </div>
    <div v-else class="link-item" @click="$emit('select', item)">
        {{ item.title || item.name }}
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
    width: 20px;
}
.link-item {
    cursor: pointer;
    text-decoration: underline;
}
</style>