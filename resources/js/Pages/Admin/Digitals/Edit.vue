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
    digital: Object,
});

let form = useForm({
    _method: "PATCH",
    title: props.digital.title,
    slug: props.digital.slug,
    video: props.digital.video,
    images: props.digital.images.map((value, index) => {
        return {
            originalImage: value.url,
            image: value.url,
            isNew: false,
            isDeleted: false,
            order: index,
        };
    }),
    creation_date: props.digital.creation_date,
});

let submit = () => {
    form.post("/admin/digitals/" + props.digital.id, { preserveScroll: true });
};
</script>
<template>
    <Head>
        <title>Modifier un digital</title>
    </Head>
    <PageTitle>Modifier un Digital</PageTitle>

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
                name="Dessins (Un ou Plusieurs)"
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
                    >Update</Button
                >
            </div>
        </form>
    </FormHolder>
</template>

<style scoped></style>
