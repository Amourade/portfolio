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
import Button from "@/Components/Admin/Button.vue";
import FormHolder from "@/Components/Admin/FormHolder.vue";
import PageTitle from "@/Components/Admin/PageTitle.vue";

const props = defineProps({
    project: Object,
});

let form = useForm({
    _method: "PATCH",
    title: props.project.title,
    slug: props.project.slug,
    description: props.project.description,
    video: props.project.video,
    images: props.project.images.map((value, index) => {
        return {
            originalImage: value.url,
            image: value.url,
            isNew: false,
            isDeleted: false,
            order: index,
        };
    }),
    creation_date: props.project.creation_date,
    url: props.project.url,
});

let submit = () => {
    form.post("/admin/projects/" + props.project.id, { preserveScroll: true });
};
</script>
<template>
    <Head>
        <title>Modifier un projet</title>
    </Head>
    <PageTitle>Modifier un Projet</PageTitle>

    <FormHolder>
        <form @submit.prevent="submit">
            <Input
                v-model="form.title"
                name="title"
                :error="form.errors.title"
            />
            <Input v-model="form.slug" name="slug" :error="form.errors.slug" />
            <Input
                v-model="form.description"
                name="description"
                :error="form.errors.description"
            />

            <FilesField
                v-model:images="form.images"
                name="Images (Une ou Plusieurs)"
                :errors="form.errors"
            />

            <Input
                v-model="form.creation_date"
                name="date"
                :error="form.errors.creation_date"
                type="date"
            />
            <Input
                v-model="form.url"
                name="url"
                :error="form.errors.url"
                type="string"
            />

            <div>
                <Button type="submit" :disabled="form.processing"
                    >Update</Button
                >
            </div>
        </form>
    </FormHolder>
</template>

<style scoped></style>
