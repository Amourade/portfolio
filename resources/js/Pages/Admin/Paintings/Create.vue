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
import FormDimensions from "@/Components/Admin/FormDimensions.vue";
import Button from "@/Components/Admin/Button.vue";
import FormHolder from "@/Components/Admin/FormHolder.vue";
import PageTitle from "@/Components/Admin/PageTitle.vue";

let form = useForm({
    title: null,
    slug: null,
    description: null,
    video: null,
    images: [],
    creation_date: null,
    height: null,
    width: null,
    depth: null,
});

let submit = () => {
    form.post("/admin/paintings", { preserveScroll: true });
};
</script>

<template>
    <Head>
        <title>Créer une peinture</title>
    </Head>
    <PageTitle>Créer une Peinture</PageTitle>

    <FormHolder>
        <form @submit.prevent="submit">
            <Input
                v-model="form.title"
                name="title"
                :error="form.errors.title"
            />
            <Input v-model="form.video" name="video" :required="false" />
            <Input v-model="form.slug" name="slug" :error="form.errors.slug" />
            <Input
                v-model="form.description"
                name="description"
                :error="form.errors.description"
            />

            <FilesField
                v-model:images="form.images"
                name="Dessins (Un ou Plusieurs)"
                :errors="form.errors"
            />

            <Input
                v-model="form.creation_date"
                name="date"
                :error="form.errors.creation_date"
                type="date"
            />

            <FormDimensions>
                <Input
                    v-model="form.width"
                    name="width"
                    :error="form.errors.width"
                />
                <Input
                    v-model="form.height"
                    name="height"
                    :error="form.errors.height"
                />
                <Input
                    v-model="form.depth"
                    name="depth"
                    :error="form.errors.depth"
                />
            </FormDimensions>

            <div>
                <Button type="submit" :disabled="form.processing"
                    >Submit</Button
                >
            </div>
        </form>
    </FormHolder>
</template>
