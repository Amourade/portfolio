<script setup>
import Menu from "@/Components/Drawings/Menu.vue";
import background from "Assets/images/drawings/fond-drawings.jpg";
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

onBeforeMount(() => {
    loadDone.value = false;
});

onBeforeMount(() => {
    toLoad.value++;
    let bg = new Image();
    bg.src = background;
    bg.onload = () => {
        loaded.value++;
    };
});

const toLoad = ref(0);
const loaded = ref(0);
const loadDone = ref(true);

watch(loaded, (value) => {
    if (value === toLoad.value) loadDone.value = true;
});
</script>
<template>
    <div
        class="drawings-page"
        :style="{ backgroundImage: 'url(' + background + ')' }"
    >
        <template v-if="loadDone">
            <Menu
                @navigate="navigate"
                :drawings="drawings"
                :currentDrawing="currentDrawing"
                :highlight="currentHighlight"
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
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s linear;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
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

.loader {
    width: 100vw;
    height: 100vh;
    z-index: 1000;
    background: white;
    position: absolute;
    font-size: 30px;
    font-family: "Tangerine", cursive;
    z-index: 100;

    display: flex;
    align-items: center;
    justify-content: center;
}

main {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    z-index: 1;
}
</style>
