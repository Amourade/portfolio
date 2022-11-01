<script setup>
import { reactive, ref, computed, onMounted, onBeforeMount } from "vue";
import imagePeintures from "Assets/images/home/menu/peintures.jpg";
//import imagePeintures from "/images/home/menu/peintures.jpg";
import imageDessins from "Assets/images/home/menu/dessins.jpg";
import imageDigital from "Assets/images/home/menu/digital.jpg";
import imageProjets from "Assets/images/home/menu/projets.jpg";
import imageAPropos from "Assets/images/home/menu/a-propos.jpg";
import fenetre from "Assets/images/home/menu/fenetre.png";
import capsule from "Assets/images/home/menu/capsule-nav.png";

const menuObj = [
    {
        label: "Peintures",
        img: imagePeintures,
        url: "/peintures",
        hovered: ref(false),
    },
    {
        label: "Dessins",
        img: imageDessins,
        url: "/dessins",
        hovered: ref(false),
    },
    {
        label: "Peintures Digitales",
        img: imageDigital,
        url: "/digitaux",
        hovered: ref(false),
    },
    {
        label: "Projets",
        img: imageProjets,
        url: "/projets",
        hovered: ref(false),
    },
    {
        label: "À Propos",
        img: imageAPropos,
        url: "/a-propos",
        hovered: ref(false),
    },
];

const toLoad = ref(0);
const loaded = ref(0);
const imgsToLoad = [
    imagePeintures,
    imageDessins,
    imageDigital,
    imageProjets,
    imageAPropos,
    fenetre,
    capsule,
];

onBeforeMount(() => {
    toLoad.value = imgsToLoad.length;
    imgsToLoad.forEach((item, index) => {
        let img = new Image();
        img.src = item;
        img.onload = () => {
            loaded.value++;
        };
    });
});

const loadDone = computed(() => {
    return toLoad.value === loaded.value;
});

const isMounted = ref(false);

onMounted(() => {
    isMounted.value = true;
});
</script>
>

<template>
    <ul v-moveable :class="{ loaded: loadDone }">
        <li v-for="item in menuObj">
            <Link
                @mouseenter="item.hovered.value = true"
                @mouseleave="item.hovered.value = false"
                :href="item.url"
                :style="{ backgroundImage: 'url(' + capsule + ')' }"
                >{{ item.label }}</Link
            >
        </li>
    </ul>

    <teleport to="#window-teleport" v-if="isMounted">
        <div id="window" :class="{ loaded: loadDone }">
            <TransitionGroup name="list">
                <img
                    v-for="(item, index) in menuObj"
                    :key="index"
                    v-show="item.hovered.value"
                    :src="item.img"
                />
            </TransitionGroup>
            <div
                class="top"
                :style="{ backgroundImage: 'url(' + fenetre + ')' }"
            ></div>
        </div>
    </teleport>
</template>

<style lang="scss" scoped>
/**Window Styling */
#window {
    position: absolute;
    top: 0px;
    left: 0px;

    width: 333px;
    height: 500px;

    max-width: 100vw;

    opacity: 0;
    transition: opacity 1s;

    &.loaded {
        opacity: 1;
    }
}

#window .top {
    content: "";
    width: 100%;
    height: 100%;
    position: absolute;

    background-size: contain;
    box-shadow: 0px 0px 100px 100px black;

    z-index: 2;
}

#window img {
    position: absolute;

    height: 100%;
    width: 100%;

    z-index: 1;
}

/**Animations */
.list-move,
.list-enter-active,
.list-leave-active {
    transition: opacity 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
}

/**Menu Styling */

ul {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    z-index: 2;

    opacity: 0;
    transition: opacity 1s;

    &.loaded {
        opacity: 1;
    }

    li {
        list-style-type: none;
        padding: 10px;
    }

    li a {
        font-size: 30px;
        display: block;
        width: 279px;
        height: 50px;
        text-align: center;
        text-decoration: none;

        color: rgba(0, 0, 0, 0.3);
        text-shadow: 0 -1px 0 #edee63;

        background-position-y: top;
    }

    li a:hover {
        color: rgba(255, 255, 255, 0.5);
        background-position-y: bottom;
    }
}
</style>
