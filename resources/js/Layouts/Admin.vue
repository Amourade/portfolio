<script setup>
import { reactive, ref, watch } from "vue";
import Nav from "@/Components/Admin/Nav.vue";
import NavLink from "@/Components/Admin/NavLink.vue";

const props = defineProps({
    flash: Object,
});
const showAlert = ref(true);
const alerts = reactive(props);

watch(
    () => alerts.flash,
    () => {
        showAlert.value = false;
        setTimeout(() => {
            showAlert.value = true;
        }, 1);
    }
);
</script>

<template>
    <Head>
        <title>My name</title>
    </Head>

    <div id="app-body">
        <div
            v-if="$page.props.flash.success && showAlert"
            :class="{ alert: showAlert }"
        >
            {{ $page.props.flash.success }}
        </div>

        <header>
            <div class="banner">
                <h1>
                    <Link href="/admin">Bienvenue à la maison</Link>
                </h1>

                <template v-if="$page.props.auth.user">
                    <NavLink
                        href="/admin/logout"
                        method="POST"
                        as="button"
                        type="button"
                        >Partir</NavLink
                    >
                </template>
            </div>
            <Nav />
        </header>

        <main>
            <div>
                <slot />
            </div>
        </main>
    </div>
</template>
<style>
@import url("https://fonts.googleapis.com/css2?family=Caveat:wght@500&display=swap");
</style>

<style lang="scss" scoped>
.alert {
    position: fixed;
    left: 10px;
    top: 10px;
    padding: 15px;
    background: #d3e6ab;
    font-size: 1.4em;
    border-radius: 30px;
    box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.5), 0px 0px 0px 2px white;
    border: 1px solid #0a4710;
    color: #1b031a;

    z-index: 2;

    animation: flashMessage 5s;
    animation-fill-mode: forwards;
}

.banner {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-around;

    text-align: center;

    * {
        margin: 0 10px;
    }
}

@keyframes flashMessage {
    0% {
        color: white;
        background: white;
        border: 1px solid white;
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0), 0px 0px 0px 2px white;
        opacity: 0;
    }

    5% {
        color: #1b031a;
        background: #d3e6ab;
        border: 1px solid #0a4710;
        box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.5), 0px 0px 0px 2px white;
        opacity: 1;
    }

    80% {
        color: #1b031a;
        background: #d3e6ab;
        border: 1px solid #0a4710;
        box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.5), 0px 0px 0px 2px white;
        opacity: 1;
    }

    100% {
        color: white;
        background: white;
        border: 1px solid white;
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0), 0px 0px 0px 2px white;
        opacity: 0;
    }
}

#app-body {
    background-color: #a1c8d2;
    border: 3px solid #795980;

    font-family: "Caveat", cursive;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    min-height: 100vh;
}

h1 {
    font-style: italic;

    border-bottom: 1px solid #795980;

    a {
        text-decoration: none;
        color: inherit;
    }
}

header {
    max-width: 1000px;
    margin: 0 auto;

    display: flex;
    flex-direction: column;
    align-items: center;
}

main {
    max-width: 1000px;
    width: 100%;
    margin: 50px auto;
    flex-grow: 1;

    display: grid;
}
</style>
