<script setup>
import * as THREE from "three";
import { PointerLockControls } from "three/examples/jsm/controls/PointerLockControls.js";
import { onMounted } from "vue";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";
import clownModel from "./assets/models/clown.glb";
import pas1 from "./assets/sounds/pas1.mp3";
import pas2 from "./assets/sounds/pas2.mp3";
import carousselMusic from "./assets/sounds/caroussel.mp3";
import tennisServe from "./assets/sounds/tennisserve.mp3";
import horn from "./assets/sounds/horn.mp3";
import plancher from "./assets/images/plancher-min.jpg";
import skybox from "./assets/images/skybox-min.jpg";
import groundTexture from "./assets/images/sol-min.jpg";
import tree from "./assets/images/arbre-min.jpg";
import leaf from "./assets/images/feuille-min.jpg";

const props = defineProps({
    paintings: Object,
});

var HEIGHT,
    WIDTH,
    camera,
    scene,
    renderer,
    controls,
    clock,
    time,
    delta,
    sceneGeometery,
    loadingInterval;
var clown, curve;
var mouse = new THREE.Vector2();
var globalSpeed = 1;
var paused = true;
var paintingsArray = [];
var groundsArray = [];
var interactiveObjects = [];
var caroussel = new THREE.Group();
var splineObject;
var splineCurve;
var INTERSECTED;
var helpers = [];
var pointer;
var lockedOn;
var paintingTextures = [];

var listener, bgSound;

var totalThingsToLoad = 0;
var totalThingsLoaded = 0;
var instructions;

var interactionRay = new THREE.Raycaster();

var debug = false;
var instructions;

/*ttteesstt*/

let raycaster;

let moveForward = false;
let moveBackward = false;
let moveLeft = false;
let moveRight = false;
let canJump = false;

let prevTime = performance.now();
const velocity = new THREE.Vector3();
const direction = new THREE.Vector3();
const vertex = new THREE.Vector3();
const color = new THREE.Color();

/*
 * Easing Functions - inspired from http://gizma.com/easing/
 * only considering the t value for the range [0, 1] => [0, 1]
 */
var EasingFunctions = {
    // no easing, no acceleration
    linear: (t) => {
        return t;
    },
    // accelerating from zero velocity
    easeInQuad: (t) => {
        return t * t;
    },
    // decelerating to zero velocity
    easeOutQuad: (t) => {
        return t * (2 - t);
    },
    // acceleration until halfway, then deceleration
    easeInOutQuad: (t) => {
        return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
    },
    // accelerating from zero velocity
    easeInCubic: (t) => {
        return t * t * t;
    },
    // decelerating to zero velocity
    easeOutCubic: (t) => {
        return --t * t * t + 1;
    },
    // acceleration until halfway, then deceleration
    easeInOutCubic: (t) => {
        return t < 0.5
            ? 4 * t * t * t
            : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
    },
    // accelerating from zero velocity
    easeInQuart: (t) => {
        return t * t * t * t;
    },
    // decelerating to zero velocity
    easeOutQuart: (t) => {
        return 1 - --t * t * t * t;
    },
    // acceleration until halfway, then deceleration
    easeInOutQuart: (t) => {
        return t < 0.5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t;
    },
    // accelerating from zero velocity
    easeInQuint: (t) => {
        return t * t * t * t * t;
    },
    // decelerating to zero velocity
    easeOutQuint: (t) => {
        return 1 + --t * t * t * t * t;
    },
    // acceleration until halfway, then deceleration
    easeInOutQuint: (t) => {
        return t < 0.5 ? 16 * t * t * t * t * t : 1 + 16 * --t * t * t * t * t;
    },
};

/*teeessssst*/

onMounted(() => {
    init();
});

function ready(fn) {
    if (document.readyState != "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function init() {
    instructions = document.getElementById("instructions");

    /*** Texture Loading
     */

    props.paintings.forEach((item, index, arr) => {
        totalThingsToLoad++;
        var texture = new THREE.TextureLoader().load(
            item.images[0].medium,
            function () {
                paintingTextures[index].dataHeight = item.height;
                paintingTextures[index].dataWidth = item.width;
                totalThingsLoaded++;
            }
        );
        paintingTextures.push(texture);
    });

    //SETUP THE RENDERERS AND GET THE THINGS LOADING

    WIDTH = window.innerWidth;
    HEIGHT = window.innerHeight;

    // RENDERER

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(WIDTH, HEIGHT);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.VSMShadowMap;
    renderer.domElement.id = "rendererOne";

    document.getElementById("primary").appendChild(renderer.domElement);

    //CLOCK//

    clock = new THREE.Clock();
    time = 0;

    // SCENE

    scene = new THREE.Scene();

    // CAMERA

    camera = new THREE.PerspectiveCamera(45, WIDTH / HEIGHT, 0.01, 2000);
    listener = new THREE.AudioListener();
    camera.add(listener);
    scene.add(camera);

    //  LIGHTS

    scene.add(new THREE.AmbientLight(0x444444));

    var spotLight = new THREE.SpotLight(0x888888);
    spotLight.name = "Spot Light";
    spotLight.angle = Math.PI / 5;
    spotLight.penumbra = 0.3;
    spotLight.position.set(100, 150, 60);
    spotLight.castShadow = true;
    spotLight.shadow.camera.near = 8;
    spotLight.shadow.camera.far = 1000;
    spotLight.shadow.mapSize.width = 256;
    spotLight.shadow.mapSize.height = 256;
    spotLight.shadow.bias = -0.002;
    spotLight.shadow.radius = 4;
    //scene.add( spotLight );

    var dirLight = new THREE.DirectionalLight(0xffffff, 1);
    dirLight.name = "Dir. Light";
    dirLight.position.set(500, 500, 500);
    //dirLight.castShadow = true;
    dirLight.shadow.camera.near = 0.1;
    dirLight.shadow.camera.far = 500;
    dirLight.shadow.camera.right = 250;
    dirLight.shadow.camera.left = -250;
    dirLight.shadow.camera.top = 250;
    dirLight.shadow.camera.bottom = -250;
    dirLight.shadow.mapSize.width = 2048;
    dirLight.shadow.mapSize.height = 2048;
    dirLight.shadow.radius = 4;
    dirLight.shadow.bias = -0.0005;
    scene.add(dirLight);

    // CONTROLS

    controls = new PointerLockControls(camera, document.body);

    pointer = document.getElementById("pointer");

    scene.add(controls.getObject());

    const onKeyDown = function (event) {
        switch (event.keyCode) {
            case 38: // up
            case 87: // w
                moveForward = true;
                break;

            case 37: // left
            case 65: // a
                moveLeft = true;
                break;

            case 40: // down
            case 83: // s
                moveBackward = true;
                break;

            case 39: // right
            case 68: // d
                moveRight = true;
                break;

            case 32: // space
                if (canJump === true) velocity.y += 120;
                canJump = false;
                break;

            case 69: //E
                if (!paused && INTERSECTED) {
                    if (!lockedOn) {
                        INTERSECTED.interact(event);
                    } else {
                        lockedOn = undefined;
                    }
                }
                break;
        }
    };

    const onKeyUp = function (event) {
        switch (event.keyCode) {
            case 38: // up
            case 87: // w
                moveForward = false;
                break;

            case 37: // left
            case 65: // a
                moveLeft = false;
                break;

            case 40: // down
            case 83: // s
                moveBackward = false;
                break;

            case 39: // right
            case 68: // d
                moveRight = false;
                break;
        }
    };

    document.addEventListener("keydown", onKeyDown, false);
    document.addEventListener("keyup", onKeyUp, false);

    raycaster = new THREE.Raycaster(
        new THREE.Vector3(),
        new THREE.Vector3(0, -1, 0),
        0,
        12
    );

    // Create the scene

    // Create a sine-like wave
    splineCurve = new THREE.SplineCurve([
        new THREE.Vector2(-5, 0),
        new THREE.Vector2(-2.5, 2.5),
        new THREE.Vector2(0, 0),
        new THREE.Vector2(2.5, -2.5),
        new THREE.Vector2(5, 0),
    ]);

    createScene();

    //Make the renderer and cameras correct sizes

    resize();

    // SETUP LOADER

    var total_loader = document.createElement("div");
    total_loader.classList.add("loader");
    total_loader.id = "loader_total";
    total_loader.append(document.createElement("div"));

    document.getElementById("loader_wrapper").append(total_loader);

    // LOAD

    loadingInterval = setInterval(updateLoading, 80);

    instructions = document.getElementById("instructions");

    window.addEventListener("resize", resize);
    animate();

    window.addEventListener("mousemove", onMouseMove, false);
    window.addEventListener("click", onMouseClick, false);
}

function onMouseMove(event) {
    if (controls.isLocked === true) {
        mouse = { x: 0, y: 0 };
    } else {
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    }
}

function createScene() {
    sceneGeometery = new THREE.Group();

    //***************
    // SCENE GEOMETRY
    //***************

    // OG Curve to space the paintings
    curve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        10,
        10, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    var points = curve.getPoints(50);

    /*DRAW THE ELLIPSE IF WE NEED
	var geometry = new THREE.BufferGeometry().setFromPoints( points );
	var material = new THREE.LineBasicMaterial( { color : 0x709fda } );
	// Create the final object to add to the scene
	var ellipse = new THREE.Line( geometry, material );
	ellipse.rotation.x = Math.PI/2;
	//scene.add(ellipse);
	*/

    // LOAD CLOWN
    var loader = new GLTFLoader();
    totalThingsToLoad++;
    loader.load(clownModel, function (gltf) {
        totalThingsLoaded++;
        gltf.scene.traverse(function (child) {
            if (child.isMesh) {
                var material = new THREE.MeshPhongMaterial({
                    color: 0xffffff,
                    side: THREE.DoubleSide,
                    reflectivity: 1,
                    shininess: 1,
                    vertexColors: true,
                });
                child.material.vertexColors = false;
                child.material = material;
                clown = child;
            }
        });

        clown.geometry.rotateX(Math.PI / 2);
        clown.lookAt(camera.position.x, clown.position.y, camera.position.z);
        clown.castShadow = true;
        clown.receiveShadow = true;

        clown.position.y = -3.9;
        clown.translateZ(50);
        clown.refMaterial = clown.material.clone();
        clown.walking = false;
        clown.destination;
        clown.distanceToCover = 0;
        clown.movePath;
        clown.movePercent = 0;
        clown.destinationSteps = 0;
        clown.step = 0;
        clown.currentStep = 0;
        clown.moveInterval;
        clown.moveVector = new THREE.Vector3();
        clown.raycaster = new THREE.Raycaster(
            new THREE.Vector3(),
            new THREE.Vector3(0, -1, 0),
            0,
            10
        );
        clown.callback;
        clown.refScale = clown.scale.clone();
        clown.scaleVelocity = 0.001;
        clown.scaleStep = 0;
        clown.talking = false;
        clown.sounds = {
            steps: [],
        };
        clown.active = false;

        clown.sounds.steps[0] = new THREE.PositionalAudio(listener);
        clown.sounds.steps[1] = new THREE.PositionalAudio(listener);
        clown.sounds.talk = new THREE.PositionalAudio(listener);

        totalThingsToLoad++;
        var audioloaderone = new THREE.AudioLoader().load(
            pas1,
            function (buffer) {
                totalThingsLoaded++;
                clown.sounds.steps[0].setBuffer(buffer);
                clown.sounds.steps[0].setRefDistance(20);
                clown.sounds.steps[0].loop = false;
            }
        );

        totalThingsToLoad++;
        var audioloadertwo = new THREE.AudioLoader().load(
            pas2,
            function (buffer) {
                totalThingsLoaded++;
                clown.sounds.steps[1].setBuffer(buffer);
                clown.sounds.steps[1].setRefDistance(20);
                clown.sounds.steps[1].loop = false;
            }
        );

        totalThingsToLoad++;
        var audioloaderthree = new THREE.AudioLoader().load(
            horn,
            function (buffer) {
                totalThingsLoaded++;
                clown.sounds.talk.setBuffer(buffer);
                clown.sounds.talk.setRefDistance(20);
                clown.sounds.talk.loop = false;
            }
        );

        clown.setDestination = function (dest, callback) {
            this.destination = dest;
            this.destinationSteps = dest.length;
            this.currentStep = 0;
            this.goTo(this.currentStep);

            if (callback) {
                this.callback = callback;
            }
        };

        clown.goTo = function (step) {
            this.movePath = new THREE.CatmullRomCurve3([
                this.position.clone(),
                this.destination[step].clone(),
            ]);

            //GET THE THING WALKING
            if (this.walking === false) {
                this.walking = true;

                this.moveInterval = setInterval(function () {
                    clown.walkToObjective();
                }, 300);
            }
        };

        clown.interact = function () {
            if (!this.walking && !this.active) {
                this.activate();
            }
            if (!this.walking && this.active) {
                this.talk();
            }
        };

        clown.activate = function () {
            var destinationList = [
                new THREE.Vector3(22, -3.9, -2.5),
                new THREE.Vector3(6, -3.5, -20),
            ];

            this.setDestination(destinationList, startCaroussel);
            this.active = true;
        };

        clown.snapToGround = function () {
            this.raycaster.ray.origin.copy(this.position);
            this.raycaster.ray.origin.y -= 0;

            var intersections = this.raycaster.intersectObjects(groundsArray);
            var onObject = intersections.length > 0;

            if (intersections.length > 0) {
                this.position.y = intersections[0].point.y + 6.6;
            }
        };

        clown.talk = function () {
            if (!this.talking) {
                this.talking = true;
            }

            if (!this.sounds.talk.isPlaying) {
                this.sounds.talk.play();
            }

            if (this.scaleStep === 0) {
                this.scale.y -= this.scaleVelocity;

                if (this.scale.y < (this.refScale.y * 50) / 100) {
                    //this.scaleVelocity *= -1;
                    this.scaleStep++;
                }
            }

            if (this.scaleStep === 1) {
                this.scale.y += this.scaleVelocity;

                if (this.scale.y > (this.refScale.y * 150) / 100) {
                    //this.scaleVelocity *= -1;
                    this.scaleStep++;
                }
            }

            if (this.scaleStep === 2) {
                this.scale.y = this.refScale.y;
                this.scaleStep = 0;
                this.talking = false;
            }
        };

        clown.walkToObjective = function () {
            if (!paused) {
                this.step++;

                this.position.copy(
                    this.movePath.getPointAt(
                        EasingFunctions.easeInOutQuad(this.movePercent)
                    )
                );
                this.movePercent += 0.1;

                this.snapToGround();

                this.lookAt(
                    this.destination[this.currentStep].x,
                    this.position.y,
                    this.destination[this.currentStep].z
                );

                if (this.step % 2 === 0) {
                    this.rotateZ(0.1);
                    this.rotateY(-0.1);
                    this.sounds.steps[0].play();
                } else {
                    this.rotateZ(-0.1);
                    this.rotateY(0.1);
                    this.sounds.steps[1].play();
                }

                //DESTINATION REACHED

                if (this.movePercent >= 1) {
                    this.movePercent = 0;

                    if (this.currentStep + 1 < this.destinationSteps) {
                        this.currentStep++;
                        this.goTo(this.currentStep);
                    } else {
                        this.walking = false;
                        clearInterval(this.moveInterval);
                        if (this.callback) {
                            setTimeout(this.callback, 750);
                        }
                    }
                }
            }
        };

        interactiveObjects.push(clown);
        scene.add(clown);
    });

    // Make Paintings
    /* var paintings = document.querySelectorAll(".texture-image");
    paintings.forEach(makePainting); */

    // Make Caroussel
    makeCaroussel();

    sceneGeometery.add(caroussel);

    // Make Ground
    totalThingsToLoad++;
    var source = plancher;
    var texture = new THREE.TextureLoader().load(source, function () {
        totalThingsLoaded++;
    });
    texture.anisotropy = 16;
    var material = new THREE.MeshPhongMaterial({
        map: texture,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var ground = new THREE.Mesh(new THREE.PlaneGeometry(500, 500), material);
    ground.castShadow = true;
    ground.receiveShadow = true;
    ground.position.y = -12;
    ground.rotation.x = Math.PI / 2;
    sceneGeometery.add(ground);
    ground.name = "ground";
    groundsArray.push(ground);

    // Skybox
    totalThingsToLoad++;
    var source = skybox;
    var texture = new THREE.TextureLoader().load(source, function () {
        totalThingsLoaded++;
    });
    texture.anisotropy = 16;
    var material = new THREE.MeshBasicMaterial({
        map: texture,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.SphereGeometry(1500, 200, 200),
        material
    );
    mesh.position.y = 150;
    sceneGeometery.add(mesh);

    //nature
    totalThingsToLoad++;
    var source = groundTexture;
    var texture = new THREE.TextureLoader().load(source, function () {
        totalThingsLoaded++;
    });
    texture.anisotropy = 16;
    var material = new THREE.MeshPhongMaterial({
        map: texture,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var hill = new THREE.Mesh(
        new THREE.SphereBufferGeometry(
            15,
            5,
            5,
            0,
            Math.PI * 2,
            0,
            Math.PI / 2
        ),
        material
    );
    hill.castShadow = true;
    hill.receiveShadow = true;

    var arbre = new THREE.Group();
    totalThingsToLoad++;
    var source = tree;
    var texture = new THREE.TextureLoader().load(source, function () {
        totalThingsLoaded++;
    });
    texture.anisotropy = 16;
    var material = new THREE.MeshPhongMaterial({
        map: texture,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderBufferGeometry(0.2, 2, 125, 10, 10),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    arbre.add(mesh);
    totalThingsToLoad++;
    var source = leaf;
    var texture = new THREE.TextureLoader().load(source, function () {
        totalThingsLoaded++;
    });
    texture.anisotropy = 16;
    var material = new THREE.MeshPhongMaterial({
        map: texture,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderBufferGeometry(0.2, 8, 30, 10, 10),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.position.y = 45;
    arbre.add(mesh);

    var refMesh = new THREE.Mesh(
        new THREE.PlaneGeometry(500, 500, 100, 100),
        material
    );
    refMesh.position.y = -12;
    refMesh.geometry.rotateX(Math.PI / 2);

    var vertices = refMesh.geometry.attributes.position;
    var limits = {
        lower: [-62, -70],
        higher: [250, 130],
    };
    for (var i = 0; i < 200; i++) {
        var vertice;
        var coord;
        //Get random vertice not in the unholy square
        do {
            vertice = Math.floor(Math.random() * vertices.count);
            coord = {
                x: vertices.getX(vertice),
                z: vertices.getZ(vertice),
            };
        } while (
            coord.x > limits.lower[0] &&
            coord.x < limits.higher[0] &&
            coord.z > limits.lower[1] &&
            coord.z < limits.higher[1]
        );

        var element;
        if (Math.random() < 0.15) {
            element = arbre.clone();
        } else {
            element = hill.clone();
        }
        var y = Math.random() * 5 + 16;

        element.position.set(coord.x, -y, coord.z);
        element.scale.set(
            Math.random() + 1,
            Math.random() + 0.5,
            Math.random() + 1
        );
        element.rotateY(Math.random() * Math.PI);

        sceneGeometery.add(element);
        groundsArray.push(element);
    }
}

function startCaroussel() {
    caroussel.on = true;
    caroussel.music.play();
}

function makePainting(item, index, arr) {
    var paintingObject = new THREE.Group();
    var height = item.dataHeight;
    var width = item.dataWidth;
    var y = splineCurve.getPointAt((index + 1) / arr.length).y;

    //Création de la peinture
    item.anisotropy = 16;
    var material = new THREE.MeshBasicMaterial({
        map: item,
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.BoxGeometry(width / 10, height / 10, 0.1),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.refMaterial = mesh.material.clone();
    mesh.interact = function (e) {
        var type = e.type;
        if (type === "click") {
            if (caroussel.on) {
                this.parent.rotationSpeed = 1;
                if (this.hitSound.isPlaying) {
                    this.hitSound.stop();
                }
                this.hitSound.play();
            }
        }
        if (type === "keydown") {
            if (!lockedOn) {
                lockedOn = this.parent;
            }
        }
    };
    mesh.hitSound = new THREE.PositionalAudio(listener);

    totalThingsToLoad++;
    var audioloader = new THREE.AudioLoader().load(
        tennisServe,
        function (buffer) {
            totalThingsLoaded++;
            mesh.hitSound.setBuffer(buffer);
            mesh.hitSound.setRefDistance(20);
            mesh.hitSound.loop = false;
        }
    );

    interactiveObjects.push(mesh);
    paintingObject.add(mesh);

    //spot pour la camera
    var material = new THREE.MeshPhongMaterial({
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var cameraStand = new THREE.Mesh(
        new THREE.BoxBufferGeometry(0.01, 0.01, 0.01),
        material
    );

    if (width < height) {
        cameraStand.translateZ(height / 7.5);
    } else {
        cameraStand.translateZ(width / 7.5);
    }

    cameraStand.name = "camera";
    cameraStand.visible = false;
    paintingObject.add(cameraStand);

    //Poteau
    var poteauHeight = 20;
    var material = new THREE.MeshPhongMaterial({
        color: 0xffffff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var poteau = new THREE.Mesh(
        new THREE.CylinderGeometry(
            0.05,
            0.05,
            poteauHeight - height / 10 + height / 10 / 2,
            20
        ),
        material
    );
    poteau.translateY(-(poteauHeight / 2) - height / 10 / 4);
    poteau.castShadow = true;
    poteau.receiveShadow = true;
    paintingObject.add(poteau);

    //Position de la peinture sur le cercle
    var pos = curve.getPointAt((index + 1) / arr.length);
    paintingObject.position.x = pos.x;
    paintingObject.position.z = pos.y;
    paintingObject.position.y = y;
    paintingObject.lookAt(new THREE.Vector3(0, y, 0));
    paintingObject.velocity = 0.015;
    paintingObject.rotationSpeed = 0.01;
    paintingObject.lockedOn = false;

    paintingsArray.push(paintingObject);
    caroussel.add(paintingObject);
}

//Création de la 3d du caroussel

function makeCaroussel() {
    //base
    var material = new THREE.MeshPhongMaterial({
        color: 0xffff00,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(15, 15, 2, 50),
        material
    );
    mesh.position.y = -11;
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    sceneGeometery.add(mesh);
    mesh.name = "base";
    groundsArray.push(mesh);

    //Chemin
    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        13.83,
        13.83, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    var pos = barriereCurve.getPointAt(19.5 / 20);
    var material = new THREE.MeshPhongMaterial({
        color: 0x00ff00,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(new THREE.BoxGeometry(7, 2, 80), material);
    mesh.position.y = -11.5;
    mesh.position.x = pos.x;
    mesh.position.z = pos.y;
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.lookAt(new THREE.Vector3(0, -11.5, 0));
    //étrange rotation, x-z-y??
    mesh.translateOnAxis(
        new THREE.Vector3(mesh.rotation.x, mesh.rotation.z, mesh.rotation.y),
        20
    );
    mesh.name = "chemin";
    groundsArray.push(mesh);
    sceneGeometery.add(mesh);

    //on met la caméra a la bonne place, oups
    camera.position.set(pos.x, 0, pos.y);
    camera.lookAt(new THREE.Vector3(0, 0, 0));
    camera.translateOnAxis(
        new THREE.Vector3(mesh.rotation.x, mesh.rotation.z, mesh.rotation.y),
        -30
    );

    //milieupoteau
    var material = new THREE.MeshPhongMaterial({
        color: 0x824d0f,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(1, 1, 18, 20),
        material
    );
    mesh.position.y = -1;
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    caroussel.add(mesh);

    //barriere bas
    var barriere = new THREE.Group();

    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        14,
        14, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    var material = new THREE.MeshPhongMaterial({
        color: 0x6fc0ff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });

    for (var i = 0; i < 20; i++) {
        var pos = barriereCurve.getPointAt(i / 20);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.15, 4, 0.15),
            material
        );
        mesh.position.set(pos.x, -8, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -8, 0));
        barriere.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.08, 2, 0.08),
            material
        );
        mesh.position.set(pos.x, -6, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -6, 0));
        barriere.add(mesh);
    }

    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        13.83,
        13.83, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    for (var i = 0; i < 19; i++) {
        var pos = barriereCurve.getPointAt((i + 0.5) / 20);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(4.3, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, -8, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -8, 0));
        barriere.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(4.3, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, -6.2, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -6.2, 0));
        barriere.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(4.3, 0.07, 0.07),
            material
        );
        mesh.position.set(pos.x, -7, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -7, 0));
        barriere.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(4.3, 0.07, 0.07),
            material
        );
        mesh.position.set(pos.x, -9, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -9, 0));
        barriere.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.15, 2, 0.15),
            material
        );
        mesh.position.set(pos.x, -8, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -8, 0));
        barriere.add(mesh);
    }

    sceneGeometery.add(barriere);

    //base qui bouge
    var material = new THREE.MeshPhongMaterial({
        color: 0x0000ff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(13, 13, 1, 50),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.position.y = -10.25;
    caroussel.add(mesh);
    mesh.name = "basebouge";
    groundsArray.push(mesh);

    //haut
    var toit = new THREE.Group();
    var material = new THREE.MeshPhongMaterial({
        color: 0xff0000,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(5, 16.5, 5, 50),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    toit.add(mesh);

    var material = new THREE.MeshPhongMaterial({
        color: 0xffff00,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(17, 17, 0.5, 50),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.position.y = -2.5;
    toit.add(mesh);

    toit.position.y = 10;

    //Barrieres toit
    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        16.5,
        16.5, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    var material = new THREE.MeshPhongMaterial({
        color: 0x6fc0ff,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });

    //large barriere du haut
    for (var i = 0; i < 20; i++) {
        var pos = barriereCurve.getPointAt(i / 20);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.15, 4, 0.15),
            material
        );
        mesh.position.set(pos.x, -0.5, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -0.5, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.08, 2, 0.08),
            material
        );
        mesh.position.set(pos.x, 1.5, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, 1.5, 0));
        toit.add(mesh);
    }

    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        16.3,
        16.3, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    for (var i = 0; i < 20; i++) {
        var pos = barriereCurve.getPointAt((i + 0.5) / 20);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(5.1, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, -1, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, -1, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(1.5, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, 0.3, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, 0.3, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(5.1, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, 1, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, 1, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.15, 2, 0.15),
            material
        );
        mesh.position.set(pos.x, 0, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, 0, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.08, 1, 0.08),
            material
        );
        mesh.position.set(pos.x, 1, pos.y);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        mesh.lookAt(new THREE.Vector3(0, 1, 0));
        toit.add(mesh);
    }

    //petite barriere du haut
    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        4.5,
        4.5, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );
    for (var i = 0; i < 8; i++) {
        var pos = barriereCurve.getPointAt(i / 8);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.15, 3, 0.15),
            material
        );
        mesh.position.set(pos.x, 3.5, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 3.5, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.08, 1, 0.08),
            material
        );
        mesh.position.set(pos.x, 5.5, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 5.5, 0));
        toit.add(mesh);
    }

    var barriereCurve = new THREE.EllipseCurve(
        0,
        0, // ax, aY
        4.15,
        4.15, // xRadius, yRadius
        0,
        2 * Math.PI, // aStartAngle, aEndAngle
        false, // aClockwise
        0 // aRotation
    );

    for (var i = 0; i < 8; i++) {
        var pos = barriereCurve.getPointAt((i + 0.5) / 8);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(3.5, 0.15, 0.15),
            material
        );
        mesh.position.set(pos.x, 4, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 4, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(3.5, 0.07, 0.07),
            material
        );
        mesh.position.set(pos.x, 5, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 5, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(3.5, 0.07, 0.07),
            material
        );
        mesh.position.set(pos.x, 3, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 3, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.07, 2, 0.07),
            material
        );
        mesh.position.set(pos.x, 4, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 4, 0));
        toit.add(mesh);

        var mesh = new THREE.Mesh(
            new THREE.BoxGeometry(0.08, 1, 0.08),
            material
        );
        mesh.position.set(pos.x, 1, pos.y);
        mesh.lookAt(new THREE.Vector3(0, 1, 0));
        toit.add(mesh);
    }

    var material = new THREE.MeshPhongMaterial({
        color: 0x00ff00,
        side: THREE.DoubleSide,
        reflectivity: 0,
    });
    var mesh = new THREE.Mesh(
        new THREE.CylinderGeometry(0, 3, 9, 30),
        material
    );
    mesh.castShadow = true;
    mesh.receiveShadow = true;
    mesh.position.y = 7;
    toit.add(mesh);

    caroussel.add(toit);

    //Objet Caroussel

    caroussel.on = false;
    caroussel.speed = 0;
    caroussel.music = new THREE.PositionalAudio(listener);

    // BACKGROUND SOUND

    totalThingsToLoad++;
    var audioloader = new THREE.AudioLoader().load(
        carousselMusic,
        function (buffer) {
            totalThingsLoaded++;
            caroussel.music.setBuffer(buffer);
            caroussel.music.setRefDistance(40);
            caroussel.music.loop = true;
            //bgSound.play();
        }
    );
}

//Fin du chargement, instanciation de l'interactivité opour les controles
function doneLoading() {
    document.getElementById("loader_wrapper").classList.add("done");

    paintingTextures.forEach((item, index, arr) => {
        makePainting(item, index, arr);
    });

    scene.add(sceneGeometery);

    setTimeout(function () {
        document.getElementById("loader_wrapper").remove();

        instructions.style.display = "block";

        /*
		var menu = document.createElement("div");
		menu.id = "menu";
		menu.append(document.createElement("div"));
		var text = document.createElement("p");
		var node = document.createTextNode("Bienvenue");
		text.appendChild(node);
		menu.children[0].append(text);
		text = document.createElement("p");
		node = document.createTextNode("Cliquez");
		text.appendChild(node);
		menu.children[0].append(text);

		document.getElementById("main").append(menu);

		/* Setup controls interaction */

        instructions.addEventListener(
            "click",
            function () {
                controls.lock();
                setTimeout(function () {
                    paused = false;
                }, 200);
            },
            false
        );
        controls.addEventListener("lock", function () {
            instructions.style.display = "none";
        });

        controls.addEventListener("unlock", function () {
            instructions.style.display = "block";
        });

        /* Controls setup end */

        if (debug === true) {
            interactiveObjects.forEach(setupHelper);
        }
    }, 1000 / globalSpeed);
}

function setupHelper(item, index) {
    item.helper = new THREE.BoxHelper(item, 0xff0000);
    //helper = new THREE.BoxHelper(clown, 0xff0000);
    item.helper.update();
    // If you want a visible bounding box
    scene.add(item.helper);
}

function resize() {
    WIDTH = window.innerWidth;
    HEIGHT = window.innerHeight;

    camera.aspect = WIDTH / HEIGHT;
    camera.updateProjectionMatrix();
    renderer.setSize(WIDTH, HEIGHT);
}

function onMouseClick(e) {
    e.preventDefault();

    if (!paused && INTERSECTED) {
        INTERSECTED.interact(e);
        //INTERSECTED.parent.rotationSpeed = 1;
    }

    return false;
}

function moveCaroussel() {
    if (caroussel.speed < 1) {
        caroussel.speed += 0.001;
        caroussel.music.setPlaybackRate(caroussel.speed);
    }

    for (var i = 0; i < paintingsArray.length; i++) {
        var painting = paintingsArray[i];
        painting.rotation.y += painting.rotationSpeed * caroussel.speed;
        if (painting.rotationSpeed > 0.01) {
            painting.rotationSpeed -= 0.01;
        }
        painting.position.y += painting.velocity * caroussel.speed;

        if (painting.position.y > 3 || painting.position.y < -3) {
            painting.velocity *= -1;
        }
    }

    caroussel.rotation.y += 0.01 * caroussel.speed;
}

function animate() {
    delta = clock.getDelta();

    requestAnimationFrame(animate);

    if (!paused) {
        if (caroussel.on) {
            moveCaroussel();
            if (!caroussel.music.isPlaying) {
                caroussel.music.play();
            }
        }

        if (clown.walking === false) {
            clown.lookAt(
                camera.position.x,
                clown.position.y,
                camera.position.z
            );
        }

        if (clown.talking === true) {
            clown.talk();
        }

        if (debug === true) {
            interactiveObjects.forEach(function (item, index) {
                item.helper.update();
            });
        }

        interactionRay.setFromCamera(mouse, camera);

        var intersects = [];

        for (var i = 0; i < interactiveObjects.length; i++) {
            var box = new THREE.Box3().setFromObject(interactiveObjects[i]);

            if (interactionRay.ray.intersectsBox(box)) {
                var seenObject = {};

                seenObject.object = interactiveObjects[i];
                seenObject.distanceVector = new THREE.Vector3();
                interactionRay.ray.intersectBox(box, seenObject.distanceVector);
                seenObject.distance = seenObject.distanceVector.distanceTo(
                    camera.position
                );
                intersects.push(seenObject);
            }
        }

        intersects.sort((a, b) => (a.distance > b.distance ? 1 : -1));

        if (intersects.length > 0) {
            if (INTERSECTED != intersects[0].object) {
                if (INTERSECTED) {
                    INTERSECTED.material.copy(INTERSECTED.refMaterial);
                }

                INTERSECTED = intersects[0].object;
            }
            //INTERSECTED.material.color.set( 0xff0000 );
            pointer.classList.add("hover");
        } else {
            if (INTERSECTED) {
                INTERSECTED.material.copy(INTERSECTED.refMaterial);
            }

            INTERSECTED = undefined;
            pointer.classList.remove("hover");
        }
    } else {
        if (caroussel.music.isPlaying) {
            caroussel.music.pause();
        }
    }

    //make things move if it's locked, otherwise set the thing to pause
    if (controls.isLocked === true) {
        makeMovement();
    } else {
        paused = true;
    }

    renderer.render(scene, camera);
}

function makeMovement() {
    raycaster.ray.origin.copy(controls.getObject().position);
    raycaster.ray.origin.y -= 0;

    const intersections = raycaster.intersectObjects(groundsArray);
    const onObject = intersections.length > 0;

    velocity.x -= velocity.x * 10.0 * delta;
    velocity.z -= velocity.z * 10.0 * delta;

    velocity.y -= 9.8 * 50 * delta; // 100.0 = mass

    direction.z = Number(moveForward) - Number(moveBackward);
    direction.x = Number(moveRight) - Number(moveLeft);
    direction.normalize(); // this ensures consistent movements in all directions

    if (moveForward || moveBackward) velocity.z -= direction.z * 400.0 * delta;
    if (moveLeft || moveRight) velocity.x -= direction.x * 400.0 * delta;

    controls.moveRight(-velocity.x * delta);
    controls.moveForward(-velocity.z * delta);

    controls.getObject().position.y += velocity.y * delta; // new behavior

    if (intersections.length > 0 && velocity.y * delta < 1) {
        velocity.y = 0;
        camera.position.y = intersections[0].point.y + 10.5;
        //camera.position.y = Number(camera.position.y.toFixed(2));
        //console.log("apres" + camera.position.y);

        canJump = true;
    }

    //console.log(camera.position);

    if (lockedOn) {
        var cameraPosition = new THREE.Vector3();
        lockedOn.getObjectByName("camera").getWorldPosition(cameraPosition);
        camera.position.copy(cameraPosition);
        var paintingPosition = new THREE.Vector3();
        lockedOn.getWorldPosition(paintingPosition);
        camera.lookAt(paintingPosition);
    }
}

function updateLoading() {
    var totalLoaded = ((totalThingsLoaded * 100) / totalThingsToLoad).toFixed(
        0
    );

    var loaderDiv = document.getElementById("loader_total").children[0];
    loaderDiv.innerHTML =
        totalThingsLoaded + " / " + totalThingsToLoad + " loaded";
    //loaderDiv.style.width = totalLoaded+"%";

    if (totalThingsLoaded == totalThingsToLoad) {
        clearInterval(loadingInterval);
        setTimeout(function () {
            doneLoading();
        }, 500);
    }
}
</script>
<template>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div id="pointer"></div>
            <div id="loader_wrapper"></div>
            <div id="instructions">
                <h2>Bienvenue au Caroussel de Peintures 2020</h2>
                <p>Cliquer dans la boîte pour commencer</p>
                <ul>
                    <li>W A S D + Souris = Bouger</li>
                    <li>Espace = Sauter</li>
                    <li>E (sur peinture) = Regarder peinture</li>
                    <li>Click = Interagir</li>
                    <li>ESC = Pause</li>
                </ul>
            </div>

            <!-- <?php while ($peintures->have_posts()): ?>
            <?php $peintures->the_post(); ?>
            <?php
				$image = get_field('image');
				$size = 'large';
				$rawSize = explode(" ", get_field('size'))
			?> -->
            <!-- <div
                class="texture-image"
                data-width="<?php echo $rawSize[0]; ?>"
                data-height="<?php echo $rawSize[2]; ?>"
                data-url="<?php echo wp_get_attachment_image_url($image, $size); ?>"
            ></div> -->
        </main>
        <!-- #main -->
    </div>
    <!-- #primary -->
</template>
<style lang="scss">
#primary {
    display: block;
    background: red;
    margin: 0;
    line-height: 0;
    color: black;

    main {
        height: 100vh;
        width: 100vw;
    }

    canvas {
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 1;
    }

    #loader_wrapper,
    #instructions {
        //display: none;

        line-height: 1;
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: red;
        padding: 20px;
        border-radius: 10px;
        font-size: 2em;
        font-family: impact;
        box-shadow: 0px 0px 5px 20px blue, 0px 0px 30px 50px yellow;
        text-align: center;

        p,
        li {
            font-size: 0.8em;
            list-style-type: none;
        }
    }

    #instructions {
        display: none;
        cursor: pointer;
    }

    .texture-image {
        display: none;
    }

    #pointer {
        position: absolute;
        width: 10px;
        height: 10px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background-color: white;
        z-index: 2;
        box-shadow: 0px 0px 5px 5px red;

        &.hover {
            width: 2px;
            height: 2px;
        }
    }
}
</style>
