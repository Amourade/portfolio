<script setup>
import Items from "@/Components/Home/Items.vue";
import Clock from "@/Components/Home/Clock.vue";
import Satan from "@/Components/Home/Three/Satan.vue";
import Model from "@/Components/Home/Three/Model.vue";
import Nav from "@/Components/Home/Nav.vue";
import { onMounted } from "vue";

defineProps({
    works: Object,
});
</script>

<template>
    <Head>
        <title>Bienvenue</title>
    </Head>

    <div id="app-body">
        <div id="window-teleport"></div>

        <header>
            <Nav />
        </header>

        <Clock />

        <Satan />

        <Model />

        <main>
            <Items :Items="works" />
        </main>
    </div>
</template>

<style scoped>
/** Typo */
@import url("https://fonts.googleapis.com/css2?family=Jim+Nightshade&family=Tangerine");

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
