<template>
    <div v-if="item.folder" class="folder">
        <div @click="expanded = !expanded">
            <span class="icon">{{ expanded ? '-' : '+' }}</span>
            <span>{{ item.title || item.name }}</span>
        </div>
        <ul v-if="expanded">
            <li v-for="(child, c) in item.children" :key="c">
                <link-picker-item :item="child" @select="$emit('select', $event)"/>
            </li>
        </ul>
    </div>
    <div v-else class="item" @click="$emit('select', item)">
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
.folder ul,
.item {
    padding-left: 20px;
}
.icon {
    display: inline-block;
    width: 20px;
}
.item {
    text-decoration: underline;
}
</style>