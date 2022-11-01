<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import dateFormat from "dateformat";

let textRotation = 0;
const moveIncrement = 0.1;

const curve = ref(null);
const time = ref(new Date());
const textType = ref(null);

let animationRequest = null;
let textChangeInterval = null;

function rotateText() {
    textRotation += moveIncrement;
    if (textRotation >= 360) textRotation = 0;
    curve.value.setAttribute(
        "transform",
        "rotate(" + textRotation + " 250 250)"
    );

    animationRequest = requestAnimationFrame(rotateText);
}

function changeText() {
    time.value = new Date();
    textType.value === null
        ? (textType.value = "alternative")
        : (textType.value = null);
}

onMounted(() => {
    animationRequest = requestAnimationFrame(rotateText);
    textChangeInterval = setInterval(changeText, 1000);
});

onUnmounted(() => {
    cancelAnimationFrame(animationRequest);
    clearInterval(textChangeInterval);
});
</script>

<template>
    <svg id="titre" viewBox="0 0 500 500" preserveAspectRatio="none">
        <path
            id="curve"
            ref="curve"
            d="M50,250c0-110.5,89.5-200,200-200s200,89.5,200,200s-89.5,200-200,200S50,360.5,50,250"
            fill="transparent"
        ></path>
        <text :class="textType" x="0">
            <textPath
                startOffset="20%"
                text-anchor="middle"
                xlink:href="#curve"
                id="date"
            >
                Bienvenue --__--
                {{ dateFormat(time, "d/m/yyyy - dddd - H:MM:ss") }} --__--
                Welcome
            </textPath>
        </text>
    </svg>
</template>

<style scoped>
svg {
    position: fixed;
    width: 100%;
    height: 100%;
}

text {
    fill: yellow;
    font-variant: small-caps;
    fill-opacity: 0.6;
    stroke-width: 0.3;
    stroke-opacity: 0.6;
    font-family: "Jim Nightshade", serif;
    font-weight: 700;
}

text.alternative {
    font-family: sans-serif;
}
</style>
