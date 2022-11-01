<script setup>
//Vue Setup
import { ref, onMounted } from "vue";
import * as Three from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

//Import assets for Three
import model from "Assets/models/home/chien.glb";
import tennisSound from "Assets/sounds/shared/tennisserve.mp3";

const container = ref(null);

//Defines Three.js Variables
let camera;
let scene;
let renderer;
let loader;
let sound;
let mesh;

//Dimensions, Can eventually make that a Prop
const WIDTH = 500;
const HEIGHT = 500;

const loaded = ref(false);

//Init the Scene
function init() {
    scene = new Three.Scene();

    //Renderer
    renderer = new Three.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(WIDTH, HEIGHT);

    //Camera
    camera = new Three.PerspectiveCamera(30, WIDTH / HEIGHT, 0.1, 100);
    camera.position.set(0, 0, 10);
    camera.lookAt(scene.position);
    scene.add(camera);

    //Light
    var ambientLight = new Three.AmbientLight(0x404040, 4);
    scene.add(ambientLight);

    //Load model and make model
    loader = new GLTFLoader();

    loader.load(model, function (gltf) {
        gltf.scene.traverse(function (child) {
            if (child.isMesh) {
                var material = new Three.MeshPhongMaterial({
                    color: 0xffffff,
                    side: Three.DoubleSide,
                    reflectivity: 0,
                    shininess: 0,
                    vertexColors: true,
                });
                child.material.vertexColors = false;
                child.material = material;
                mesh = child;
            }
        });
        mesh.scale.set(1.2, 1.2, 1.2);
        mesh.position.set(0, 0, 0);
        mesh.rotation.x += Math.PI / 5;
        scene.add(mesh);
        loaded.value = true;
        render();
    });

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
        });
    }
}

function render() {
    requestAnimationFrame(render);
    animate();
    renderer.render(scene, camera);
}

function animate() {
    mesh.rotation.y -= 0.01;
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
    position: fixed;
    right: 0px;
    top: 600px;
    width: 500px;
    height: 500px;
    float: right;
    cursor: crosshair;

    opacity: 0;

    transition: opacity 1s;
    &.loaded {
        opacity: 1;
    }
}
</style>
