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
import PageTitle from "@/Components/Admin/PageTitle.vue";
import Button from "@/Components/Admin/Button.vue";
import FormDimensions from "@/Components/Admin/FormDimensions.vue";

const props = defineProps({
    painting: Object,
});

let form = useForm({
    _method: "PATCH",
    title: props.painting.title,
    slug: props.painting.slug,
    description: props.painting.description,
    video: props.painting.video,
    images: props.painting.images.map((value, index) => {
        return {
            originalImage: value.url,
            image: value.url,
            isNew: false,
            isDeleted: false,
            order: index,
        };
    }),
    creation_date: props.painting.creation_date,
    height: props.painting.height,
    width: props.painting.width,
    depth: props.painting.depth,
});

let submit = () => {
    form.post("/admin/paintings/" + props.painting.id, {
        preserveScroll: (page) => Object.keys(page.props.errors).length,
    });
};
</script>
<template>
    <Head>
        <title>Modifier une peinture</title>
    </Head>
    <PageTitle>Modifier une Peinture</PageTitle>

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
                    >Update</Button
                >
            </div>
        </form>
    </FormHolder>
</template>
