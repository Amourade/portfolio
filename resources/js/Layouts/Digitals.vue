<script setup>
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";
import NavItem from "@/Components/Digitals/NavItem.vue";
import OpenItem from "@/Components/Digitals/OpenItem.vue";

defineProps({
    digitals: Object,
    current: Object,
});

const animationRunning = ref(false);
const animateTarget = ref(null);
const animating = ref(false);

const navigate = (e, el) => {
    animating.value = true;
    if (el === "close") {
        animateTarget.value = null;
    }
    Inertia.visit(e, {
        only: ["current"],
        preserveScroll: true,
    });
};

const updateTarget = (el) => {
    animateTarget.value = el;
};

const openImage = (e, args = { triggered: false }) => {
    //Open image if no images are open
    if ($(".open-digital").length == 0 && !animationRunning) {
        var el = this;

        //Add active class to the small image
        this.classList.add("active");

        //Timeout for the css animation to be done followed by the loading
        setTimeout(function () {
            //Get the small image's properties to put the loaded one on top
            var left = el.getBoundingClientRect().left + window.scrollX;
            var top = el.getBoundingClientRect().top + window.scrollY;
            var width = el.getBoundingClientRect().width;
            var height = el.getBoundingClientRect().height;

            //Insert open image loading markup
            $(".shelf").after("<div class='open-digital'></div>");

            //Set domDestionation and load URL for load operation
            var domDestination = ".open-digital";
            var url = $(el).attr("href");

            //Load the full image ans insert in the DOM
            $(domDestination)
                .after()
                .load(url + " " + domDestination + ">*", function () {
                    //animation officially running, make sure nothing else happens
                    animationRunning = true;

                    //Get loaded element and remove nojs class
                    var el = $(domDestination);
                    el.removeClass("nojs");

                    //Position loaded image on top of the small one
                    el.css({
                        top: top + height / 2,
                        left: left + width / 2,
                        width: width,
                        height: height,
                    });

                    //Set small image as background-image of large one
                    console.log($(".active img")[0].src);
                    el.find("img").css({
                        "background-image":
                            "url(" + $(".active img")[0].src + ")",
                    });

                    //Timeout for the large image to take its small measures + for the small image to disappear
                    setTimeout(function () {
                        //Make small image disappear
                        $(".active").addClass("hidden");

                        //Make loaded image take its full size
                        el.addClass("js-open");
                        el.css({
                            top: "calc( 50% + " + window.scrollY + "px)",
                            left: "",
                            width: "",
                            height: "",
                        });

                        //Add done class to indicate end of preload
                        el.addClass("done");

                        //We done we can remove animation running
                        animationRunning = false;
                    }, 100);
                });
        }, 300);
    }
};
</script>
<template>
    <div id="digitals">
        <header><Link href="/">Accueil - Home</Link></header>
        <nav class="shelf">
            <div id="digitals-wrapper">
                <div
                    class="single-digital-wrapper"
                    v-for="(digital, index) in digitals"
                    :key="index"
                >
                    <NavItem
                        :item="digital"
                        :selected="current && digital.slug === current.slug"
                        @updateTarget="updateTarget"
                        @navigate="navigate"
                    ></NavItem>
                </div>
            </div>
        </nav>
        <OpenItem
            v-if="current"
            :digitals="digitals"
            :current="current"
            :animateTarget="animateTarget"
            :animating="animating"
            @navigate="navigate"
        ></OpenItem>
        <footer></footer>
    </div>
</template>
<style lang="scss" scoped>
@import "Css/digitals-variable.scss";
#digitals {
    overflow-x: hidden;
    min-width: calc(100vw - 17px);
    min-height: 100vh;
}

header {
    height: 300px;
    position: relative;
    width: 100%;

    background: url("Assets/images/digital/top.png"),
        url("Assets/images/digital/top-texture.png"), #83ab8c;
    background-repeat: no-repeat, repeat;
    background-position: top left;
    overflow: hidden;

    &:before {
        content: "";
        display: block;
        width: 200%;
        position: absolute;
        height: 200%;
        bottom: 0px;
        left: 50%;
        transform: translate(-50%);
    }

    a {
        position: absolute;
        top: 50%;
        right: 100px;
        transform: rotate(-4deg) translateY(-50%);
        color: rgba(0, 0, 0, 0);
        text-shadow: 0 0 4px pink;
        text-decoration: none;

        font-family: "Jim Nightshade";
        font-size: 2em;

        transition: text-shadow 1.5s;

        &:hover {
            text-shadow: 0 0 0px black;
        }
    }
}

@media only screen and (min-width: 768px) {
    header {
        a {
            font-size: 5em;

            text-shadow: 0 0 15px pink;
        }
    }
}

footer {
    min-height: 300px;
    perspective: 400px;
    transform-style: preserve-3d;
    position: relative;
    z-index: 1;
    perspective-origin: bottom;
    width: 100%;
    overflow: hidden;

    &:before {
        content: "";
        display: block;
        width: 200%;
        height: 203%;
        position: absolute;
        bottom: 0px;
        left: -50%;
        background: black;
        transform-origin: bottom;
        z-index: 5;
        transform: rotateX(27deg);

        background: url("Assets/images/digital/planche.jpg");
    }
}

.shelf {
    box-shadow: 0px 20px 75px 60px black;
    position: relative;
    z-index: 5;

    width: 100%;

    background-image: url("Assets/images/digital/text-grosse-min.png");
    background: url("Assets/images/digital/text-grosse-min.png"), $base-color;

    #digitals-wrapper {
        padding: 100px 50px 200px 50px;

        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;

        .single-digital-wrapper {
            background: darkred;
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: $shelf-sides;
            position: relative;
            z-index: 1;
            box-shadow: -8px 9px 10px 3px rgba(0, 0, 0, 0.5);

            margin: 10px;

            &:hover {
                z-index: 2;
            }
        }
    }
}
</style>
