<script>
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<template>
    <Head><title>Admin</title></Head>
    <div id="home-seller">
        <div class="text">
            <h1>BONJOUR</h1>
            <h2>ON LAISSE PAS TOMBER</h2>
        </div>
    </div>
</template>

<style scoped>
#home-seller {
    background: url("Assets/images/admin/vendeur.webp");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;

    width: 100%;
    height: 100%;

    min-height: 600px;

    display: flex;
    align-items: center;
    flex-direction: column;

    text-align: center;
}

.text {
    background: rgba(255, 255, 255, 0.6);
    padding: 20px;
    border-radius: 25px;
    box-shadow: 4px 4px 4px 0px rgba(0, 0, 0, 0.3),
        0px 0px 0px 1px rgba(0, 0, 0, 0.3);
    border: 1px solid white;
}
</style>
