<script>
import AdminLayout from "@/Layouts/Admin.vue";

export default {
    layout: AdminLayout,
};
</script>
<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Input from "@/Components/Admin/Input.vue";
import FilesField from "@/Components/Admin/FilesField.vue";
import FormHolder from "@/Components/Admin/FormHolder.vue";
import Button from "@/Components/Admin/Button.vue";
import PageTitle from "@/Components/Admin/PageTitle.vue";

let form = useForm({
    title: null,
    slug: null,
    video: null,
    images: [],
    creation_date: null,
});

let submit = () => {
    form.post("/admin/digitals", { preserveScroll: true });
};
</script>

<template>
    <Head>
        <title>Créer un digital</title>
    </Head>
    <PageTitle>Créer un Digital</PageTitle>

    <FormHolder>
        <form @submit.prevent="submit">
            <Input
                v-model="form.title"
                name="title"
                :error="form.errors.title"
            />
            <Input v-model="form.video" name="video" :required="false" />
            <Input v-model="form.slug" name="slug" :error="form.errors.slug" />

            <FilesField
                v-model:images="form.images"
                name="Image(s?)"
                :errors="form.errors"
            />

            <Input
                v-model="form.creation_date"
                name="date"
                :error="form.errors.creation_date"
                type="date"
            />

            <div>
                <Button type="submit" :disabled="form.processing"
                    >Submit</Button
                >
            </div>
        </form>
    </FormHolder>
</template>
