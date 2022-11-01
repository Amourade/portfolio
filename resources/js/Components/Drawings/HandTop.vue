<script setup>
import Hand from "Assets/images/drawings/main.png";
import Grab from "Assets/images/drawings/grab-top.png";
import { onBeforeMount, ref, watch } from "vue";

defineProps({
    grabbing: Boolean,
});

const emit = defineEmits(["loadNeeded", "loaded"]);

const toLoad = ref(2);
const loaded = ref(0);

watch(loaded, (value) => {
    if (value === toLoad.value) emit("loaded");
});

onBeforeMount(() => {
    emit("loadNeeded");
    let hand = new Image();
    hand.src = Hand;
    hand.onload = () => {
        loaded.value++;
    };
    let grab = new Image();
    grab.src = Grab;
    grab.onload = () => {
        loaded.value++;
    };
});
</script>
<template>
    <div
        class="hand"
        :style="{
            backgroundImage: grabbing
                ? 'url(' + Hand + ')'
                : 'url(' + Grab + ')',
        }"
    ></div>
</template>
<style lang="scss" scoped>
.hand {
    position: absolute;
    top: 50%;
    right: -13%;
    width: 50vmin;
    height: 50vmin;
    transform-origin: center center;
    transform: translate(50%, -50%);
    background: transparent;
    background-size: cover;

    z-index: 3;
}

.close-grabbing {
    animation: closeGrab 0.5s linear;
    animation-fill-mode: forwards;
}

@keyframes closeGrab {
    0% {
        right: -200%;
    }

    100% {
        right: -13%;
    }
}

.grabbing {
    animation: grab 1s linear;
    animation-fill-mode: forwards;
}

.zooming {
    animation: zoom 2s linear;
    animation-fill-mode: forwards;
}

.moving {
    animation: move 1s linear;
    animation-fill-mode: forwards;
}

.flicking {
    animation: flick 300ms linear;
    animation-fill-mode: forwards;
}

@keyframes flick {
    0% {
        transform: translate(50%, -50%) rotate(0deg);
        right: -13%;
    }

    30% {
        transform: translate(50%, -50%) rotate(0deg);
        right: -13%;
    }

    35% {
        transform: translate(50%, -50%) rotate(45deg);
        right: -13%;
    }

    100% {
        transform: translate(50%, -50%) rotate(45deg);
        right: -13%;
    }
}

@keyframes move {
    0% {
        right: -13%;
    }

    100% {
        right: -200%;
    }
}

@keyframes grab {
    0% {
        width: 50vmin;
        height: 50vmin;
    }

    100% {
        width: 10vmin;
        height: 10vmin;
    }
}

@keyframes zoom {
    0% {
        width: 10vmin;
        height: 10vmin;
    }

    100% {
        width: 50vmin;
        height: 50vmin;
    }
}
</style>
