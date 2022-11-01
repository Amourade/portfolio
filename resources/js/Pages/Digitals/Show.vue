<script>
import digitalsLayout from "@/Layouts/Digitals.vue";

export default {
    layout: digitalsLayout,

    props: {
        digitals: Object,
        current: Object,
    },
};
</script>
<template>
    <Head>
        <title>{{ current.title }}</title>
    </Head>
</template>
