<script>
import DrawingsLayout from "@/Layouts/Drawings.vue";

export default {
    layout: DrawingsLayout,

    props: {
        drawings: Object,
        currentDrawing: Object,
    },
};
</script>
<template>
    <Head>
        <title>{{ currentDrawing.title }}</title>
    </Head>
</template>
<style lang="scss" scoped></style>
