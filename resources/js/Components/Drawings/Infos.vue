<script setup>
defineProps({
    drawing: Object,
    image: String,
});
</script>
<template>
    <div class="infos">
        <p>
            {{ drawing.title }} - {{ drawing.description }} -
            {{ drawing.width }} x {{ drawing.height }} - {{ drawing.date }}
        </p>
        <a target="_blank" :href="image">Fullsize</a>
    </div>
</template>
<style lang="scss" scoped>
.infos {
    display: flex;
    width: 100%;
    align-items: baseline;
    justify-content: space-between;

    gap: 10px;

    a {
        color: black;
        text-decoration: none;

        &:hover {
            color: blue;
        }
    }

    & > * {
        background: white;
        border: 1px solid black;
        padding: 5px;
        text-align: center;
    }
}
</style>
