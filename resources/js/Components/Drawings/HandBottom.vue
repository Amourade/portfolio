<script setup>
import { onBeforeMount } from "vue";
import Grab from "Assets/images/drawings/grab-bottom.png";

const emit = defineEmits(["loadNeeded", "loaded"]);

onBeforeMount(() => {
    emit("loadNeeded");
    let grab = new Image();
    grab.src = Grab;
    grab.onload = () => {
        emit("loaded");
    };
});
</script>
<template>
    <div class="hand" :style="{ backgroundImage: 'url(' + Grab + ')' }"></div>
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

    z-index: -1;
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
