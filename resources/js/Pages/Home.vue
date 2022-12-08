<script setup>
import Items from "@/Components/Home/Items.vue";
import Clock from "@/Components/Home/Clock.vue";
import Satan from "@/Components/Home/Three/Satan.vue";
import Model from "@/Components/Home/Three/Model.vue";
import Nav from "@/Components/Home/Nav.vue";
import webImage from "Assets/images/home/web.webp";
import { computed, nextTick, onBeforeMount, onMounted, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";

defineProps({
    works: Object,
});

const toLoad = ref(0);
const loaded = ref(0);
const loadDone = ref(true);
const goingAway = ref(false);
const fadeColor = ref(null);

onBeforeMount(() => {
    loadDone.value = false;
});

onMounted(() => {
    loadDone.value = true;
});

watch(loaded, (value) => {
    if (value === toLoad.value) loadDone.value = true;
});

const changePage = (e) => {
    console.log(e);

    goingAway.value = true;
    fadeColor.value = e.color;
    setTimeout(() => {
        Inertia.visit(e.url);
    }, 150);
};
</script>

<template>
    <Head>
        <title>Bienvenue</title>
    </Head>

    <transition>
        <div class="loader" v-if="!loadDone"></div>
    </transition>

    <Transition name="going-away">
        <div
            class="going-away"
            :style="{ background: fadeColor }"
            v-if="goingAway"
        ></div>
    </Transition>

    <div id="app-body">
        <div v-moveable class="web-portfolio">
            <a
                class="destination"
                href="http://web.antoinetheriault.com"
                alt="Web Portfolio"
            >
                <img :src="webImage" alt="Web Portfolio" />
            </a>
        </div>

        <div id="window-teleport"></div>

        <header>
            <Nav @changePage="changePage" />
        </header>

        <Clock />

        <Satan />

        <Model />

        <main>
            <Items :Items="works" />
        </main>
    </div>
</template>

<style lang="scss" scoped>
/** Typo */
@import url("https://fonts.googleapis.com/css2?family=Jim+Nightshade&family=Tangerine&display=swap");

.v-enter-active {
    transition: none;
}

.v-enter-from {
    opacity: 1;
}

.v-leave-active {
    transition: opacity 1s linear;
}

.v-leave-to {
    opacity: 0;
}

.loader {
    background: black;
    position: fixed;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}

.going-away-enter-active,
.going-away-leave-active {
    transition: all 0.3s linear;
}

.going-away-enter-from,
.going-away-leave-to {
    opacity: 0;
}

.going-away {
    background: black;
    position: fixed;
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 100;
}

#app-body {
    width: 100%;
    height: 100%;
    position: relative;
    font-family: "Jim Nightshade", serif;
    background: radial-gradient(
        circle,
        black 0%,
        #302c25 34%,
        #1b0a37 66%,
        black 100%
    );
}

.web-portfolio {
    left: 10px;
    opacity: 0.7;
    position: fixed;
    top: 10px;
    transition: opacity 0.5s linear;
    z-index: 10;

    transition: opacity 0.5 linear;

    &:hover,
    &.moveable-moving {
        opacity: 1;
    }

    a {
        background: transparent;
        border: 1px solid hsla(0, 0%, 100%, 0.7);
        border-radius: 10px;
        box-shadow: 0 0 1px #000000b3, 15px 15px 15px #0000004d;
        color: #0b0000;
        position: relative;
        text-decoration: none;
        text-shadow: 2px 2px 3px rgb(0 0 0 / 50%);
        transition: box-shadow 0.5s linear, color 0.5s linear,
            text-shadow 0.5s linear;
        z-index: 1;

        cursor: alias;
        display: flex;
        padding: 10px;

        img {
            border: 1px solid rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            box-shadow: 0 0 1px 1px #ffffffb3;
        }

        &:hover {
            box-shadow: 0 0 1px #000000b3, 1px 1px 1px #000001;
            color: #e3deda;
            text-shadow: 1px 1px 1px rgb(0 0 0 / 50%);

            &::before {
                opacity: 1;
            }
        }

        &::before,
        &::after {
            border-radius: inherit;
            content: "";
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        &::before {
            background: linear-gradient(0deg, #4a574b, #8bb873);
            opacity: 0;
            transition: opacity 0.5s linear;
            z-index: -1;
        }

        &::after {
            background: linear-gradient(0deg, #a5a1a2, #e7ebcb);
            z-index: -2;
        }
    }
}

#window-teleport {
    position: fixed;
    top: 50px;
    left: 10px;
}

main {
    z-index: 1;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
}
@media (hover: hover) {
    a:hover {
        background-color: hsla(160, 100%, 37%, 0.2);
    }
}

@media (min-width: 1024px) {
    body {
    }

    #app {
    }

    header {
    }

    header .wrapper {
    }

    .logo {
    }
}
</style>
