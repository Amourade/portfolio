<script setup>
import { YoutubeIframe } from "@/plugins/@vue-youtube/component";
import { ref, watch } from "vue";

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
            class="open"
            href="#"
            @click.prevent="() => (videoOpen = true)"
            :data-video="videoId"
            v-if="!videoOpen"
        >
            Vidéo
        </a>
    </transition>
    <template v-if="videoOpen">
        <teleport to="#video-holder">
            <transition>
                <div
                    v-if="videoOpen"
                    v-moveable
                    data-moveable-close="true"
                    class="video-wrapper"
                >
                    <div>
                        <a
                            class="close"
                            href="#"
                            @click.prevent="() => (videoOpen = false)"
                            >X</a
                        >
                    </div>
                    <div class="iframe-holder">
                        <youtube-iframe
                            width="100%"
                            height="100%"
                            :video-id="videoId"
                            :player-vars="{ autoplay: 0 }"
                        />
                    </div>
                </div>
            </transition>
        </teleport>
    </template>
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

.open {
    transform: translateX(100%) rotate(90deg) translateX(-100%);
    transform-origin: bottom left;
    color: black;
    text-decoration: none;
    display: inline-block;
    width: 100px;
    text-align: center;

    background: white;
    border: 1px solid black;

    &:hover {
        color: blue;
    }
}

.video-wrapper {
    position: fixed;

    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    z-index: 2;
    padding: 5px 15px 15px 15px;
    border: 1px solid black;
    background: white;
    box-shadow: 0px 0px 0px 1px #43536b, 25px 25px 20px rgba(0, 0, 0, 0.5);
    /*  max-width: 75vw;
    max-height: 75vh; */

    text-align: right;

    display: flex;
    flex-direction: column;
}

.iframe-holder {
    width: 80vw;
    height: 50vh;
    max-width: 500px;
    max-height: 500px;
    position: relative;
    overflow: hidden;
    border: 1px solid black;
    background-color: black;
}

iframe {
    position: absolute;
    z-index: 10;
}

.close {
    display: inline-block;
    color: black;
    text-decoration: none;

    &:hover {
        color: blue;
    }
}
</style>
