<script setup>
</script>

<template>
    <div>
        <slot />
    </div>
</template>
<style scoped lang="scss">

div{
    background: #f9f7f0;
    box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.5) inset, 0px 0px 1px 1px rgba(0,0,0,0.3);
    border: 1px solid white;


    max-width: 620px;
    width: 100%;
    margin: 50px auto;

    padding: 50px 30px;
    border-radius: 60px;
}

</style>