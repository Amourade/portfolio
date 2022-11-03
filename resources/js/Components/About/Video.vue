<script setup>
import { YoutubeIframe } from "@vue-youtube/component";
import { onMounted, ref } from "vue";

const props = defineProps({
    videoId: String,
});

const videoOpen = ref(true);
</script>
<template>
    <transition>
        <div v-if="videoOpen" v-moveable class="video">
            <div class="close">
                <a href="#" @click.prevent="() => (videoOpen = false)">X</a>
            </div>
            <div class="iframe-holder">
                <youtube-iframe
                    :style="{ width: '100%', height: '100%' }"
                    :video-id="videoId"
                    :player-vars="{ autoplay: 0 }"
                />
            </div>
        </div>
    </transition>
</template>
<style lang="scss" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s linear;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.video {
    position: absolute;
    z-index: 2;
    padding: 10px 10px;
    background-color: white;
    background: white;
    background-size: auto;
    border: 5px #b7dcf0 outset;
    background-size: 100%;
    border-radius: 5px;
    box-shadow: 0px 0px 0px 1px #43536b, 10px 10px 15px rgba(0, 0, 0, 0.5);
    display: block;
    cursor: move;
    left: 15%;
    top: 15%;
    overflow: hidden;
    max-width: 75vw;
}

.iframe-holder {
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0px 0px 0px 1px #43536b;
    background-color: black;
    border: 4px black inset;

    width: 400px;
    height: 400px;
}

.z-wrapper {
    z-index: -1;
    display: block;
    width: 400px;
    height: 400px;
    background-color: transparent;
    color: transparent;
    position: absolute;
    bottom: 7px;
    left: 10px;
}
.close {
    text-align: right;
    padding-bottom: 10px;

    a {
        display: inline-block;
        padding: 5px;
        cursor: pointer;
        border-radius: 3px;
        border: 2px black outset;
        transform: rotate(-20deg);
        background: black;
        color: white;

        text-decoration: none;

        &:hover {
            background: white;
            color: black;
            transform: rotate(0deg);
        }
    }
}

iframe {
    width: 100% !important;
    height: 100% !important;
}

@media (max-width: 768px) {
    .iframe-holder {
        width: 250px;
        height: 250px;
    }
}
</style>
