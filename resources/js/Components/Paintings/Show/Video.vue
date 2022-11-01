<script setup>
import { YoutubeIframe } from "@vue-youtube/component";
import { ref, watch } from "vue";
import Button from "./Button.vue";

const props = defineProps({
    videoId: String,
    reset: Boolean,
});

const videoOpen = ref(false);

watch(
    () => props.reset,
    (value) => {
        if (value === true) videoOpen.value = false;
    }
);
</script>
<template>
    <transition>
        <a
            href="#"
            @click.prevent="() => (videoOpen = true)"
            :data-video="videoId"
            v-if="!videoOpen"
        >
            <Button>Vidéo</Button>
        </a>
    </transition>
    <transition>
        <div v-if="videoOpen" v-moveable class="video-wrapper">
            <div>
                <a
                    class="close"
                    href="#"
                    @click.prevent="() => (videoOpen = false)"
                    ><Button :style="{ boxShadow: '0px 0px 0px 1px #43536b' }"
                        >X</Button
                    ></a
                >
            </div>
            <div class="iframe-holder">
                <youtube-iframe
                    width="100%"
                    height="100%"
                    :video-id="videoId"
                    :player-vars="{ autoplay: 1 }"
                />
            </div>
        </div>
    </transition>
</template>
<style lang="scss" scoped>
@import "Css/painting-variables.scss";

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s linear;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.video-wrapper {
    position: fixed;

    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    z-index: 2;
    padding: 10px;
    //background: $titleBaseColor;
    border: 2px white outset;
    background: linear-gradient(
        180deg,
        white 0%,
        #c3bfbb 1%,
        #96aab6 48%,
        #43536b 99%,
        black 100%
    );
    border-radius: 5px;
    box-shadow: 0px 0px 0px 1px #43536b, 25px 25px 20px rgba(0, 0, 0, 0.5);

    text-align: right;

    display: flex;
    flex-direction: column;
}

.iframe-holder {
    width: 80vh;
    height: 80vw;
    max-width: 500px;
    max-height: 500px;
    position: relative;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0px 0px 0px 1px #43536b;
    border: 1px solid white;
    background-color: black;
}

iframe {
    position: absolute;
    z-index: 10;
}

.close {
    margin-bottom: 10px;
    display: inline-block;
}
</style>
