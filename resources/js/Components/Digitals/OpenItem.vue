<script setup>
import { Inertia } from "@inertiajs/inertia";
import { onMounted, onUnmounted, ref, computed, onBeforeMount } from "vue";
import { useEventListener } from "@/Components/Shared/event";

const emit = defineEmits(["navigate"]);

const props = defineProps({
    digitals: Object,
    current: Object,
    animateTarget: Object,
    animating: Boolean,
});

const navigate = (e) => {
    done.value = false;
    const sourceSize = props.animateTarget.getBoundingClientRect();
    style.value = {
        left: sourceSize.left + window.scrollX + "px",
        top: sourceSize.top + window.scrollY + "px",
        height: sourceSize.height + "px",
        width: sourceSize.width + "px",
    };
    setTimeout(() => {
        emit("navigate", e, "close");
    }, 1000);
    //
};

const className = ref("nojs");
const scrollTop = ref(0);
const style = ref({});
const done = ref(true);

const setScrollTop = () => {
    style.value = { top: `calc(2.5vh + ${window.scrollY}px)` };
};

//useEventListener(window, "scroll", setScrollTop);

onBeforeMount(() => {
    done.value = false;
});

onMounted(() => {
    className.value = "";

    if (props.animating) {
        const sourceSize = props.animateTarget.getBoundingClientRect();
        style.value = {
            left: sourceSize.left + window.scrollX + "px",
            top: sourceSize.top + window.scrollY + "px",
            height: sourceSize.height + "px",
            width: sourceSize.width + "px",
            transition: "none",
        };

        setTimeout(() => {
            className.value = "js-open";
            setScrollTop();
            window.addEventListener("scroll", setScrollTop);

            setTimeout(() => {
                done.value = true;
            }, 1000);
        }, 100);

        return;
    }

    //Animate Loading
    className.value = "js-open";
    setScrollTop();
    window.addEventListener("scroll", setScrollTop);
    done.value = true;
});

onUnmounted(() => {
    window.removeEventListener("scroll", setScrollTop);
});
</script>
<template>
    <main
        class="open-digital"
        :class="[[className], { done: done }]"
        :style="[style]"
    >
        <div class="close">
            <a @click.prevent="navigate('/digitaux')" href="/digitaux">X</a>
        </div>
        <div
            class="image-holder"
            :style="{ backgroundImage: `url(${current.images[0].thumb})` }"
        >
            <img :src="current.images[0].url" :alt="current.title" />
        </div>

        <h2>{{ current.title }}</h2>
    </main>
</template>
>
<style lang="scss" scoped>
.open-digital {
    //transform: translate(-50%, -50%);
    position: absolute;

    display: flex;
    text-align: center;
    justify-content: center;

    z-index: 100;

    transition: width 1s, height 1s, top 1s, left 1s;

    &.nojs {
        position: fixed;

        width: 95vw;
        height: 95vh;
        top: 2.5vh;
        left: 2.5vw;
    }

    &.js-open {
        width: 95vw;
        height: 95vh;
        top: 2.5vh;
        left: 2.5vw;
    }

    .image-holder {
        width: 100%;
        height: 100%;
        object-fit: cover;

        display: grid;
        align-items: center;
        justify-items: center;

        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    img {
        max-height: 100%;
        width: auto;
        height: auto;
        max-width: 100%;

        background-size: cover;
    }

    .close,
    h2 {
        opacity: 0;
        position: absolute;

        transition: opacity 0.3s;
    }

    .close {
        top: 0px;
        right: 0px;

        text-decoration: none;

        width: 40px;
        height: 40px;
        background: linear-gradient(
            0deg,
            rgba(0, 0, 0, 1) 0%,
            rgba(61, 94, 152, 1) 15%,
            rgba(146, 152, 173, 1) 54%,
            rgba(74, 71, 175, 1) 91%,
            rgba(237, 254, 255, 1) 100%
        );
        display: flex;
        align-items: center;
        justify-content: center;

        a {
            display: block;
            width: 100%;
            height: 100%;

            font-size: 1.5em;
            color: rgba(0, 0, 0, 0);
            text-shadow: 0 0 2px white;
            transition: text-shadow 0.3s;

            &:hover {
                text-shadow: 0 0 0 white;
            }
        }
    }

    h2 {
        bottom: 0px;

        color: rgba(0, 0, 0, 0.5);
        text-shadow: 0px 0px 3px #d5c944;
        background: linear-gradient(
            0deg,
            rgba(40, 35, 35, 1) 0%,
            rgba(140, 140, 140, 1) 10%,
            rgba(252, 255, 249, 1) 50%,
            rgba(150, 150, 150, 1) 91%,
            rgba(46, 43, 43, 1) 100%
        );

        padding: 0 10px;
        display: none;
    }

    &.done {
        .close {
            z-index: 5;
            opacity: 1;
        }

        h2 {
            opacity: 1;
        }
    }
}
</style>
