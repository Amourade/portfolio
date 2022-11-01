<script setup>
import { ref } from "vue";

const props = defineProps({
    drawings: Object,
    highlight: String,
    currentDrawing: Object,
});

const menuOpen = ref(false);
</script>
<template>
    <nav>
        <h3 @click.prevent="menuOpen = !menuOpen"><a href="#">Menu</a></h3>
        <div class="nav-wrapper" :class="{ open: menuOpen }">
            <div class="list-wrapper">
                <ul>
                    <li class="home">
                        <Link href="/">Accueil - Home</Link>
                    </li>
                    <li v-for="drawing in drawings">
                        <a
                            :only="['currentDrawing']"
                            :href="drawing.slug"
                            @click.prevent="$emit('navigate', drawing.slug)"
                            :class="{
                                hover: highlight === drawing.slug,
                                active:
                                    currentDrawing &&
                                    currentDrawing.slug === drawing.slug,
                            }"
                            @mouseenter="$emit('hover', drawing.slug)"
                            @mouseleave="$emit('out')"
                            ><span>{{ drawing.title }}</span
                            ><img :src="drawing.images[0].thumb"
                        /></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<style lang="scss" scoped>
nav {
    z-index: 2;
    position: absolute;
    top: 10px;
    left: 10px;
    border: 1px solid black;
    padding: 5px 20px 5px 10px;
    background-color: white;
}

h3 {
    text-align: center;
    cursor: pointer;
    padding: 5px 0;

    &:hover {
        color: blue;
    }

    a {
        color: inherit;
    }
}

a {
    color: black;
    text-decoration: none;

    &:hover,
    &.hover,
    &.active {
        color: blue;
    }
}

.nav-wrapper {
    position: relative;
    overflow: hidden;
    max-width: 500px;

    width: 0vw;
    height: 0vh;

    transition: all 1s;

    &.open {
        width: 80vw;
        height: 80vh;
    }
}

.list-wrapper {
    position: absolute;
    overflow-y: auto;
    left: 0px;
    right: -17px;
    max-height: 100%;
}

ul {
    padding: 0;
}

li {
    list-style-type: none;
    overflow: hidden;

    a {
        padding: 5px 0;
        display: flex;
        color: black;
        position: relative;
        align-items: center;
        justify-content: space-between;
    }

    span {
        color: inherit;
        max-width: 80%;
    }

    img {
        border-radius: 5px;
        border: 1px solid black;
        max-width: 150px;
        width: 20%;
    }
}

.home {
    border-bottom: 1px solid black;
    border-top: 1px solid black;
    text-align: center;
    padding: 10px 0;

    a {
        display: inline;
        white-space: nowrap;
    }
}
</style>
