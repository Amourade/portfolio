<script setup></script>
<template>
    <span>Chargement/Loading</span>
</template>
<style lang="scss" scoped>
@import "Css/painting-variables.scss";

span {
    display: inline-block;
    font-size: 1.5em;
    background: $titleBaseColor;
    color: white;
    padding: 15px;
    border: 2px white outset;
    text-shadow: 0px 0px 2px #000000;
    border-radius: 5px;
    box-shadow: 0px 0px 0px 1px #43536b, 25px 25px 15px rgba(0, 0, 0, 0.5);

    animation: loading 1s infinite;
}

@keyframes loading {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
