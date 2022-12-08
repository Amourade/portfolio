<script setup>
import { Inertia } from "@inertiajs/inertia";
import { computed } from "@vue/reactivity";
import { onBeforeUnmount, ref } from "vue";
import SideMenu from "@/Components/Paintings/Show/SideMenu.vue";
import DropdownMenu from "@/Components/Paintings/Show/DropdownMenu.vue";
import CloseLink from "@/Components/Paintings/Show/CloseLink.vue";
import RandomLink from "@/Components/Paintings/Show/RandomLink.vue";
import Corridor from "@/Components/Paintings/Show/Corridor/Index.vue";
import Painting from "@/Components/Paintings/Show/Painting.vue";
import LoadIndicator from "@/Components/Paintings/Show/LoadIndicator.vue";

//InertiaProgress.init({ color: "#ff00ff", includeCSS: false });

const props = defineProps({
    painting: Object,
    paintings: Object,
});

const fadeSpeed = 250;
const transitionPainting = ref(false);
const toLoad = ref(0);
const goingHome = ref(false);
const loaded = ref(0);

const ptngsList = computed(() => {
    let ptngs = [];
    for (var i = 0; i < props.paintings.length; i++) {
        for (var j = 0; j < props.paintings[i].length; j++) {
            ptngs.push(props.paintings[i][j]);
        }
    }
    return ptngs;
});

let random = () => {
    const randomPainting =
        ptngsList.value[Math.floor(Math.random() * ptngsList.value.length)]
            .slug;
    navigation(randomPainting);
};

let navTimeout = null;

let navigation = (e) => {
    if (e !== props.painting.slug) {
        transitionPainting.value = true;

        if (navTimeout) clearTimeout(navTimeout);
        navTimeout = setTimeout(() => {
            transitionPainting.value = false;
            Inertia.visit(e, {
                preserveState: true,
                only: ["painting"],
            });
        }, fadeSpeed);
    }
};

let changePage = (e) => {
    goingHome.value = true;
    setTimeout(() => {
        Inertia.visit(e);
    }, 150);
};

onBeforeUnmount(() => {
    if (navTimeout) clearTimeout(navTimeout);
});

const loadDone = computed(() => {
    return toLoad.value === loaded.value;
    //return true;
});
</script>

<template>
    <Head>
        <title>{{ painting.title }}</title>
    </Head>
    <Transition appear>
        <div class="loader" v-if="!loadDone">
            <div class="inside">
                <LoadIndicator />
            </div>
        </div>
    </Transition>
    <Transition name="going-home">
        <div class="going-home" v-if="goingHome"></div>
    </Transition>

    <div class="page">
        <Corridor @load-needed="toLoad++" @loaded="loaded++" />
        <div class="top">
            <CloseLink @changePage="changePage" />
            <SideMenu
                @navigation="navigation"
                :paintings="paintings"
                :currentPainting="painting"
            />
            <main>
                <Painting
                    @load-needed="toLoad++"
                    @loaded="loaded++"
                    :transition="transitionPainting"
                    :style="{ transitionDuration: fadeSpeed / 1000 + 's' }"
                    :painting="painting"
                />
            </main>
        </div>
        <div class="bottom">
            <RandomLink @random="random" />
            <DropdownMenu
                @selectChange="navigation"
                :paintings="paintings"
                :currentPainting="painting"
            />
        </div>
    </div>
</template>
<style lang="scss" scoped>
@font-face {
    font-family: "ferrum";
    src: url("Assets/fonts/ferrum/ferrum.otf") format("opentype");
    font-weight: 200;
    font-style: normal;
}

body {
    font-family: "Times New Roman", Times, serif;
}
.v-enter-active {
    transition: none;
}

.v-enter-from {
    opacity: 1;
}

.v-enter-active .inside,
.v-leave-active .inside {
    transition: opacity 0.5s linear;
}

.v-enter-from .inside,
.v-leave-to .inside {
    opacity: 0;
}

.v-leave-active {
    transition: opacity 3s linear;
}

.v-leave-to {
    opacity: 0;
}

.loader {
    background: white;
    position: absolute;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}

.going-home-enter-active,
.going-home-leave-active {
    transition: all 0.3s linear;
}

.going-home-enter-from,
.going-home-leave-to {
    opacity: 0;
}

.going-home {
    background: black;
    position: absolute;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}

.page {
    overflow: hidden;
    height: 100vh;
    width: 100vw;
    max-width: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.top {
    display: flex;
    //flex-wrap: wrap;
    justify-content: space-between;
    z-index: 1;

    height: 88%;
}

@media (max-width: 768px) {
    .top {
        z-index: 6;
    }
}

.bottom {
    flex-grow: 1;

    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    max-width: 100%;

    padding: 1%;
}

main {
    max-height: 100%;

    max-width: max(76%, calc(100% - 400px));

    flex-grow: 1;

    padding: 1% 1% 0 1%;
    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 1;
}

@media (max-width: 768px) {
    .top {
        flex-direction: column;
    }

    main {
        max-width: 100%;
        max-height: calc(100% - 60px);
    }
}
</style>
