// Create a 3D rural scene with Three.js
document.addEventListener('DOMContentLoaded', () => {
    if (!window.THREE) {
        console.warn('Three.js not loaded');
        return;
    }

    // Scene setup
    const scene = new THREE.Scene();
    
    // Camera setup
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;
    
    // Renderer setup
    const renderer = new THREE.WebGLRenderer({ 
        antialias: true,
        alpha: true 
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    
    // Add renderer to the hero section
    const heroSection = document.getElementById('hero');
    if (heroSection) {
        const container = document.createElement('div');
        container.classList.add('three-container');
        container.appendChild(renderer.domElement);
        heroSection.prepend(container);
    }

    // Create rural-themed 3D objects
    
    // 1. Create a stylized wheat field
    const createWheatField = () => {
        const wheatGroup = new THREE.Group();
        
        // Create multiple wheat stalks
        for (let i = 0; i < 100; i++) {
            const height = 0.5 + Math.random() * 0.3;
            const thickness = 0.01 + Math.random() * 0.01;
            
            // Stalk
            const stalkGeometry = new THREE.CylinderGeometry(thickness, thickness, height, 4);
            const stalkMaterial = new THREE.MeshBasicMaterial({ 
                color: 0xd4af37,
                transparent: true,
                opacity: 0.7
            });
            const stalk = new THREE.Mesh(stalkGeometry, stalkMaterial);
            
            // Position randomly in a field pattern
            stalk.position.x = (Math.random() - 0.5) * 10;
            stalk.position.y = (Math.random() - 0.5) * 3 - 1; // Lower in the scene
            stalk.position.z = (Math.random() - 0.5) * 10;
            
            // Random rotation for natural look
            stalk.rotation.x = Math.random() * 0.2;
            stalk.rotation.z = Math.random() * 0.2;
            
            wheatGroup.add(stalk);
        }
        
        return wheatGroup;
    };
    
    // 2. Create floating seeds/pollen
    const createFloatingParticles = () => {
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 300;
        const posArray = new Float32Array(particlesCount * 3);
        
        for (let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 10;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.02,
            color: 0xffffff,
            transparent: true,
            opacity: 0.6
        });
        
        return new THREE.Points(particlesGeometry, particlesMaterial);
    };
    
    // 3. Create a stylized sun
    const createSun = () => {
        const sunGeometry = new THREE.SphereGeometry(1, 32, 32);
        const sunMaterial = new THREE.MeshBasicMaterial({
            color: 0xffcc00,
            transparent: true,
            opacity: 0.8
        });
        const sun = new THREE.Mesh(sunGeometry, sunMaterial);
        
        // Position the sun in the upper corner
        sun.position.set(5, 3, -10);
        
        return sun;
    };
    
    // 4. Create stylized clouds
    const createClouds = () => {
        const cloudGroup = new THREE.Group();
        
        for (let i = 0; i < 5; i++) {
            const cloudGeometry = new THREE.SphereGeometry(0.5 + Math.random() * 0.5, 8, 8);
            const cloudMaterial = new THREE.MeshBasicMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.4 + Math.random() * 0.3
            });
            const cloud = new THREE.Mesh(cloudGeometry, cloudMaterial);
            
            // Position randomly in the sky
            cloud.position.x = (Math.random() - 0.5) * 15;
            cloud.position.y = 2 + Math.random() * 2;
            cloud.position.z = -5 - Math.random() * 5;
            
            // Scale randomly for variety
            const scale = 0.8 + Math.random() * 1.2;
            cloud.scale.set(scale, scale * 0.6, scale);
            
            cloudGroup.add(cloud);
        }
        
        return cloudGroup;
    };
    
    // Add all elements to the scene
    const wheatField = createWheatField();
    const floatingParticles = createFloatingParticles();
    const sun = createSun();
    const clouds = createClouds();
    
    scene.add(wheatField);
    scene.add(floatingParticles);
    scene.add(sun);
    scene.add(clouds);
    
    // Animation loop
    function animate() {
        requestAnimationFrame(animate);
        
        // Rotate wheat field gently
        if (wheatField) {
            wheatField.rotation.y += 0.001;
        }
        
        // Move floating particles
        if (floatingParticles) {
            floatingParticles.rotation.y += 0.0005;
            floatingParticles.position.y = Math.sin(Date.now() * 0.0005) * 0.2;
        }
        
        // Pulse the sun
        if (sun) {
            const pulseFactor = 1 + Math.sin(Date.now() * 0.001) * 0.05;
            sun.scale.set(pulseFactor, pulseFactor, pulseFactor);
        }
        
        // Move clouds slowly
        if (clouds) {
            clouds.position.x += 0.001;
            
            // Reset position when clouds move too far
            if (clouds.position.x > 10) {
                clouds.position.x = -10;
            }
        }
        
        // Update based on scroll position if Lenis is active
        if (window.scrollValue !== undefined) {
            // Move objects based on scroll
            scene.rotation.x = window.scrollValue * 0.0005;
            scene.position.y = -window.scrollValue * 0.002;
            
            // Fade out based on scroll progress
            const opacity = Math.max(0, 1 - window.scrollProgress * 2);
            
            // Apply opacity to all materials
            scene.traverse((object) => {
                if (object.material && object.material.opacity !== undefined) {
                    object.material.opacity = object.material.userData.baseOpacity * opacity || opacity;
                }
            });
        }
        
        renderer.render(scene, camera);
    }
    
    // Store original opacity values
    scene.traverse((object) => {
        if (object.material && object.material.opacity !== undefined) {
            object.material.userData.baseOpacity = object.material.opacity;
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
    
    // Start animation loop
    animate();
});
