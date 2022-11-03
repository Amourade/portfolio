<script setup>
import { Inertia } from "@inertiajs/inertia";
import { computed } from "@vue/reactivity";
import { onUnmounted, ref } from "vue";
import Gates from "@/Components/Paintings/Index/Gates.vue";
import Thumbnail from "@/Components/Paintings/Index/Thumbnail.vue";
defineProps({
    paintings: Object,
});

const gateOpen = ref(false);
let navTimeout = null;
const toLoad = ref(0);
const loaded = ref(0);

let openGates = (e) => {
    gateOpen.value = true;
    navTimeout = setTimeout(() => Inertia.visit(e), 5000);
};

onUnmounted(() => {
    if (navTimeout) clearTimeout(navTimeout);
});

const doneLoading = computed(() => {
    return toLoad.value === loaded.value;
});
</script>
<template>
    <Head>
        <title>Peintures</title>
    </Head>
    <Transition appear>
        <div class="loader" v-if="!doneLoading">
            <div class="inside">Loading...</div>
        </div>
    </Transition>

    <Gates
        @load-needed="toLoad++"
        @loaded="loaded++"
        :class="{ open: gateOpen }"
    />

    <main class="peintures">
        <div class="white-flash" v-if="gateOpen"></div>
        <div class="thumbs-list-wrapper" :class="{ hidden: gateOpen }">
            <div class="thumbs-list">
                <div v-for="painting in paintings">
                    <Thumbnail
                        @navigate="openGates"
                        :painting="painting"
                    ></Thumbnail>
                </div>
            </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>
.v-enter-active {
    transition: none;
}

.v-enter-from {
    opacity: 1;
}

.v-enter-active .inside,
.v-leave-active .inside {
    transition: opacity 0.5s linear;
}

.v-enter-from .inside,
.v-leave-to .inside {
    opacity: 0;
}

.v-leave-active {
    transition: opacity 1s linear;
}

.v-leave-to {
    opacity: 0;
}

.return {
    position: absolute;
    right: 0px;
    top: 0px;

    z-index: 5;
}

.loader {
    position: absolute;
    top: 0px;
    left: 0px;
    height: 100%;
    width: 100%;
    background: linear-gradient(180deg, #ffffff 0%, #c3bfbb 33%, #96aab6 66%);

    z-index: 5;

    display: flex;
    align-items: center;
    justify-content: center;

    .inside {
        padding: 10px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 5px;
        //border: 1px solid rgba(0,0,0,0.5);
        border: 1px solid white;
        box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.5);
        color: black;

        cursor: default;

        animation: loading 1s infinite;
    }
}

@keyframes loading {
    0% {
        transform: rotate(-10deg);
    }

    50% {
        transform: rotate(10deg);
    }

    100% {
        transform: rotate(-10deg);
    }
}

.thumbs-list-wrapper {
    position: relative;
    border-radius: 10px;
    border: 3px white outset;
    box-shadow: 0px 0px 0px 1px #43536b, 20px 20px 20px rgba(0, 0, 0, 0.5);
    max-width: 100%;
    max-height: 50%;
    margin: 0 5%;

    display: flex;
    z-index: 2;
    overflow: hidden;

    &.hidden {
        animation: hidethumbs 2s 1 ease-in-out;
        -webkit-animation: hidethumbs 1s 1 ease-in-out;
        border: 3px transparent outset;
        box-shadow: none;

        .thumbs-list {
            animation: hidebackground 2s 1 ease-in-out;
            -webkit-animation: hidebackground 1s 1 ease-in-out;
            background: linear-gradient(
                180deg,
                #ffffff 0%,
                #c3bfbb 6%,
                #96aab6 48%,
                #43536b 97%,
                #000000 100%
            );
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(195, 191, 187, 0) 25%,
                rgba(150, 170, 182, 0) 48%,
                rgba(67, 83, 107, 0) 80%,
                rgba(0, 0, 0, 0) 100%
            );

            div a:not(.selected) {
                animation: hidediv 2s 1 ease-in-out;
                -webkit-animation: hidediv 2s 1 ease-in-out;
                opacity: 0;
                cursor: pointer;
            }
        }
    }
}

.thumbs-list {
    padding: 15px;
    z-index: 1;
    position: relative;
    overflow-y: auto;
    display: flex;
    flex-wrap: wrap;

    max-height: 100%;

    justify-content: space-evenly;
    background: rgb(183, 220, 240);
    background: linear-gradient(
        180deg,
        rgba(255, 255, 255, 1) 0%,
        rgba(195, 191, 187, 1) 25%,
        rgba(150, 170, 182, 1) 48%,
        rgba(67, 83, 107, 1) 80%,
        rgba(0, 0, 0, 1) 100%
    );

    gap: 15px;

    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
    &::-webkit-scrollbar {
        display: none;
    }

    div {
        display: flex;
        align-items: center;
        justify-content: center;

        /* width: 150px;
        height: 150px; */
    }
}
.peintures {
    height: 100vh;
    width: 100vw;
    max-width: 100%;
    max-height: 100%;
    //min-width: 400px;
    position: relative;

    display: flex;
    align-items: center;
    justify-content: center;
}

@media only screen and (max-width: 768px) {
    .thumbs-list-wrapper {
        margin: 0px;
    }
    .thumbs-list {
        padding: 0px;
        margin-right: 0px;
        gap: 0px;

        div {
            width: 110px;
            height: 110px;
        }
    }
}

@keyframes hidediv {
    from {
        opacity: 1;
    }

    to {
        opacity: 0;
    }
}

@keyframes hidethumbs {
    from {
        border: 3px white outset;
        box-shadow: 0px 0px 0px 1px #43536b;
    }

    to {
        border: 3px transparent outset;
        box-shadow: none;
    }
}

@keyframes hidebackground {
    from {
        background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(195, 191, 187, 1) 25%,
            rgba(150, 170, 182, 1) 48%,
            rgba(67, 83, 107, 1) 80%,
            rgba(0, 0, 0, 1) 100%
        );
    }

    to {
        background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(195, 191, 187, 0) 25%,
            rgba(150, 170, 182, 0) 48%,
            rgba(67, 83, 107, 0) 80%,
            rgba(0, 0, 0, 0) 100%
        );
    }
}

.white-flash {
    width: 100%;
    height: 100%;
    position: absolute;
    z-index: 5;
    background-color: white;

    animation: whiteflash 5s 1 ease-in;
    -webkit-animation: whiteflash 5s 1 ease-in;
}

@keyframes whiteflash {
    from {
        background-color: transparent;
    }

    to {
        background-color: white;
    }
}
</style>
