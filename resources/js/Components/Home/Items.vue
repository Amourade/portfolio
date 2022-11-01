<script setup>
import Item from "./Item.vue";
defineProps({
    Items: Object
})

</script>

<template>
    <Item v-for="(item, key) in Items" :key="key" :item="item" ></Item>
</template>