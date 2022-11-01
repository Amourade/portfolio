<script>
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import FormHolder from "@/Components/Admin/FormHolder.vue";
import Input from "@/Components/Admin/Input.vue";
import PageTitle from "@/Components/Admin/PageTitle.vue";
import Button from "@/Components/Admin/Button.vue";

let form = useForm({
    email: null,
    password: null,
});

let submit = () => {
    form.post("/admin/login", { preserveScroll: true });
};
</script>
<template>
    <Head>
        <title>IDENTIFICATION</title>
    </Head>
    <form>
        <PageTitle>On se connecte SVP</PageTitle>
        <FormHolder>
            <form @submit.prevent="submit">
                <Input
                    v-model="form.email"
                    name="email"
                    :error="form.errors.emailpassword"
                    type="email"
                />
                <Input
                    v-model="form.password"
                    name="password"
                    :error="form.errors.password"
                    type="password"
                />

                <div>
                    <Button type="submit" :disabled="form.processing"
                        >Voilà les infos</Button
                    >
                </div>
            </form>
        </FormHolder>
    </form>
</template>

<style scoped>
form {
    justify-content: center;
    text-align: center;
}
</style>
