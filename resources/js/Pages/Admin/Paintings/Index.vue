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
    paintings: Object,
});
</script>

<template>
    <Head>
        <title>Voir les peintures</title>
    </Head>
    <PageTitle>Peintures</PageTitle>

    <ItemsGrid :items="paintings" action="paintings" />
</template>
