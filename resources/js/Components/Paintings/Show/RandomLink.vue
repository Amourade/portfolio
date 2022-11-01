<script setup>
import Button from "./Button.vue";
</script>
<template>
    <a href="#" @click="$emit('random')"><Button>Aléatoire</Button></a>
</template>
<style lang="scss" scoped>
a {
    cursor: help;
    margin-right: 1%;
}
</style>
