<script>
export default {
    inheritAttrs: false,
};
</script>
<script setup>
import InputField from "./InputField.vue";

const props = defineProps({
    name: String,
    error: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: "text",
    },
    required: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

function handleInput(event) {
    emit("update:modelValue", event.target.value);
}
</script>
<template>
    <InputField :name="name" :error="error">
        <input
            v-bind="$attrs"
            :name="name"
            :id="name"
            @input="handleInput"
            :value="$attrs.modelValue"
            :type="props.type"
            :required="props.required"
        />
    </InputField>
</template>

<style lang="scss" scoped>
input {
    padding: 10px;
    border-radius: 2em;

    border: 1px solid #bdc09f;
    font-family: "Caveat", cursive;

    font-size: 1.2em;

    background: rgba(255, 255, 255, 0.6);
    box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.4) inset;

    transition: all 1s;

    width: 100%;

    &:hover,
    &:focus,
    &:focus-visible {
        outline: none;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #232946;
        box-shadow: 1px 1px 1px 0px rgba(0, 0, 0, 0.2) inset;
    }
}

@media (max-width: 768px) {
    input {
        padding: 7px;
        border-radius: 1em;
    }
}
</style>
