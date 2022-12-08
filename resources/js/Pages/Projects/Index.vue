<script setup>
import { Inertia } from "@inertiajs/inertia";
import { onBeforeMount, onMounted, watch, ref } from "vue";

defineProps({
    projects: Object,
});

const toLoad = ref(0);
const loaded = ref(0);
const loadDone = ref(true);
const goingHome = ref(false);

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
    goingHome.value = true;
    setTimeout(() => {
        Inertia.visit(e);
    }, 150);
};
</script>
<template>
    <Head>
        <title>Projets</title>
    </Head>

    <transition>
        <div class="loader" v-if="!loadDone"></div>
    </transition>

    <Transition name="going-home">
        <div class="going-home" v-if="goingHome"></div>
    </Transition>

    <div id="projects">
        <a @click.prevent="changePage('/')" class="return" href="/">Accueil</a>
        <main>
            <div
                class="project"
                v-for="project in projects"
                :key="project.title"
            >
                <div class="description">
                    <h3>
                        <a target="_blank" :href="project.url">{{
                            project.title
                        }}</a>
                    </h3>
                    {{ project.description }}
                </div>
                <div class="image">
                    <a target="_blank" :href="project.url"
                        ><img
                            :alt="project.title"
                            :src="project.images[0].thumb"
                    /></a>
                </div>
            </div>
        </main>
    </div>
</template>
<style lang="scss" scoped>
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
    background: #71c2dd;
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
#projects {
    background: url("Assets/images/projects/back.webp");
    background-position: center top;
    min-height: 100vh;

    color: black;

    font-family: serif;
}

.return {
    position: absolute;
    top: 15px;
    right: 30px;
    font-size: 1.4em;
    display: block;
    background-color: #3b54b0;
    background: linear-gradient(
        180deg,
        rgba(223, 214, 238, 1) 0%,
        rgba(195, 200, 237, 1) 46%,
        rgba(158, 182, 236, 1) 90%,
        rgba(57, 29, 117, 1) 100%
    );
    border: 2px #d7d953 ridge;
    border-radius: 6px;
    padding: 10px;
    font-weight: bold;
    color: black;
    font-variant: small-caps;
    text-shadow: 1px 1px 0px #9eb6ec, 1px -1px 0px white, -1px 1px 0px #9eb6ec,
        -1px -1px 0px white;

    z-index: 2;
    text-decoration: none;

    &:hover {
        background: linear-gradient(
            180deg,
            rgba(223, 214, 238, 0.7) 0%,
            rgba(195, 200, 237, 0.7) 46%,
            rgba(158, 182, 236, 0.7) 90%,
            rgba(57, 29, 117, 0.7) 100%
        );
    }
}

main {
    padding: 150px 3% 3% 3%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.project {
    text-align: center;
    padding: 15px 15px 15px 15px;
    float: left;
    min-width: 300px;
    border: #d7d953 3px ridge;
    border-radius: 4px;
    clear: left;
    margin-bottom: 40px;
    position: relative;
    background-color: white;
    background: linear-gradient(
        180deg,
        rgba(158, 182, 236, 0.45420166357558645) 0%,
        rgba(223, 214, 238, 0.3141456411666229) 48%,
        rgba(157, 23, 16, 0.4878151089537377) 100%
    );
    background: linear-gradient(
        180deg,
        rgba(223, 214, 238, 0.7) 0%,
        rgba(195, 200, 237, 0.7) 46%,
        rgba(158, 182, 236, 0.7) 70%,
        rgba(57, 29, 117, 0.7) 100%
    );
    box-shadow: 0px 0px 0px 1px #9eb6ec, 20px 20px 20px rgba(0, 0, 0, 0.5);

    display: grid;
    grid-template-columns: 70% 30%;
    align-items: center;

    &:hover {
        background-color: white;
        box-shadow: 0px 0px 0px 1px black, 20px 20px 20px rgba(0, 0, 0, 0.8);

        .image {
            opacity: 1;
        }
    }
}

.description {
    h3 {
        margin-bottom: 40px;
        font-weight: bold;
        font-size: 1.4em;
    }

    p {
        text-align: center;
        margin-bottom: 15px;
        max-width: 600px;
        line-height: 1.5em;
    }

    a {
        border-bottom: 1px #b4beed solid;
        color: black;
        text-shadow: 1px 1px 0px #9eb6ec, 1px -1px 0px white,
            -1px 1px 0px #9eb6ec, -1px -1px 0px white;
        font-variant: small-caps;

        font-weight: inherit;

        &:hover {
            background-color: lightblue;
            cursor: alias;
        }
    }
}

.image {
    display: flex;
    opacity: 0.7;

    img {
        max-height: 180px;
        max-width: 100%;
        border-radius: 5px;
        border: 1px white outset;
        box-shadow: 0px 0px 0px 1px #9eb6ec;

        &:hover {
            border: 1px black outset;
            cursor: alias;
        }
    }
}

@media (max-width: 768px) {
    .description h3 {
        margin-bottom: 0px;
    }
}
</style>
