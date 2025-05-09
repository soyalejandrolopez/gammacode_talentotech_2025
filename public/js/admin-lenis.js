// Inicialización de Lenis para scroll suave en el panel de administración
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar Lenis solo si está disponible
    if (typeof Lenis !== 'undefined') {
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

        // Obtener valores de scroll para animaciones
        lenis.on('scroll', ({ scroll, limit, velocity, direction, progress }) => {
            // Hacer estos valores disponibles para otros scripts
            window.scrollProgress = progress;
            window.scrollValue = scroll;
            window.scrollVelocity = velocity;
        });

        // Conectar con GSAP si está disponible
        if (window.gsap && window.ScrollTrigger) {
            lenis.on('scroll', ScrollTrigger.update);
            
            gsap.ticker.add((time) => {
                lenis.raf(time * 1000);
            });
            
            gsap.ticker.lagSmoothing(0);
        } else {
            // Usar requestAnimationFrame si GSAP no está disponible
            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
        }

        // Hacer lenis disponible globalmente
        window.lenis = lenis;
    }
});
