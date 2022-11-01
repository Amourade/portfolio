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
    projects: Object,
});
</script>

<template>
    <Head>
        <title>Voir les projets</title>
    </Head>
    <PageTitle>Projets</PageTitle>

    <ItemsGrid :items="projects" action="projects" />
</template>
