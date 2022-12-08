<script setup>
import Menu from "@/Components/Drawings/Menu.vue";
import background from "Assets/images/drawings/fond-drawings.webp";
import Drawing from "@/Components/Drawings/Drawing.vue";
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { useIndexManager } from "@/Utils/indexManager";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    drawings: Object,
    currentDrawing: Object,
});

const currentHighlight = ref(null);
const highestIndex = useIndexManager(props.drawings.length);
const drawingOpen = ref(props.currentDrawing ? true : false);

watch(
    () => props.currentDrawing,
    (newValue, oldValue) => {
        newValue && oldValue
            ? (drawingOpen.value = true)
            : (drawingOpen.value = false);
    }
);

function highlight(e) {
    currentHighlight.value = e;
}

function removeHighlight() {
    currentHighlight.value = null;
}

function navigate(e) {
    if (
        (props.currentDrawing && e !== props.currentDrawing.slug) ||
        !props.currentDrawing
    ) {
        //increaseIndex();
        Inertia.visit(e, {
            only: ["currentDrawing"],
        });
    }
}

/**Load Logic */

const toLoad = ref(0);
const loaded = ref(0);
const loadDone = ref(true);
const goingHome = ref(false);

onBeforeMount(() => {
    loadDone.value = false;
    toLoad.value++;
    let bg = new Image();
    bg.src = background;
    bg.onload = () => {
        loaded.value++;
    };
});

watch(loaded, (value) => {
    if (value === toLoad.value) loadDone.value = true;
});

const changePage = (e) => {
    goingHome.value = true;
    setTimeout(() => {
        Inertia.visit(e);
    }, 150);
};
</script>
<template>
    <div
        class="drawings-page"
        :style="{ backgroundImage: 'url(' + background + ')' }"
    >
        <transition>
            <div class="loader" v-if="!loadDone"></div>
        </transition>

        <Transition name="going-home">
            <div class="going-home" v-if="goingHome"></div>
        </Transition>

        <template v-if="loadDone">
            <Menu
                @navigate="navigate"
                :drawings="drawings"
                :currentDrawing="currentDrawing"
                :highlight="currentHighlight"
                @changePage="changePage"
                @hover="highlight"
                @out="removeHighlight"
            />
            <div id="video-holder"></div>
            <main>
                <Drawing
                    v-for="(drawing, index) in drawings"
                    :key="index"
                    :index="index"
                    :highestIndex="highestIndex"
                    :highlight="
                        currentHighlight && currentHighlight === drawing.slug
                            ? true
                            : false
                    "
                    :details="
                        currentDrawing && drawing.slug === currentDrawing.slug
                            ? currentDrawing
                            : null
                    "
                    :drawingOpen="drawingOpen"
                    @navigate="navigate"
                    :drawing="drawing"
                    @hover="highlight"
                    @out="removeHighlight"
                    @loadNeeded="toLoad++"
                    @loaded="loaded++"
                />
                <slot />
            </main>
        </template>
    </div>
</template>
<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css2?family=Tangerine");
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

.loader {
    background: #631c1c;
    position: absolute;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}

.going-home-enter-active,
.going-home-leave-active {
    transition: all 0.3s linear;
}

.going-home-enter-from,
.going-home-leave-to {
    opacity: 0;
}

.going-home {
    background: black;
    position: absolute;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}
.drawings-page {
    position: absolute;
    z-index: 1;
    width: 100vw;
    height: 100vh;
    font-family: "Tangerine", cursive;
    font-weight: 700;
    font-size: 1.8em;
    color: black;
    background-size: 100%;
    background-position: center -7%;
    background-color: white;

    overflow: hidden;
}

main {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    z-index: 1;
}
</style>
