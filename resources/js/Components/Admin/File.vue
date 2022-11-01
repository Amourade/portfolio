<script>
export default {
    inheritAttrs: false
}
</script>
<script setup>
import { onMounted, ref } from "vue";
import { useAttrs } from "vue";
import Button from "./Button.vue";

const attrs = useAttrs();
const props = defineProps({
    name: String,
    previousImage: {
        default: null
    },
    error: {
        type: String,
        default: null
    },
    required: {
        type: Boolean,
        default: true
    },
    progress: {
        type: Object,
        default: null
    }
})


const emit = defineEmits(['update:modelValue', 'removeField']);
const thumbnail = ref(false);

function handleInput(event){
    emit('update:modelValue',  Object.assign(attrs.modelValue, {image: event.target.files[0], isNew: true, isDeleted: false})/* {image: event.target.files[0]} */)
    createImage(event.target.files[0])
}

function emptyImage(){
    emit('update:modelValue', Object.assign(attrs.modelValue, {image: null}));
    thumbnail.value = false;

}

function createImage(file) {
    let reader = new FileReader();

    reader.onload = (e) => {
        thumbnail.value = e.target.result;
    };
    reader.readAsDataURL(file);
}

function removeField(){
    emit('update:modelValue', {isDeleted: true, image: attrs.modelValue.originalImage});
}

onMounted(()=>{
    if(props.previousImage){
        thumbnail.value = props.previousImage;
    }
    
});

</script>
<template>

    <div class="input-holder">
        <div class="input">
            <div class="file" :class="{ new: !thumbnail }" >
                <label :for="props.name">Upload Image</label>
                <input
                    v-bind="$attrs"
                    :name="props.name"
                    :id="props.name"
                    @input="handleInput"
                    type="file"
                    :required="props.required"
                />
            </div>

            <img v-if="thumbnail" :src="thumbnail" :alt="name" width="150" height="150" />
        </div>

        <div class="buttons">
            <Button @click.prevent="emptyImage">Remove</Button>
            <Button @click.prevent="removeField">Delete</Button>
        </div>

        <div v-if="props.error" class="error">{{ props.error }}</div>

        <progress v-if="props.progress" :value="props.progress.percentage" max="100">
            {{ props.progress.percentage }}%
        </progress>
    </div>

</template>

<style lang="scss" scoped>

.input-holder{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-evenly;

    background: rgba(255,255,255,0.6);
    border-radius: 10px;
    border: 1px solid #bdc09f;
    box-shadow: 3px 3px 3px 0px rgba(0,0,0,0.4), 0px 0px 1px 1px rgba(0,0,0,0.2);

    padding: 15px;

    transition: all 0.5s;
    &:hover{
        background: rgba(255,255,255,0.8);
        box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.4), 0px 0px 1px 1px rgba(0,0,0,0.2);
    }
}

img{
    object-fit: cover;

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

.input{
    width: 100%;
    overflow: hidden;
    border-radius: 5px;

    min-height: 150px;

    display: flex;
    border: 1px solid rgba(0,0,0, 0.2);
    justify-content: center;
}

.file{
    position: absolute;
    width: 100%;
    height: 100%;
    background: transparent;

    padding: 5px;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 2;
    transition: all .5s;

    label{
        display: block;
        background: #001e9e;
        padding: 10px;
        border-radius: 15px;
        text-align: center;
        font-size: 1.2em;
        //text-transform: uppercase;
        color: white;
        //font-weight: 700;
        cursor: pointer;

        opacity: 0;

        box-shadow: 3px 3px 3px 0px rgba(0,0,0,0.6);

        transition: all .5s;

        &:hover{
            box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.6);
        }
    }

    input{
        position:absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        cursor: pointer;
    }

    

    &:hover, &.new{
        opacity: 1;
        background-color: rgba(85, 114, 239, 0.5);

        label{
            opacity: 1;
        }
    }
}

.buttons{
    margin-top: 10px;
    text-align: center;
}

button{
    //width: 100%;
    margin: 10px 5px 0px 5px;
}

</style>
