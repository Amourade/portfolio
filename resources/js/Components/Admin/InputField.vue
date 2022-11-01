<script setup>
defineProps({
    name: {
        type: String,
        default: null
    },
    error: {
        type: String,
        default: null
    }
})

</script>

<template>

    <div class="input-wrapper">
        <label v-if="name !== null" :for="name">{{ name }}</label>
        <slot />

        <div v-if="error" class="error">{{ error }}</div>
    </div>

</template>

<style lang="scss" scoped>

label{
    font-size: 1.4em;

    text-transform: capitalize;
    margin-bottom: 10px;
}

.error{
    padding: 5px;
    font-size: 1.1em;
    margin-top: 10px;
    background: rgb(255, 255, 255);
    border-radius: 25px;
    border: 1px solid rgba(0,0,0,0.2);
    text-align: center;
}

.input-wrapper{
    display: flex;
    flex-direction: column;

    margin-bottom: 20px;
}

</style>