<script setup>
import Button from "./Button.vue";
import LinkButton from "./LinkButton.vue";
defineProps({
    items: Object,
    action: String,
});
</script>
<template>
    <h2 class="empty" v-if="items.length == 0">C'est vide...</h2>
    <section class="items" v-if="items.length > 0">
        <div class="item" v-for="item in items">
            <h2>
                <Link :href="`/admin/${action}/${item.id}/edit`">{{
                    item.title
                }}</Link>
            </h2>
            <Link :href="`/admin/${action}/${item.id}/edit`"
                ><img :src="item.image"
            /></Link>
            <div class="buttons">
                <LinkButton :href="`/admin/${action}/${item.id}/edit`"
                    >Edit</LinkButton
                >
                <LinkButton
                    :href="`/admin/${action}/${item.id}`"
                    method="delete"
                    preserve-scroll
                    >Delete</LinkButton
                >
            </div>
        </div>
    </section>
</template>

<style lang="scss" scoped>
.empty {
    text-align: center;
    margin-top: 50px;
}
.items {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    row-gap: 10px;
    column-gap: 10px;

    margin: 40px 20px;
}
.item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    word-wrap: anywhere;
    text-align: center;
    padding: 15px;

    border-radius: 60px;
    border: 1px solid white;

    background: #f9f7f0;

    box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.5) inset,
        0px 0px 1px 1px rgba(0, 0, 0, 0.3);

    transition: all 1s;

    &:hover {
        box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, 0) inset,
            0px 0px 1px 1px rgba(0, 0, 0, 0.3);
        background: #f9f7f070;
    }

    h2 {
        border-bottom: 1px solid #7c4e7b;
    }

    a,
    &:visited {
        text-decoration: none;

        color: #7c4e7b;

        &:hover {
            color: #261126;
        }
    }

    img {
        margin-top: 15px;
        width: 100px;
        height: 100px;
        border-radius: 5px;
        object-fit: cover;
        border: 1px solid rgba(0, 0, 0, 0.2);
    }
}

@media (max-width: 768px) {
    .items {
        grid-template-columns: 1fr 1fr;
    }

    .item {
        padding: 10px 3px;
        border-radius: 30px;

        button {
            margin-top: 5px;
        }
    }
}
</style>
