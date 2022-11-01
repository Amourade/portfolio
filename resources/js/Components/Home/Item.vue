<script setup>
import { ref, watch, onMounted } from "vue";
import { getRandomValue } from "@/Utils/getRandomValue";

defineProps(["item"]);

const inside = ref(null);
const rotating = ref(false);
const rotatingSpeed = ref(0);
const isLoaded = ref(false);
const notMounted = ref(true);
let currentRotation = 0;
let speedIncrement = 0.02;
let animationRequest = null;

watch(rotatingSpeed, () => {
    if (rotatingSpeed.value <= 0) {
        rotatingSpeed.value = 0;
        cancelAnimationFrame(animationRequest);
    }
    if (rotatingSpeed.value >= 30) {
        rotatingSpeed.value = 30;
    }
    currentRotation = currentRotation + rotatingSpeed.value;
    inside.value.style.transform = "rotateY(" + currentRotation + "deg)";
});

watch(rotating, () => {
    if (rotating.value === true) {
        animationRequest = requestAnimationFrame(animate);
        speedIncrement = Math.abs(speedIncrement);
    } else {
        speedIncrement = -speedIncrement;
    }
});

function animate() {
    rotatingSpeed.value += speedIncrement;
    animationRequest = requestAnimationFrame(animate);
}

onMounted(() => {
    notMounted.value = false;
});
</script>

<template>
    <div
        :class="[{ loaded: isLoaded }, { notMounted: notMounted }, item.type]"
        class="container"
        :style="{ marginTop: getRandomValue(300) + 'px' }"
        @mouseenter="rotating = true"
        @mouseleave="rotating = false"
    >
        <div class="inside" ref="inside">
            <div class="img-container">
                <img
                    :alt="item.title"
                    :src="item.image"
                    loading="lazy"
                    @load="isLoaded = true"
                />
            </div>
            <span
                :style="{
                    transform: 'rotate(' + getRandomValue(90, -45) + 'deg)',
                }"
            >
                <Link :href="item.slug">
                    {{ item.title }}
                </Link>
            </span>
        </div>
    </div>
</template>

<style scoped>
.container.loaded,
.container.notMounted {
    opacity: 1;
}

.container {
    position: relative;
    display: flex;
    flex-grow: 1;
    max-width: 100vw;
    opacity: 0;

    transition: opacity 1s;
}

.container::before {
    content: "";
    min-width: 300px;
    min-height: 300px;
    position: absolute;
    flex-grow: 1;
    padding: 15px;
    display: flex;
    line-height: 0;
    width: 100%;
    height: 100%;
    bottom: 0px;
    left: 0px;
}

.size-keeper {
    min-width: 300px;
    min-height: 300px;
    position: absolute;
    flex-grow: 1;
    padding: 15px;
    display: flex;
    line-height: 0;
    width: 100%;
    height: 100%;
    bottom: 0px;
    left: 0px;
}

.inside {
    min-width: 300px;
    min-height: 300px;
    position: relative;
    border: 2px solid black;
    flex-grow: 1;
    text-align: center;
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    line-height: 0;
    border-radius: 100%;
    overflow: hidden;
    background-color: black;
}

.img-container {
    position: relative;
}

.img-container::before {
    content: "";
    display: block;
    box-shadow: inset 0 0 100px 100px black;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

img {
    max-height: 500px;
    max-width: 500px;
}

span {
    font-family: "Tangerine", serif;
    line-height: 200px;
    font-size: 200px;
    color: #9f9f00;
    position: absolute;
    z-index: 2;
}

a {
    color: #9f9f00;
    word-break: normal;
    text-decoration: none;
}

a:hover {
    color: #573256;
}
</style>
