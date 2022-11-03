<script>
export default {
    inheritAttrs: false,
};
</script>
<script setup>
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { useEventListener } from "@/Components/Shared/event.js";
import Button from "./Button.vue";
import Video from "./Video.vue";
import LoadIndicator from "./LoadIndicator.vue";

const emit = defineEmits(["load-needed", "loaded"]);
const props = defineProps({
    painting: Object,
    transition: Boolean,
});

const img = ref(null);
const loaded = ref(false);
const initialLoad = ref(false);
const imgWidth = ref("100%");
const notMounted = ref(true);

watch(
    () => props.transition,
    (newValue) => {
        if (newValue === true) loaded.value = false;
    }
);

onBeforeMount(() => {
    emit("load-needed");
    useEventListener(window, "resize", updateImageClientWidth);
});

onMounted(() => {
    notMounted.value = false;
});

const imgLoaded = () => {
    setTimeout(() => {
        if (initialLoad.value === false) {
            initialLoad.value = true;
            emit("loaded");
        }
        loaded.value = true;
    }, 250);
};

function updateImageClientWidth() {
    imgWidth.value = img.value.clientWidth + "px";
}
</script>
<template>
    <transition
        @enter="updateImageClientWidth"
        @after-enter="updateImageClientWidth"
    >
        <div
            class="painting"
            v-bind="$attrs"
            v-show="(!transition && loaded) || notMounted"
        >
            <div class="img-holder">
                <img
                    ref="img"
                    :alt="painting.title"
                    :src="painting.images[0].url"
                    @load="imgLoaded"
                />
            </div>
            <div class="buttons" :style="{ width: imgWidth }">
                <a :href="painting.images[0].url" target="_blank"
                    ><Button>Pleine résolution</Button></a
                >

                <Video
                    v-if="painting.video"
                    :video-id="painting.video"
                    :reset="transition"
                ></Video>
            </div>
        </div>
    </transition>

    <transition>
        <div class="loading" v-show="!loaded" v-if="notMounted === false">
            <LoadIndicator />
        </div>
    </transition>
</template>
<style lang="scss" scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.loading {
    position: absolute;
}

.buttons {
    display: flex;
    justify-content: space-between;
}

.painting {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;

    max-height: 100%;
    max-width: 100%;

    height: 100%;
}

.img-holder {
    overflow: hidden;
    object-fit: contain;

    display: flex;
    justify-content: center;
    align-items: center;
}

img {
    max-height: 100%;
    max-width: 100%;
}
</style>
