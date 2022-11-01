<script setup>
import { ref } from 'vue';

defineProps({
    currentPainting: Object,
    paintings: Object
})

const select = ref(null);

</script>
<template>
    <select ref="select" @change="$emit('selectChange', select.value)">
        <template v-for="(year, key) in paintings">
            <optgroup :label="year[0].date">
                <option v-for="painting in year" :selected="currentPainting.id === painting.id" :value="painting.slug">
                    {{ painting.title }} - {{ painting.description }} - {{ painting.width }} x {{ painting.height }}
                </option>
            </optgroup>
        </template>
    </select>
</template>
<style lang="scss" scoped>
select {
    border: 2px white outset;
    border-radius: 5px;
    box-shadow: 0px 0px 0px 1px #43536b;
    box-shadow: 0px 0px 0px 1px #43536b, 25px 25px 11px rgba(0, 0, 0, 0.5);

    height: 36px;
    padding-left: 5px;

    font-family: 'Times New Roman', Times, serif;
}

@media (max-width: 768px) {
    select {
        width: 100%;
        max-width: 500px;
    }
}
</style>