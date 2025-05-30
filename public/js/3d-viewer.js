function initModelViewer() {
    // Get the container
    const container = document.getElementById('model-viewer');
    const loadingSpinner = document.getElementById('loading-spinner');
    const modelInfo = document.getElementById('model-info');

    if (!container) {
        console.error('Container not found');
        return;
    }

    // Check if THREE.js is loaded
    if (typeof THREE === 'undefined') {
        console.error('THREE.js not loaded');
        if (modelInfo) modelInfo.textContent = 'Error: THREE.js not loaded';
        if (loadingSpinner) loadingSpinner.style.display = 'none';
        return;
    }

    // Create scene with a dark blue background
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x16213e); // Dark blue background

    // Create camera with proper position
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 2000);
    camera.position.set(0, 0, 5);

    // Create renderer with antialiasing
    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true // Allow transparency
    });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio > 2 ? 2 : window.devicePixelRatio);
    if (THREE.sRGBEncoding) {
        renderer.outputEncoding = THREE.sRGBEncoding;
    }
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);

    // Add lights - important for seeing the model
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.7); // Brighter ambient light
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1.0); // Brighter directional light
    directionalLight.position.set(5, 10, 7);
    directionalLight.castShadow = true;
    scene.add(directionalLight);

    // Add a secondary light from another angle
    const secondaryLight = new THREE.DirectionalLight(0xffffff, 0.5);
    secondaryLight.position.set(-5, 0, -5);
    scene.add(secondaryLight);

    // Add orbit controls with better default settings
    let controls;
    if (typeof THREE.OrbitControls === 'function') {
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.rotateSpeed = 0.7;
        controls.minDistance = 2;
        controls.maxDistance = 10;
        controls.autoRotate = true; // Auto-rotate by default
        controls.autoRotateSpeed = 1.0; // Moderate rotation speed
    } else {
        console.error('OrbitControls not available');
        if (modelInfo) modelInfo.textContent = 'Error: OrbitControls not available';
    }

    // Create clock for animation
    const clock = new THREE.Clock();
    let mixer;
    let model;

    // Animation function
    function animate() {
        requestAnimationFrame(animate);

        const delta = clock.getDelta();

        // Update mixer if available (for animated models)
        if (mixer) {
            mixer.update(delta);
        }

        // Update controls if available
        if (controls) {
            controls.update();
        }

        renderer.render(scene, camera);
    }

    // Load the 3D model
    function loadModel() {
        if (typeof THREE.GLTFLoader !== 'function') {
            console.error('GLTFLoader not available');
            if (modelInfo) modelInfo.textContent = 'Error: GLTFLoader not available';
            if (loadingSpinner) loadingSpinner.style.display = 'none';
            return;
        }

        const loader = new THREE.GLTFLoader();

        // Try multiple model paths in order
        const modelPaths = [
            '/models/night_sky_visible_spectrum_monochromatic.glb',
            './models/night_sky_visible_spectrum_monochromatic.glb',
            '../models/night_sky_visible_spectrum_monochromatic.glb',
            '/public/models/night_sky_visible_spectrum_monochromatic.glb',
            '/assets/models/night_sky_visible_spectrum_monochromatic.glb',
            '/storage/models/night_sky_visible_spectrum_monochromatic.glb'
        ];

        let currentModelIndex = 0;

        function tryLoadModel() {
            if (currentModelIndex >= modelPaths.length) {
                console.error('Failed to load any model');
                if (modelInfo) modelInfo.textContent = 'Загвар: Алдаа гарлаа';
                if (loadingSpinner) loadingSpinner.style.display = 'none';

                // Create a fallback sphere to show something
                const geometry = new THREE.SphereGeometry(1, 32, 32);
                const material = new THREE.MeshStandardMaterial({
                    color: 0x3498db,
                    roughness: 0.3,
                    metalness: 0.8
                });
                const sphere = new THREE.Mesh(geometry, material);
                scene.add(sphere);
                model = sphere;
                return;
            }

            const modelPath = modelPaths[currentModelIndex];
            console.log(`Trying to load model from: ${modelPath}`);

            // Show loading status
            if (modelInfo) modelInfo.textContent = `Ачаалж байна: 0%`;
            if (loadingSpinner) loadingSpinner.style.display = 'block';

            loader.load(
                modelPath,
                function(gltf) {
                    console.log('Model loaded successfully from:', modelPath);
                    model = gltf.scene;

                    // Check for animations
                    if (gltf.animations && gltf.animations.length) {
                        mixer = new THREE.AnimationMixer(model);
                        const action = mixer.clipAction(gltf.animations[0]);
                        action.play();
                        console.log('Animation playing');
                    }

                    // Center and scale model
                    const box = new THREE.Box3().setFromObject(model);
                    const center = box.getCenter(new THREE.Vector3());
                    const size = box.getSize(new THREE.Vector3());

                    // Reset position to center
                    model.position.x = -center.x;
                    model.position.y = -center.y;
                    model.position.z = -center.z;

                    // Scale the model to be larger
                    const maxDim = Math.max(size.x, size.y, size.z);
                    const scaleFactor = 2.5 / maxDim; // Make it 2.5x larger
                    model.scale.multiplyScalar(scaleFactor);

                    // Apply shadows and improve materials
                    model.traverse(function(node) {
                        if (node.isMesh) {
                            node.castShadow = true;
                            node.receiveShadow = true;

                            // Improve material quality
                            if (node.material) {
                                node.material.needsUpdate = true;
                                // Add some shine if material is too dull
                                if (node.material.roughness > 0.7) {
                                    node.material.roughness = 0.7;
                                }
                            }
                        }
                    });

                    // Add model to scene
                    scene.add(model);

                    // Update model info and hide loading spinner
                    if (modelInfo) {
                        const modelName = modelPath.split('/').pop().replace('.glb', '');
                        modelInfo.textContent = `Загвар: ${modelName}`;
                        modelInfo.style.display = 'block';
                    }
                    if (loadingSpinner) {
                        loadingSpinner.style.display = 'none';
                    }

                    console.log('Model added to scene successfully');
                },
                function(xhr) {
                    if (xhr.lengthComputable) {
                        const percentComplete = xhr.loaded / xhr.total * 100;
                        console.log(`${percentComplete.toFixed(2)}% loaded`);
                        if (modelInfo) {
                            modelInfo.textContent = `Ачаалж байна: ${percentComplete.toFixed(0)}%`;
                        }
                    }
                },
                function(error) {
                    console.error('Error loading model from ' + modelPath, error);
                    currentModelIndex++;
                    tryLoadModel(); // Try next model path
                }
            );
        }

        // Start trying to load models
        tryLoadModel();
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });

    // Start animation
    animate();

    // Load the model
    loadModel();

    console.log('Viewer initialized');

    // Add double-click event to toggle auto-rotation
    container.addEventListener('dblclick', function() {
        if (controls) {
            controls.autoRotate = !controls.autoRotate;
            console.log('Auto-rotate:', controls.autoRotate);
        }
    });

    return {
        scene,
        camera,
        renderer,
        controls
    };
}

// Check if libraries are loaded and load them if necessary
function loadLibrariesAndInitViewer() {
    console.log('Checking libraries...');

    // Check if THREE is loaded
    if (typeof THREE === 'undefined') {
        console.log('Loading THREE.js...');

        // Load THREE.js first
        const threeScript = document.createElement('script');
        threeScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
        threeScript.onload = function() {
            console.log('THREE.js loaded');

            // Then load OrbitControls
            const orbitControlsScript = document.createElement('script');
            orbitControlsScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/controls/OrbitControls.js';
            orbitControlsScript.onload = function() {
                console.log('OrbitControls loaded');

                // Finally load GLTFLoader
                const gltfLoaderScript = document.createElement('script');
                gltfLoaderScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/loaders/GLTFLoader.js';
                gltfLoaderScript.onload = function() {
                    console.log('GLTFLoader loaded');

                    // Wait a bit to make sure everything is initialized
                    setTimeout(initModelViewer, 100);
                };
                document.head.appendChild(gltfLoaderScript);
            };
            document.head.appendChild(orbitControlsScript);
        };
        document.head.appendChild(threeScript);
    } else if (typeof THREE.OrbitControls === 'undefined') {
        console.log('Loading OrbitControls...');

        // Load OrbitControls
        const orbitControlsScript = document.createElement('script');
        orbitControlsScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/controls/OrbitControls.js';
        orbitControlsScript.onload = function() {
            console.log('OrbitControls loaded');

            // Load GLTFLoader
            const gltfLoaderScript = document.createElement('script');
            gltfLoaderScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/loaders/GLTFLoader.js';
            gltfLoaderScript.onload = function() {
                console.log('GLTFLoader loaded');
                setTimeout(initModelViewer, 100);
            };
            document.head.appendChild(gltfLoaderScript);
        };
        document.head.appendChild(orbitControlsScript);
    } else if (typeof THREE.GLTFLoader === 'undefined') {
        console.log('Loading GLTFLoader...');

        // Load GLTFLoader
        const gltfLoaderScript = document.createElement('script');
        gltfLoaderScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/loaders/GLTFLoader.js';
        gltfLoaderScript.onload = function() {
            console.log('GLTFLoader loaded');
            setTimeout(initModelViewer, 100);
        };
        document.head.appendChild(gltfLoaderScript);
    } else {
        // All libraries are already loaded
        console.log('All libraries already loaded');
        initModelViewer();
    }
}

// Run when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing model viewer');
    loadLibrariesAndInitViewer();
});
