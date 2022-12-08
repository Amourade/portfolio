<script setup></script>
<template>
    <span>
        <slot />
    </span>
</template>
<style lang="scss" scoped>
@import "Css/painting-variables.scss";
span {
    display: inline-block;

    color: white;
    font-size: 1em;
    line-height: 1em;
    border: 2px white outset;
    border-radius: 5px;
    box-shadow: 0px 0px 0px 1px #43536b, 25px 25px 15px rgba(0, 0, 0, 0.5);
    text-shadow: 0px 0px 2px #000000;
    background: $buttonBaseColor;

    padding: 10px;

    text-decoration: none;

    &:hover {
        background: $buttonHoverColor;
    }
}
</style>
