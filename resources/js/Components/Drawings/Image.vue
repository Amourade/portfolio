<script setup>
import { computed } from "@vue/reactivity";
import { onMounted, ref, watch } from "vue";
import Infos from "./Infos.vue";
import Video from "./Video.vue";

const emit = defineEmits(["hover", "out", "loaded", "navigate"]);

const props = defineProps({
    details: Object,
    drawing: Object,
    animDone: Boolean,
    highlight: Boolean,
    closing: Boolean,
    opening: Boolean,
    canShow: Boolean,
});

const thumbSrc = ref(props.drawing.images[0].medium);

const fullSrc = computed(() => {
    return props.drawing.images[currentImg.value].url;
});

const imgs = computed(() => {
    return props.drawing.images.length;
});

const currentImg = computed({
    get() {
        return props.details ? current.value : 0;
    },
    set(newValue) {
        if (newValue >= 0 && newValue < imgs.value) {
            hideThumb.value = true;
            loadingFull.value = true;
            setTimeout(() => {
                current.value = newValue;
            }, 300);
        }
    },
});

const loadedImg = ref(null);

const current = ref(0);
const loaded = ref(false);
const loadingFull = ref(false);
const hideThumb = ref(false);
const mounted = ref(false);

watch(
    () => props.details,
    (newValue) => {
        if (newValue) {
            loadingFull.value = true;
            load(fullSrc.value, true);
            return;
        }
        hideThumb.value = false;
    }
);

watch(fullSrc, (src) => {
    if (src) {
        loadingFull.value = true;
        load(src, true);
    }
});

onMounted(() => {
    mounted.value = true;
    if (props.details) {
        loadingFull.value = true;
        load(fullSrc.value, true);
    }

    load(thumbSrc.value, false);
});

function load(src, isFull) {
    let img = new Image();
    img.src = src;
    img.onload = () => {
        if (isFull) {
            loadingFull.value = false;
            loadedImg.value = img.src;
        }
        loaded.value = true;
        emit("loaded", img);
    };
}
</script>
<template>
    <div class="image-holder">
        <transition>
            <div v-if="details || closing">
                <img
                    v-if="loadedImg || !mounted"
                    :class="[
                        { loaded: !loadingFull, shadow: canShow && animDone },
                        'full',
                    ]"
                    :src="!mounted ? fullSrc : loadedImg"
                />

                <transition>
                    <div class="details" v-if="details && canShow">
                        <Link href="/dessins" class="close" @click="current = 0"
                            >X</Link
                        >

                        <div class="navigation" v-if="imgs > 1">
                            <a
                                class="previous"
                                v-show="current - 1 >= 0"
                                @click.prevent="currentImg--"
                                href="#"
                                >Previous</a
                            >
                            <a
                                class="next"
                                v-show="current + 1 < imgs"
                                @click.prevent="currentImg++"
                                href="#"
                                >Next</a
                            >
                        </div>

                        <div class="video" v-if="details.video">
                            <Video :video-id="details.video"></Video>
                        </div>

                        <Infos :drawing="details" :image="fullSrc"></Infos>
                    </div>
                </transition>
            </div>
        </transition>

        <a
            v-show="!hideThumb || !mounted"
            class="thumbnail"
            @click.prevent="$emit('navigate')"
            :href="drawing.slug"
            :class="{ hover: highlight }"
            @mouseenter="$emit('hover')"
            @mouseleave="$emit('out')"
        >
            <img :src="thumbSrc" />
        </a>
    </div>
</template>
<style lang="scss" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s linear;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.image-holder {
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 2;

    & > div {
        width: 100%;
        height: 100%;
    }
}

.shadow {
    box-shadow: rgba(0, 0, 0, 0.7) 100px 100px 75px 0px;
}

a {
    display: block;
    height: 100%;

    color: black;
    text-decoration: none;

    &:hover,
    &.hover {
        box-shadow: 0px 0px 15px blue;
    }
}

.details {
    width: 100%;
    height: 100%;
}

.close {
    position: absolute;
    display: inline-block;
    height: auto;
    top: 0px;
    right: 0px;
    transform: translate(100%, 0%);

    background: white;
    border: 1px solid black;
    padding: 4px 9px 1px 4px;
    line-height: 1;

    &:hover {
        box-shadow: none;
        background: transparent;
        color: blue;
    }
}

.video {
    position: absolute;
    bottom: 0px;
    right: 0px;
}

.navigation {
    position: absolute;
    top: 50%;
    width: 100%;

    a {
        display: inline-block;
        position: absolute;

        background: white;
        border: 1px solid black;
        text-align: center;

        color: black;
        text-decoration: none;

        width: 100px;
        height: auto;

        &:hover {
            color: blue;
        }

        &.previous {
            transform: translateX(-100%) rotate(-90deg) translateX(100%);
            transform-origin: bottom right;
            left: 0%;
        }

        &.next {
            transform: translateX(100%) rotate(90deg) translateX(-100%);
            transform-origin: bottom left;
            right: 0%;
        }
    }
}

.thumbnail {
    width: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    z-index: -1;
}

img {
    display: block;
    float: right;
    width: 100%;
    max-height: 100%;
}

.full {
    opacity: 0;
    transition: opacity 0.3s linear;

    &.loaded {
        opacity: 1;
    }
}
</style>
