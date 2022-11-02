<script setup>
import { onMounted, ref } from "vue";
defineProps({
    painting: Object,
});

const selected = ref(false);
const loaded = ref(false);
const notMounted = ref(true);

onMounted(() => {
    notMounted.value = false;
});
</script>

<template>
    <a
        :class="{ selected: selected, loaded: loaded, notMounted: notMounted }"
        @click.prevent="$emit('navigate', painting.slug)"
        @click.once="selected = true"
        :href="painting.slug"
    >
        <img
            :alt="painting.title"
            :src="painting.image"
            width="100"
            height="100"
            @load="loaded = true"
        />
    </a>
</template>
<style lang="scss" scoped>
a {
    display: block;
    cursor: pointer;

    opacity: 0;

    transition: opacity 1s;

    &.loaded,
    &.notMounted {
        opacity: 1;
    }
    &.selected {
        img {
            border-color: #46573f;
            box-shadow: none;
        }
    }

    img {
        border: 2px white outset;
        box-shadow: 0px 0px 0px 2px #43536b;
        background-color: white;
        border-radius: 5px;
        object-fit: cover;

        &:hover {
            border-color: #46573f;
            box-shadow: 0px 0px 0px 2px #43536b;
        }
    }
}
</style>
