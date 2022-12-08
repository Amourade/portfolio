<script setup>
import Video from "@/Components/About/Video.vue";
import ThreeOne from "@/Components/About/Three/One.vue";
import ThreeTwo from "@/Components/About/Three/Two.vue";
import { onBeforeMount, onMounted, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
//import ThreeOne from "@/Components/Home/Three/Satan.vue";
const mounted = ref(false);

const toLoad = ref(0);
const loaded = ref(0);
const loadDone = ref(true);
const goingHome = ref(false);

onBeforeMount(() => {
    loadDone.value = false;
});

onMounted(() => {
    loadDone.value = true;
    mounted.value = true;
});

watch(loaded, (value) => {
    if (value === toLoad.value) loadDone.value = true;
});

const changePage = (e) => {
    goingHome.value = true;
    setTimeout(() => {
        Inertia.visit(e);
    }, 150);
};
</script>
<template>
    <Head>
        <title>À Propos</title>
    </Head>

    <transition>
        <div class="loader" v-if="!loadDone"></div>
    </transition>

    <Transition name="going-home">
        <div class="going-home" v-if="goingHome"></div>
    </Transition>

    <div id="about">
        <div class="scroll-container">
            <ThreeOne></ThreeOne>
            <ThreeTwo></ThreeTwo>
            <main>
                <p>
                    S’il vous plaît, appréciez le contenu de ce site comme bon
                    vous semble. Les oeuvres présentées le sont de manière
                    incertaines; cet endroit les archivent et présentent sans
                    discrimination.
                </p>

                <p>
                    Je m’intéresse aux divers ponts qui mènent les experiences
                    les unes aux autres.
                </p>

                <p>
                    <a @click.prevent="changePage('/cv')" href="/cv">
                        <em>
                            <strong>cv</strong>
                        </em>
                    </a>
                </p>

                <p>
                    <a href="mailto: theriault.antoine@gmail.com"
                        >theriault.antoine@gmail.com</a
                    >
                </p>
                <a @click.prevent="changePage('/')" class="return" href="/">
                    Retour
                </a>
            </main>
            <Video
                v-if="mounted"
                data-moveable-close="true"
                videoId="n3kN4hrvEKg"
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
    background: #f0f1e4;
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

#three-two {
    display: block;
    width: 150px;
    height: 175px;
    cursor: crosshair;
    position: absolute;
    bottom: 50px;
    left: 100px;
}

#about {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    border: 8px #b7dcf0 outset;
    display: block;
    width: 100%;
    min-height: 100vh;
    position: absolute;
    background-image: url("Assets/images/about/0140.webp");
    background-size: 100% 100%;
    overflow: hidden;

    font-family: serif;
}
.scroll-container {
    width: 100%;
    height: 100%;
    position: absolute;
    overflow: auto;
}

main {
    max-width: 70%;
    min-height: 50%;
    border: 1px black solid;
    position: absolute;
    top: 50px;
    left: 50px;

    p {
        margin: 25px 0px;
        background-color: white;
        color: black;
        float: left;
        clear: left;
        box-shadow: 1px 1px 1px black;
        line-height: 1.2em;
    }

    a {
        text-decoration: none;
        color: rgb(66, 81, 216);

        &:hover {
            color: purple;
        }
    }
}
.return {
    position: absolute;
    display: block;
    bottom: 10px;
    right: 10px;
    padding: 10px 20px 20px 20px;
    font-family: "ferrum";
    font-size: 2em;
    color: white;
    background-color: black;
    -ms-transform: rotate(-30deg); /* IE 9 */
    -webkit-transform: rotate(-30deg); /* Chrome, Safari, Opera */
    transform: rotate(-30deg);
    border: 3px black outset;

    &:hover {
        background-color: white;
        color: black;
    }
}

@media (max-width: 768px) {
    .return {
        bottom: -30px;
        right: -30px;
    }
}
</style>
