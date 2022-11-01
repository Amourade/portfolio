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
    drawings: Object,
});
</script>

<template>
    <Head>
        <title>Voir les dessins</title>
    </Head>
    <PageTitle>Dessins</PageTitle>

    <ItemsGrid :items="drawings" action="drawings" />
</template>
