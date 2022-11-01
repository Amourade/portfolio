<script setup>
import { onMounted, watch, onUnmounted, onUpdated, reactive, ref } from "vue";
const emits = defineEmits(["navigate", "updateTarget"]);
const props = defineProps({
    item: Object,
    selected: Boolean,
});

const active = ref(false);
const animateTarget = ref(null);
const hidden = ref(false);

const navigate = (e, el) => {
    active.value = true;
    UpdateTarget();

    setTimeout(() => {
        emits("navigate", e);
    }, 500);
};

const UpdateTarget = () => {
    emits("updateTarget", animateTarget.value);
};

onMounted(() => {
    if (props.selected) {
        UpdateTarget();
        hidden.value = true;
    }
});

watch(
    () => props.selected,
    (newValue) => {
        newValue ? (hidden.value = true) : (hidden.value = false);
        active.value = newValue;
    }
);
</script>
<template>
    <div class="digital">
        <span class="shelf-title">{{ item.title }}</span
        ><a
            @click.prevent="navigate(item.slug, $event)"
            data-imgID="gettheID"
            :href="item.slug"
            :class="{ active: active || props.selected, hidden: hidden }"
            ref="animateTarget"
            ><div class="title">
                <span>{{ item.title }}</span>
            </div>
            <img :src="item.images[0].thumb" />
            <div class="ombre"></div
        ></a>
        <div class="cote haut"></div>
        <div class="cote droite"></div>
        <div class="cote bas"></div>
        <div class="cote gauche"></div>
        <div class="cote fond"></div>
    </div>
</template>
<style lang="scss" scoped>
@import "Css/digitals-variable.scss";
.digital {
    position: relative;
    perspective: 200px;
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    width: 100%;
    height: 100%;

    .shelf-title {
        position: absolute;
        top: -$shelf-sides;
        left: 0px;
        height: $shelf-sides;
        display: flex;
        align-items: center;
        color: rgba(0, 0, 0, 0);
        text-shadow: 0 0 2px #d5c944, 0 0 5px black;

        white-space: nowrap;

        z-index: 5;
    }

    a {
        transform: rotateY(-85deg) translateX(-10px) translateZ(0px);
        transform-style: preserve-3d;
        transform-origin: right;

        color: black;

        position: relative;
        right: $book-height;

        z-index: 10;

        transition: transform 0.3s, right 0.3s, opacity 0s;
        opacity: 1;

        &:hover {
            transform: rotateY(-15deg) translateX(20px) translateZ(20px);
        }

        &.active {
            transform: rotateY(0deg) translateX(20px) translateZ(20px);
            right: 0px;

            &.hidden {
                opacity: 0;

                .ombre {
                    box-shadow: 0px -10px 0px 0px rgba(0, 0, 0, 0);
                }
            }
        }
    }

    .title {
        position: absolute;
        right: calc($book-height/2) * -1;
        transform: rotateY(90deg) translateX(50%);
        transform-origin: bottom center;

        width: $book-height;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;

        background: $title-gradient;

        white-space: nowrap;
        overflow: hidden;

        color: black;
        text-shadow: -1px -1px 0px #d5c944;

        span {
            transform: rotate(90deg);
        }
    }

    img {
        max-height: 100%;
        transform-origin: center right;
        display: block;
        width: auto;
    }

    .ombre {
        position: absolute;
        height: 26px;
        width: 100%;
        bottom: -26px;
        left: 0px;
        display: block;
        z-index: 23;
        transform-origin: top;
        transform: rotateX(-90deg) translateZ(-0.5px);
        box-shadow: 0px -7px 14px 7px rgba(0, 0, 0, 0.8);

        transition: box-shadow 0.3s;
    }

    .cote {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0px;
        left: 0px;
        transform-style: preserve-3d;

        z-index: 0;

        &:before {
            content: "";
            position: absolute;
            display: block;
        }
    }

    .haut {
        transform: rotateX(-90deg);
        background: $small-texture, $top-gradient;
        transform-origin: top;

        height: 350px;

        &:before {
            width: calc(100% + #{$shelf-sides * 2});
            height: $shelf-sides;
            transform: rotateX(90deg) translateY(-50%);
            left: -$shelf-sides;
            top: calc($shelf-sides/2) * -1;
            background: $small-texture, $top-side-gradient;
        }
    }

    .bas {
        transform: rotateX(90deg);
        background: $small-texture, $bottom-gradient;
        transform-origin: bottom;

        height: 350px;
        bottom: 0px;
        top: auto;

        &:before {
            width: calc(100% + #{$shelf-sides * 2});
            height: $shelf-sides;
            transform: rotateX(90deg) translateY(-50%);
            left: -$shelf-sides;
            bottom: calc($shelf-sides/2) * -1;
            background: $small-texture, $bottom-side-gradient;
        }
    }

    .droite {
        transform: rotateY(-90deg);
        background: $small-texture, $right-gradient;
        transform-origin: right;

        width: 350px;
        right: 0px;
        left: auto;

        &:before {
            height: 100%;
            width: $shelf-sides;
            transform: rotateY(-90deg) translateX(-50%);
            top: 0px;
            right: calc($shelf-sides/2) * -1;
            background: $small-texture, $right-side-gradient;
        }
    }

    .gauche {
        transform: rotateY(90deg);
        background: $small-texture, $left-gradient;
        transform-origin: left;

        width: 350px;

        &:before {
            height: 100%;
            width: $shelf-sides;
            transform: rotateY(90deg) translateX(50%);
            top: 0px;
            left: calc($shelf-sides/2) * -1;
            background: $small-texture, $left-side-gradient;
        }
    }

    .fond {
        transform: translateZ(-350px);
        background: $small-texture, $color-bottom;
    }
}
</style>
