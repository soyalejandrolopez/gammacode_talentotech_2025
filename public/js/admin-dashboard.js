/**
 * Script para mejorar el dashboard de administración con efectos 3D avanzados
 */
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar contadores animados
    initCounters();
    
    // Inicializar efectos 3D para tarjetas
    init3DCardEffects();
    
    // Inicializar efectos de paralaje
    initParallaxEffects();
    
    // Inicializar animaciones de entrada
    initEntryAnimations();
    
    // Inicializar tooltips y popovers de Bootstrap
    initBootstrapComponents();
});

/**
 * Inicializa los contadores animados
 */
function initCounters() {
    const counterElements = document.querySelectorAll('.counter');
    
    counterElements.forEach(function(element) {
        const value = parseInt(element.textContent.replace(/,/g, ''));
        const countUp = new CountUp(element, 0, value, 0, 2.5, {
            useEasing: true,
            useGrouping: true,
            separator: ',',
            decimal: '.',
        });
        
        // Si está en el viewport, iniciar inmediatamente
        if (isElementInViewport(element)) {
            countUp.start();
        } else {
            // Si no, iniciar cuando entre en el viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        countUp.start();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(element);
        }
    });
}

/**
 * Inicializa efectos 3D para tarjetas
 */
function init3DCardEffects() {
    const cards = document.querySelectorAll('.stats-card, .chart-card, .quick-link');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -5;
            const rotateY = ((x - centerX) / centerX) * 5;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
            
            // Efecto de luz
            const shine = this.querySelector('.card-shine');
            if (shine) {
                const percentX = x / rect.width * 100;
                const percentY = y / rect.height * 100;
                shine.style.background = `radial-gradient(circle at ${percentX}% ${percentY}%, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 80%)`;
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.transition = 'transform 0.5s ease';
            
            const shine = this.querySelector('.card-shine');
            if (shine) {
                shine.style.background = 'none';
            }
        });
        
        // Añadir elemento para efecto de brillo
        if (!card.querySelector('.card-shine')) {
            const shine = document.createElement('div');
            shine.classList.add('card-shine');
            shine.style.position = 'absolute';
            shine.style.top = '0';
            shine.style.left = '0';
            shine.style.width = '100%';
            shine.style.height = '100%';
            shine.style.pointerEvents = 'none';
            shine.style.zIndex = '1';
            card.style.position = 'relative';
            card.style.overflow = 'hidden';
            card.appendChild(shine);
        }
    });
}

/**
 * Inicializa efectos de paralaje
 */
function initParallaxEffects() {
    // Paralaje para elementos del dashboard
    const parallaxElements = document.querySelectorAll('.stats-icon, .avatar-circle, .icon-circle');
    
    window.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        parallaxElements.forEach(element => {
            const depth = 20;
            const moveX = (mouseX - 0.5) * depth;
            const moveY = (mouseY - 0.5) * depth;
            
            element.style.transform = `translate3d(${moveX}px, ${moveY}px, 0) scale(1.05)`;
        });
    });
}

/**
 * Inicializa animaciones de entrada
 */
function initEntryAnimations() {
    // Animación de entrada para elementos del dashboard
    const animatedElements = document.querySelectorAll('.fade-in-up');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Inicializa componentes de Bootstrap
 */
function initBootstrapComponents() {
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inicializar popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

/**
 * Verifica si un elemento está en el viewport
 */
function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}
