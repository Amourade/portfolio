<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";
import SideMenuItem from "./SideMenuItem.vue";
import { useMq } from "vue3-mq";

const mq = useMq();
const emit = defineEmits(["navigation"]);
const props = defineProps({
    currentPainting: Object,
    paintings: Object,
});
const container = ref(null);

const thumbPosition = ref(0);
const showMenu = ref(false);

onMounted(() => {
    container.value.addEventListener("mousemove", updateThumb);
});

onBeforeUnmount(() => {
    container.value.removeEventListener("mousemove", updateThumb);
});

function updateThumb(e) {
    thumbPosition.value = e.clientY;
}

function navigate(e) {
    showMenu.value = false;
    emit("navigation", e);
}
</script>
<template>
    <aside :class="{ open: showMenu }">
        <div
            id="thumb-holder"
            v-show="mq.current === 'lg'"
            :style="{ top: thumbPosition + 'px' }"
        ></div>
        <div class="container" ref="container">
            <h3 class="show-menu" @click.prevent="showMenu = !showMenu">
                <a href="#">Menu</a>
            </h3>
            <div class="side-nav">
                <ul>
                    <template v-for="(year, key) in paintings">
                        <li>
                            <h3>{{ year[0].date }}</h3>
                        </li>
                        <template v-for="painting in year">
                            <SideMenuItem
                                :class="{
                                    active: currentPainting.id == painting.id,
                                }"
                                @navigation="navigate"
                                :painting="painting"
                            />
                        </template>
                    </template>
                </ul>
            </div>
        </div>
    </aside>
</template>
<style lang="scss" scoped>
@import "Css/painting-variables.scss";

aside {
    width: 24%;
    max-height: 100%;
    max-width: 400px;

    position: relative;
    padding-top: 1%;
    padding-left: 1%;
    transition: max-width 0.5s ease;
}
.container {
    max-width: 100%;
    box-shadow: 0px 0px 0px 1px #43536b, 60px 60px 50px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
    display: block;
    overflow: hidden;
    border: 1px white outset;
    z-index: 2;
    min-height: 60px;
    transition: height 0.5s ease;

    width: 100%;
    height: 100%;
    display: block;
    overflow: hidden;
    z-index: 1;

    font-size: 16px;
    font-family: "Times New Roman", Times, serif;
}

@media (max-width: 768px) {
    aside {
        width: 100%;
        max-width: 92%;
        height: calc(60px + 1%);

        //position: absolute;
        padding: 1%;

        z-index: 8;

        &.open {
            max-width: 100%;

            .container {
                height: 90vh;
            }
        }
    }
    .container {
        height: 0%;
        //position: absolute;
        width: 100%;

        z-index: 8;

        &.open {
            height: 90vh;
        }
    }
}

#thumb-holder {
    position: absolute;
    right: 0px;

    transform: translateX(90%) translateY(-50%);
    z-index: 5;
}

h3 {
    font-size: 1.5em;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 10px 14px 10px;
    color: white;
    font-family: "ferrum";
    text-transform: uppercase;
    font-weight: 200;
    border: 3px white outset;
    text-shadow: 1px 2px 2px #000000;
    background: rgb(255, 255, 255);
    background: $titleBaseColor;
    text-align: center;
}

.show-menu {
    height: 60px;
    position: absolute;
    width: 100%;
    z-index: 2;
    cursor: pointer;
    background: $buttonBaseColor;
    display: none;
    align-content: center;
    justify-content: center;

    &:hover {
        background: $buttonHoverColor;
    }

    a {
        color: white;
        text-decoration: none;
    }
}

@media (max-width: 768px) {
    .show-menu {
        display: flex;
    }
}

.side-nav {
    overflow-y: auto;
    height: 100%;
    position: absolute;
    left: 0px;
    padding-top: 0px;
    min-height: 60px;
    z-index: 1;

    width: calc(100% + 17px);

    ul {
        padding: 0;
    }

    li:last-child li:last-child a {
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }
}

@media (max-width: 768px) {
    .side-nav ul {
        padding: 60px 0 0 0;
    }
}
</style>
