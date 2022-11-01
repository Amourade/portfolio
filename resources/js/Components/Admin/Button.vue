<script setup>
</script>
<template>
    <button as="button"><slot /></button>
</template>
<style scoped lang="scss"> 
    button{
        font-size: 1.2em;
        margin: 10px;
        padding: 5px 10px;
        font-family: 'Caveat', cursive;

        border: 1px solid #797f38;
        background: #c7caa870;

        color: #3f254c;

        cursor: pointer;

        border-radius: 10px;

        box-shadow: 2px 2px 2px 0px rgba(0,0,0,0.3);

        transition: all .5s;

        &:hover{
            background: #c7caa8ad;
            box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.3);
        }
    }
</style>