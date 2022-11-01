<script setup>
import { computed } from "@vue/reactivity";
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { useResize } from "@/Components/Shared/resize";
import HandTop from "./HandTop.vue";
import HandBottom from "./HandBottom.vue";
import { getCurrentRotation } from "@/Components/Shared/functions";
import { increaseIndex } from "@/Utils/indexManager.js";
import Image from "./Image.vue";

const props = defineProps({
    drawing: Object,
    details: Object,
    highlight: Boolean,
    index: Number,
    highestIndex: Number,
    drawingOpen: Boolean,
});

const emit = defineEmits(["hover", "out", "navigate", "loadNeeded", "loaded"]);

const drawingEl = ref();

const { WIDTH, HEIGHT } = useResize();
const loaded = ref(true);
const current = ref(props.details ? true : false);
const open = ref(false);
const refRight = ref(Math.floor(Math.random() * 90 + 5));
const refTop = ref(Math.floor(Math.random() * 90 + 5));
const refRotation = ref(Math.floor(Math.random() * 180));
const canShow = ref(true);

watch(
    () => props.details,
    (newValue) => {
        if (newValue && props.drawingOpen) {
            canShow.value = false;
            setTimeout(() => {
                current.value = true;
            }, 1000);
            return;
        }

        if (newValue) {
            canShow.value = false;
            current.value = true;
            return;
        }
        current.value = false;
    }
);

watch(current, (newValue, oldValue) => {
    if (newValue === false) {
        closeImage();
        return;
    }

    openImage();
});

const ratio = ref(0);
const maxSize = computed(() => {
    return WIDTH.value < HEIGHT.value ? WIDTH.value : HEIGHT.value;
});
const sizeAbsolute = computed(() => {
    return open.value ? maxSize.value * (sizeRelative.value / 100) : 300;
});
const sizeRelative = computed(() => {
    return open.value ? 80 : 20;
});
const width = computed(() => {
    return ratio.value > 1
        ? sizeRelative.value
        : sizeRelative.value * ratio.value;
});
const maxWidth = computed(() => {
    return ratio.value > 1
        ? sizeAbsolute.value
        : sizeAbsolute.value * ratio.value;
});
const height = computed(() => {
    return ratio.value > 1
        ? sizeRelative.value / ratio.value
        : sizeRelative.value;
});
const maxHeight = computed(() => {
    return ratio.value > 1
        ? sizeAbsolute.value / ratio.value
        : sizeAbsolute.value;
});
const right = computed(() => {
    return open.value ? 50 : refRight.value;
});
const top = computed(() => {
    return open.value ? 45 : refTop.value;
});
const rotation = computed(() => {
    return open.value ? 0 : refRotation.value;
});
const shadow = computed(() => {
    return open.value
        ? !drawingState.value && !handState.value
            ? "none"
            : "rgba(0, 0, 0, 0.7) 100px 100px 75px 0px"
        : "2px 2px 5px rgba(0, 0, 0, 0.7)";
});
const zIndex = ref(props.index);

function show(e) {
    ratio.value = e.naturalWidth / e.naturalHeight;
    loaded.value = true;
}

const closing = ref(false);
const opening = ref(false);
let handTimeout = null;
let drawingTimeout = null;

const animSpeed = ref(500);
const handDuration = ref(500);
const drawingDuration = ref(500);
const handState = ref(null);
const drawingState = ref(null);

function openImage() {
    clearTimeouts();
    increaseIndex();

    handState.value = "grabbing";
    handDuration.value = animSpeed.value;
    zIndex.value = props.highestIndex;
    opening.value = true;

    handTimeout = setTimeout(() => {
        open.value = true;

        drawingDuration.value = animSpeed.value * 2;
        drawingState.value = "opening";

        drawingTimeout = setTimeout(() => {
            drawingState.value = null;

            opening.value = false;
            canShow.value = true;
        }, drawingDuration.value);

        handState.value = "zooming";
        handDuration.value = drawingDuration.value;

        handTimeout = setTimeout(() => {
            handState.value = "moving";
            handDuration.value = animSpeed.value;
            handTimeout = setTimeout(() => {
                handState.value = null;
            }, handDuration.value);
        }, drawingDuration.value);
    }, handDuration.value);
}

function closeImage() {
    clearTimeouts();

    handState.value = "close-grabbing";
    handDuration.value = animSpeed.value / 2;
    closing.value = true;

    handTimeout = setTimeout(() => {
        handState.value = "flicking";
        handDuration.value = animSpeed.value / 2;

        handTimeout = setTimeout(() => {
            handState.value = null;

            drawingDuration.value = animSpeed.value;
            drawingState.value = "closing";
            drawingTimeout = setTimeout(() => {
                drawingState.value = null;
                refRotation.value = getCurrentRotation(drawingEl.value);

                closing.value = false;
            }, drawingDuration.value);

            open.value = false;
            refRight.value = Math.floor(Math.random() * 90 + 5);
            refTop.value = Math.floor(Math.random() * 90 + 5);
            refRotation.value = Math.floor(Math.random() * 720);
        }, handDuration.value);
    }, handDuration.value);
}

function clearTimeouts() {
    clearTimeout(handTimeout);
    clearTimeout(drawingTimeout);
    handState.value = null;
    drawingState.value = null;
    closing.value = false;
    opening.value = false;
}

const toLoad = ref(0);
const elemLoaded = ref(0);

onMounted(() => {
    loaded.value = false;
    canShow.value = false;
    if (current.value) {
        open.value = true;
        canShow.value = true;
        zIndex.value = props.highestIndex;
    }
});

onBeforeMount(() => {
    emit("loadNeeded");
});

watch(elemLoaded, (newValue) => {
    if (newValue === toLoad.value) emit("loaded");
});
</script>
<template>
    <div
        class="drawing"
        ref="drawingEl"
        :class="[{ loading: !loaded, current: current }, drawingState]"
        :style="{
            top: top + '%',
            right: right + '%',
            transform:
                'rotate(' + rotation + 'deg) translateX(50%) translateY(-50%)',
            width: width + 'vmax',
            height: height + 'vmax',
            maxHeight: maxHeight + 'px',
            maxWidth: maxWidth + 'px',
            transitionDuration: drawingDuration + 'ms',
            zIndex: zIndex,
            boxShadow: shadow,
        }"
    >
        <HandTop
            @loadNeeded="toLoad++"
            @loaded="elemLoaded++"
            :class="[handState]"
            :grabbing="handState === 'grabbing'"
            v-show="handState"
            :style="{ animationDuration: handDuration + 'ms' }"
        ></HandTop>

        <Image
            :animDone="!drawingState && !handState"
            :drawing="drawing"
            :details="details"
            :highlight="highlight"
            :canShow="canShow"
            :opening="opening"
            :closing="closing"
            @loaded="show"
            @out="$emit('out')"
            @hover="$emit('hover', drawing.slug)"
            @navigate="$emit('navigate', drawing.slug)"
        >
        </Image>

        <HandBottom
            @loadNeeded="toLoad++"
            @loaded="elemLoaded++"
            :class="[handState]"
            v-show="handState && handState !== 'grabbing'"
            :style="{ animationDuration: handDuration + 'ms' }"
        >
        </HandBottom>
    </div>
</template>
<style lang="scss" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s linear;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
    position: absolute;
}

.drawing {
    position: absolute;
    border-radius: 2px;
    transform: translateX(50%) translateY(-50%);
    transform-origin: 90% -10%;

    opacity: 1;

    transition: opacity 0.5s linear;

    &.loading {
        opacity: 0;
    }
}

.opening,
.closing {
    transition: all 2s linear;
}

.current {
    z-index: 36;
}
</style>
