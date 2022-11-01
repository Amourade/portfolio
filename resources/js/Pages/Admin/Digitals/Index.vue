<script>
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<script setup>
import ItemsGrid from "@/Components/Admin/ItemsGrid.vue";
import PageTitle from "@/Components/Admin/PageTitle.vue";
defineProps({
    digitals: Object,
});
</script>

<template>
    <Head>
        <title>Voir les digitaux</title>
    </Head>
    <PageTitle>Digitaux</PageTitle>

    <ItemsGrid :items="digitals" action="digitals" />
</template>
