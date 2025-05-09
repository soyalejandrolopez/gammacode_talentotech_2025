// Initialize Lenis smooth scrolling
function initLenis() {
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        orientation: 'vertical',
        gestureOrientation: 'vertical',
        smoothWheel: true,
        wheelMultiplier: 1,
        smoothTouch: false,
        touchMultiplier: 2,
        infinite: false,
    });

    // Get scroll value for animations
    lenis.on('scroll', ({ scroll, limit, velocity, direction, progress }) => {
        // Make this value available to other scripts
        window.scrollProgress = progress;
        window.scrollValue = scroll;
        window.scrollVelocity = velocity;
    });

    // Connect with GSAP if available
    if (window.gsap && window.ScrollTrigger) {
        lenis.on('scroll', ScrollTrigger.update);
        
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        
        gsap.ticker.lagSmoothing(0);
    } else {
        // Use requestAnimationFrame if GSAP is not available
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    }

    // Make lenis available globally
    window.lenis = lenis;

    return lenis;
}

// Initialize Three.js for 3D effects
function init3DEffects() {
    if (!window.THREE) {
        console.warn('Three.js not loaded');
        return;
    }

    // Create a scene
    const scene = new THREE.Scene();
    
    // Create a camera
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 5;
    
    // Create a renderer with transparent background
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
        container.style.position = 'absolute';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '100%';
        container.style.zIndex = '1';
        container.style.pointerEvents = 'none';
        container.appendChild(renderer.domElement);
        heroSection.prepend(container);
    }
    
    // Create rural-themed 3D objects
    const geometry = new THREE.TorusKnotGeometry(1, 0.3, 100, 16);
    const material = new THREE.MeshNormalMaterial();
    const torusKnot = new THREE.Mesh(geometry, material);
    scene.add(torusKnot);
    
    // Add floating particles (like seeds or pollen)
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCount = 500;
    const posArray = new Float32Array(particlesCount * 3);
    
    for (let i = 0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 10;
    }
    
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    const particlesMaterial = new THREE.PointsMaterial({
        size: 0.02,
        color: 0xffffff,
        transparent: true,
        opacity: 0.8
    });
    
    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);
    
    // Animation loop
    function animate() {
        requestAnimationFrame(animate);
        
        // Rotate the torus knot
        torusKnot.rotation.x += 0.01;
        torusKnot.rotation.y += 0.01;
        
        // Rotate particles
        particlesMesh.rotation.y += 0.001;
        
        // Update based on scroll position if Lenis is active
        if (window.scrollValue !== undefined) {
            // Move objects based on scroll
            torusKnot.position.y = -window.scrollValue * 0.001;
            particlesMesh.position.y = -window.scrollValue * 0.0005;
            
            // Scale based on scroll progress
            const scale = 1 - window.scrollProgress * 0.5;
            torusKnot.scale.set(scale, scale, scale);
        }
        
        renderer.render(scene, camera);
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
    
    // Start animation loop
    animate();
}

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Lenis for smooth scrolling
    initLenis();
    
    // Initialize 3D effects if Three.js is loaded
    if (window.THREE) {
        init3DEffects();
    }
});
