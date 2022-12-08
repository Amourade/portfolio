<script setup>
import Button from "./Button.vue";
</script>
<template>
    <a @click.prevent="$emit('changePage', '/')" href="/">
        <Button>X</Button>
    </a>
</template>
<style lang="scss" scoped>
@import "Css/painting-variables.scss";

a {
    position: absolute;
    display: block;
    top: 1%;
    right: 1%;
    width: 7%;
    text-align: center;
    text-shadow: 1px 2px 2px #000000;

    max-width: 49px;
    height: 49px;

    z-index: 7;
}

@media (max-width: 768px) {
    a {
        max-width: 60px;
        height: 60px;

        top: 0;
        right: 0;

        margin: 1%;
    }
}

span {
    font-family: "ferrum";

    width: 100%;
    height: 100%;

    padding: 0px;

    font-size: 1.5em;
    line-height: 1.8em;
}

@media (max-width: 768px) {
    span {
        font-size: 1.8em;
        line-height: 1.7em;
    }
}
</style>
