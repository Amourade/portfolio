<script setup>
//Vue Setup
import { ref, onMounted } from "vue";
import * as Three from "three";

//Import assets for Three
import painting from "Assets/images/about/threeOne.jpg";
import tennisSound from "Assets/sounds/shared/tennisserve.mp3";

const container = ref(null);

//Defines Three.js Variables
let camera;
let scene;
let renderer;
let textureLoader;
let sound;
let mesh;

//Dimensions, Can eventually make that a Prop
const WIDTH = 450;
const HEIGHT = 350;
let rotationSpeed = 0.001;
let interval = null;

const loaded = ref(false);

function slowDown() {
    if (rotationSpeed > 0.001) {
        rotationSpeed -= 0.001;
    } else {
        clearInterval(interval);
        interval = null;
    }
}

//Init the Scene
function init() {
    scene = new Three.Scene();

    //Renderer
    renderer = new Three.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(WIDTH, HEIGHT);

    //Camera
    camera = new Three.PerspectiveCamera(30, WIDTH / HEIGHT, 0.1, 100);
    camera.position.set(0, 0, 60);
    camera.lookAt(scene.position);
    scene.add(camera);

    //Light
    var ambientLight = new Three.AmbientLight(0x404040, 4);
    scene.add(ambientLight);

    //Load texture and make model
    textureLoader = new Three.TextureLoader();
    textureLoader.load(
        painting,
        function (tex) {
            var geom = new Three.BoxGeometry(30, 24, 0.5);
            tex.anisotropy = 16;
            var mat = new Three.MeshPhongMaterial({
                map: tex,
                color: 0xffffff,
            });
            mesh = new Three.Mesh(geom, mat);
            mesh.position.set(0, 0, 0);
            mesh.lookAt(camera.position);
            scene.add(mesh);
            loaded.value = true;
            render();
        },
        undefined,
        function (err) {
            console.log(err);
        }
    );

    //Sound
    var listener = new Three.AudioListener();
    camera.add(listener);

    sound = new Three.Audio(listener);

    var audioLoader = new Three.AudioLoader();

    audioLoader.load(tennisSound, function (buffer) {
        sound.setBuffer(buffer);
        sound.setLoop(false);
        sound.setVolume(0.5);
    });

    //Setup sound interactivity
    if (container.value !== null) {
        container.value !== null
            ? container.value.appendChild(renderer.domElement)
            : "";
        container.value.addEventListener("click", () => {
            sound.play();
            rotationSpeed = 0.5;
            if (!interval) {
                interval = setInterval(slowDown, 5);
            }
        });
    }
}

function render() {
    requestAnimationFrame(render);
    animate();
    renderer.render(scene, camera);
}

function animate() {
    mesh.rotation.y += rotationSpeed;
}

onMounted(() => {
    init();
});
</script>

<template>
    <div class="container" ref="container" :class="{ loaded: loaded }"></div>
</template>

<style lang="scss" scoped>
.container {
    display: block;
    width: 450px;
    height: 350px;
    cursor: crosshair;
    position: absolute;
    top: 50px;
    right: 100px;
    box-shadow: 3px 3px 3px #c8c8c8;
    opacity: 0;

    transition: opacity 1s;
    &.loaded {
        opacity: 1;
    }
}
</style>
