<script setup>
import { computed } from "@vue/reactivity";
import { onBeforeMount, reactive, ref } from "vue";
import { useMouse } from "@/Components/Shared/mouse.js";
import { useResize } from "@/Components/Shared/resize.js";
import topTexture from "Assets/images/paintings/show/corridor/mur1.webp";
import bottomTexture from "Assets/images/paintings/show/corridor/mur4.webp";
import leftTexture from "Assets/images/paintings/show/corridor/mur2.webp";
import rightTexture from "Assets/images/paintings/show/corridor/mur3.webp";
import fond from "Assets/images/paintings/show/corridor/fondFleur.webp";
import paintingOne from "Assets/images/paintings/show/corridor/peinture1.webp";
import paintingTwo from "Assets/images/paintings/show/corridor/peinture2.webp";
import paintingThree from "Assets/images/paintings/show/corridor/peinture3.webp";
import paintingFour from "Assets/images/paintings/show/corridor/peinture4.webp";
import paintingFive from "Assets/images/paintings/show/corridor/peinture5.webp";
import paintingSix from "Assets/images/paintings/show/corridor/peinture6.webp";

const emit = defineEmits(["loadNeeded", "loaded"]);

const perspectiveRange = reactive([35, 65]);
const { x, y } = useMouse();
const { WIDTH, HEIGHT } = useResize();
const toLoad = ref(0);
const loaded = ref(0);
const imgsToLoad = [
    topTexture,
    bottomTexture,
    leftTexture,
    rightTexture,
    fond,
    paintingOne,
    paintingTwo,
    paintingThree,
    paintingFour,
    paintingFive,
    paintingSix,
];

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

const perspective = computed(() => {
    const range = perspectiveRange[1] - perspectiveRange[0];
    const ratio = {
        x: (x.value / WIDTH.value).toFixed(2),
        y: (y.value / HEIGHT.value).toFixed(2),
    };
    const newPerspective = {
        x: Number(perspectiveRange[0]) + Number((range * ratio.x).toFixed(2)),
        y: Number(perspectiveRange[0]) + Number((range * ratio.y).toFixed(2)),
    };
    if (newPerspective.x > perspectiveRange[1])
        newPerspective.x = perspectiveRange[1];
    if (newPerspective.x < perspectiveRange[0])
        newPerspective.x = perspectiveRange[0];
    if (newPerspective.y > perspectiveRange[1])
        newPerspective.y = perspectiveRange[1];
    if (newPerspective.y < perspectiveRange[0])
        newPerspective.y = perspectiveRange[0];

    const rule = newPerspective.x + "% " + newPerspective.y + "%";

    return rule;
});
</script>
<template>
    <div
        id="corridor"
        style="min-width: 750px"
        :style="{ perspectiveOrigin: perspective }"
    >
        <div
            class="surface back"
            :style="{ backgroundImage: 'url(' + fond + ')' }"
        >
            <div class="tile"></div>
        </div>
        <div
            class="surface top"
            :style="{ backgroundImage: 'url(' + topTexture + ')' }"
        >
            <div class="darkgrad"></div>
        </div>
        <div
            class="surface top second"
            :style="{ backgroundImage: 'url(' + topTexture + ')' }"
        ></div>
        <div
            class="surface bottom"
            :style="{ backgroundImage: 'url(' + bottomTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="darkgrad"></div>
        </div>
        <div
            class="surface bottom second"
            :style="{ backgroundImage: 'url(' + bottomTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
        </div>
        <div
            class="surface left"
            :style="{ backgroundImage: 'url(' + leftTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div
                class="painting1"
                :style="{ backgroundImage: 'url(' + paintingOne + ')' }"
            ></div>
            <div
                class="painting2"
                :style="{ backgroundImage: 'url(' + paintingFive + ')' }"
            ></div>
            <div
                class="painting3"
                :style="{ backgroundImage: 'url(' + paintingThree + ')' }"
            ></div>
            <div class="darkgrad"></div>
        </div>
        <div
            class="surface left second"
            :style="{ backgroundImage: 'url(' + leftTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
        </div>
        <div
            class="surface right"
            :style="{ backgroundImage: 'url(' + rightTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div
                class="painting1"
                :style="{ backgroundImage: 'url(' + paintingTwo + ')' }"
            ></div>
            <div
                class="painting2"
                :style="{ backgroundImage: 'url(' + paintingFour + ')' }"
            ></div>
            <div
                class="painting3"
                :style="{ backgroundImage: 'url(' + paintingSix + ')' }"
            ></div>
            <div class="darkgrad"></div>
        </div>
        <div
            class="surface right second"
            :style="{ backgroundImage: 'url(' + rightTexture + ')' }"
        >
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
            <div class="tile"></div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.wrapper {
    width: 100vw;
    height: 100vh;
    max-height: 100%;
    max-width: 100%;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

#corridor {
    display: block;
    position: absolute;
    z-index: -1;
    perspective: 1032px;
    perspective-origin: 50% 50%;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    transform-style: preserve-3d;
    height: 100vmax;
    width: 100vmax;
    perspective: 100vmax;

    //overflow: hidden;

    .surface {
        display: block;
        width: 50%;
        height: 50%;
        position: absolute;
        z-index: -1;

        .darkgrad {
            width: 100%;
            height: 100%;
            background: linear-gradient(
                180deg,
                rgba(0, 0, 0, 1) 0%,
                rgba(252, 250, 255, 0) 50%
            );
        }

        &.top {
            transform: rotateX(-90deg) translateY(-11%);
            transform-origin: 50% 12.5%;
            left: 25%;
            height: 200%;
            background: radial-gradient(
                circle,
                rgba(119, 94, 53, 1) 0%,
                rgba(252, 242, 226, 1) 100%
            );
            //background-image: url("../../../../assets/images/paintings/show/mur1.jpg");
            border: 2px black inset;
            border-top: none;
            background-size: 100% 50%;

            &.second {
                transform: rotateX(-90deg) translateY(-111%);
            }

            .darkgrad {
                background: linear-gradient(
                    0deg,
                    rgba(0, 0, 0, 1) 0%,
                    rgba(252, 250, 255, 0) 50%
                );
            }
        }

        &.left {
            top: 25%;
            transform-origin: 12.5% 50%;
            width: 200%;
            transform: rotateY(90deg) translateX(-11%);
            background: rgb(254, 255, 93);
            background-size: 33.33% 66.66%;
            border: 2px black ridge;

            &.second {
                transform: rotateY(90deg) translateX(-111%);
            }

            .darkgrad {
                background: linear-gradient(
                    270deg,
                    rgba(0, 0, 0, 1) 0%,
                    rgba(252, 250, 255, 0) 50%
                );
            }

            .tile {
                float: right;
                width: 16.66%;
                height: 33.3%;
                background: linear-gradient(
                    180deg,
                    rgba(255, 255, 255, 1) 0%,
                    rgba(200, 204, 135, 0) 3%,
                    rgba(200, 204, 135, 0) 97%,
                    rgba(42, 12, 2, 1) 100%
                );
                border: 3px white outset;
            }

            .painting1 {
                position: absolute;
                top: 30%;
                right: 26%;
                width: 20%;
                height: 40%;
                background-color: white;
                box-shadow: -48px 11px 39px black;
                transform: rotateZ(-15deg);
                background-size: 100% 100%;
            }

            .painting2 {
                position: absolute;
                top: 10%;
                right: 55%;
                width: 15%;
                height: 60%;
                background-color: white;
                box-shadow: -30px 28px 39px black;
                transform: rotateZ(8deg);
                background-size: 100% 100%;
            }

            .painting3 {
                position: absolute;
                top: 10%;
                right: 79%;
                width: 5%;
                height: 20%;
                background-color: white;
                box-shadow: -12px 12px 15px black;
                transform: rotateZ(-5deg);
                background-size: 100% 100%;
            }
        }

        &.right {
            transform: rotateY(-90deg) translateX(-39%);
            top: 25%;
            width: 200%;
            transform-origin: 37.5% 50%;
            background: rgb(254, 255, 93);
            background: linear-gradient(
                270deg,
                rgba(254, 255, 93, 1) 0%,
                rgba(200, 204, 135, 1) 78%
            );
            border: 2px black ridge;
            background-size: 33.33% 66.66%;

            .darkgrad {
                background: linear-gradient(
                    90deg,
                    rgba(0, 0, 0, 1) 0%,
                    rgba(252, 250, 255, 0) 50%
                );
            }

            &.second {
                transform: rotateY(-90deg) translateX(61%);
            }

            .tile {
                width: 16.66%;
                height: 33.3%;
                float: left;
                background: linear-gradient(
                    180deg,
                    rgba(255, 255, 255, 1) 0%,
                    rgba(200, 204, 135, 0) 3%,
                    rgba(200, 204, 135, 0) 97%,
                    rgba(19, 2, 42, 1) 100%
                );
                border: 3px white outset;
            }

            .painting1 {
                position: absolute;
                top: 30%;
                left: 60%;
                width: 13%;
                height: 60%;
                background-color: white;
                box-shadow: 15px 9px 21px black;
                transform: rotateZ(10deg);
                background-size: 100% 100%;
            }

            .painting2 {
                position: absolute;
                top: 20%;
                left: 28%;
                width: 10%;
                height: 70%;
                background-color: white;
                box-shadow: 15px 9px 21px black;
                transform: rotateZ(-12deg);
                background-size: 100% 100%;
            }

            .painting3 {
                position: absolute;
                top: 60%;
                left: 79%;
                width: 6%;
                height: 25%;
                background-color: white;
                box-shadow: 15px 9px 21px black;
                transform: rotateZ(-25deg);
                background-size: 100% 100%;
            }
        }

        &.bottom {
            transform: rotateX(90deg) translateY(-39%);
            left: 25%;
            transform-origin: 50% 37.5%;
            height: 200%;
            background-color: green;
            border: 2px black inset;
            background-size: 100% 40%;

            &.second {
                transform: rotateX(90deg) translateY(61%);
            }

            .tile {
                width: 50%;
                height: 20%;
                float: left;
                border: 3px white outset;
                line-height: 100%;
                text-align: center;
                background: linear-gradient(
                    180deg,
                    rgba(255, 255, 255, 1) 0%,
                    rgba(0, 0, 0, 0) 4%,
                    rgba(0, 0, 0, 0) 97%,
                    rgba(0, 0, 0, 1) 100%
                );

                span {
                    display: none;
                    position: relative;
                    top: 40%;
                }
            }
        }

        &.back {
            transform: translateZ(-5000px);
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background-position: center;
            background-size: 50%;
            background-repeat: no-repeat;

            .tile {
                display: block;
                width: 100%;
                height: 100%;
                background: radial-gradient(
                    circle,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(0, 0, 0, 0.70574227982208513) 5%,
                    rgba(0, 0, 0, 1) 40%
                );
            }
        }
    }
}
</style>
