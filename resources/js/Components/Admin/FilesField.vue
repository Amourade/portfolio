<script>
export default {
    inheritAttrs: false
}
</script>
<script setup>
import { defineProps, onMounted, useAttrs, watch } from 'vue';
import File from './File.vue';
import Button from './Button.vue';

const attrs = useAttrs();
const props = defineProps({
    name: {
        type: String,
        default: "Images"
    },
    min: {
        type: Number,
        default: 1
    }
})

function addImage(args){
    attrs.images.push(Object.assign({
        order: 0,
        image: null,
        isNew: false,
        isDeleted: false
    }, args));
}

watch(attrs.images, function(){
    let order = 0;
    for(var i = 0; i < attrs.images.length; i++){
        if(!attrs.images[i].isDeleted){
            attrs.images[i].order = order;
            order++
        }
    }
    
    if(order < props.min){
        addImage({order: order});
    }
});

onMounted(()=>{
    if(attrs.images.length == 0){
        addImage();
    }
})

</script>
<template>
    <div class="wrapper">  
        <h2>{{props.name}}</h2>
        <div class="files-holder">
            <template v-for="(item, index) in attrs.images" :key="index">
            <File
                v-if="!attrs.images[index].isDeleted"

                v-model="attrs.images[index]"
                :name="`image-${index}`"
                :previous-image="attrs.images[index].image"
                :progress="attrs.progress"
                :error="attrs.errors[`images.${index}.image`]"
                :required="false"
            />
            </template>
        </div>
        <Button @click.prevent="addImage">Add Image</Button>
    </div>
</template>

<style scoped>

    h2{
        margin-top: 15px;
        font-size: 1.8em;
    }

    .files-holder{
        display: grid;
        grid-template-columns: calc(33.3% - 6.6px) calc(33.3% - 6.7px) calc(33.3% - 6.6px);
        column-gap: 10px;
        row-gap: 10px;
        margin: 10px 0;
    }

    .wrapper{
        margin-bottom: 20px;
    }
</style>