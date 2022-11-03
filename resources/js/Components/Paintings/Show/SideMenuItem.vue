<script setup>
import { ref, onMounted } from "vue";
import { useMq } from "vue3-mq";

defineProps({
    painting: Object,
});

const notMounted = ref(true);
const mq = useMq();
const hovered = ref(false);

onMounted(() => {
    notMounted.value = false;
});
</script>
<template>
    <li>
        <a
            @click.prevent="$emit('navigation', painting.slug)"
            :href="painting.slug"
            @mouseenter="hovered = true"
            @mouseleave="hovered = false"
        >
            <span>{{ painting.title }}</span>
            <teleport
                to="#thumb-holder"
                :disabled="mq.current === 'sm'"
                v-if="!notMounted"
            >
                <img
                    v-show="hovered || mq.current === 'sm'"
                    :alt="painting.title"
                    :src="painting.thumb"
                />
            </teleport>
        </a>
    </li>
</template>
<style scoped lang="scss">
@import "Css/painting-variables.scss";

li {
    position: relative;
    background: rgb(255, 255, 255);
    background: $buttonBaseColor;

    list-style-type: none;

    &:hover {
        background: $buttonHoverColor;
    }

    &.active {
        background: $buttonHoverColor;

        span {
            text-decoration: underline;
        }
    }
}

a {
    position: relative;
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;

    font-size: 1em;
    line-height: 1.1em;
    color: white;
    text-decoration: none;

    padding: 10px;
    border-bottom: 1px black solid;
    border-top: 1px white solid;
    text-shadow: 0px 0px 2px #000000;

    &:hover {
        border-top: 1px #834d4d solid;
        border-bottom: 1px #834d4d solid;
    }

    span {
        color: white;
        width: auto;
    }
}

.dead {
    background-image: url("../../../../assets/images/paintings/show/mini-dead.png");
    width: 30px;
    height: 30px;
    position: absolute;
    top: 50%;
    right: 2%;
    transform: translate(0%, -50%);
    -ms-transform: translate(0%, -50%);
}

img {
    border: 2px white outset;
    box-shadow: 0px 0px 0px 1px #43536b;
    border-radius: 5px;
    background-color: white;
    width: 150px;
    height: 150px;
    object-fit: cover;
    //position: absolute;
}

@media (max-width: 768px) {
    img {
        width: 100px;
        height: 100px;
    }
}
</style>
