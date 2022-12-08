<script setup>
import rightDoor from "Assets/images/paintings/index/droite.webp";
import leftDoor from "Assets/images/paintings/index/gauche.webp";
import back from "Assets/images/paintings/index/fond.webp";
import { onBeforeMount, ref } from "vue";

const emit = defineEmits(["loadNeeded", "loaded"]);

const toLoad = ref(0);
const loaded = ref(0);
const imgsToLoad = [rightDoor, leftDoor, back];

onBeforeMount(() => {
    emit("loadNeeded");
    toLoad.value = imgsToLoad.length;
    imgsToLoad.forEach((item, index) => {
        let img = new Image();
        img.src = item;
        img.onload = () => {
            updateLoading(1);
        };
    });
});

const updateLoading = (amnt) => {
    loaded.value += amnt;
    if (loaded.value === toLoad.value) {
        emit("loaded");
    }
};
</script>

<template>
    <div class="gate" :style="{ 'background-image': 'url(' + back + ')' }">
        <div
            class="porte gauche"
            :style="{ 'background-image': 'url(' + leftDoor + ')' }"
        ></div>
        <div
            class="porte droite"
            :style="{ 'background-image': 'url(' + rightDoor + ')' }"
        ></div>
    </div>
</template>

<style lang="scss" scoped>
.gate {
    position: absolute;
    height: 100%;
    width: 100%;
    perspective: 1000px;
    -webkit-perspective: 1000px;

    background-size: 100% 100%;
    background-attachment: fixed;

    z-index: 2;

    &.open {
        .droite {
            animation: openrightdoor 5s 1 ease-in-out;
            -webkit-animation: openrightdoor 5s 1 ease-in-out;
            transform: rotateY(-90deg);
        }

        .gauche {
            animation: openleftdoor 5s 1 ease-in-out;
            -webkit-animation: openleftdoor 5s 1 ease-in-out;
            transform: rotateY(90deg);
        }
    }
}

.porte {
    position: absolute;
    width: 50%;
    height: 100%;
    background-size: 100% 100%;
    z-index: 0;

    &.droite {
        right: 0px;
        transform-style: preserve-3d;
        transform: rotateY(0deg);
        transform-origin: center right;
    }

    &.gauche {
        left: 0px;
        transform-style: preserve-3d;
        transform: rotateY(0deg);
        transform-origin: center left;
    }
}

@-webkit-keyframes openrightdoor {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(-90deg);
    }
}

@keyframes openrightdoor {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(-90deg);
    }
}

@-webkit-keyframes openleftdoor {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(90deg);
    }
}

@keyframes openleftdoor {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(90deg);
    }
}
</style>
