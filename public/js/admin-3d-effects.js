// Efectos 3D para el panel de administración
document.addEventListener('DOMContentLoaded', () => {
    // Aplicar efecto 3D a las tarjetas de estadísticas
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(card => {
        // Efecto de elevación al pasar el mouse
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                y: -10,
                scale: 1.02,
                boxShadow: '0 15px 30px rgba(0, 0, 0, 0.1)',
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                y: 0,
                scale: 1,
                boxShadow: '0 5px 15px rgba(0, 0, 0, 0.05)',
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        // Efecto de rotación 3D al mover el mouse
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const xPercent = (x / rect.width - 0.5) * 2; // -1 a 1
            const yPercent = (y / rect.height - 0.5) * 2; // -1 a 1
            
            gsap.to(card, {
                rotationY: xPercent * 5, // Rotación en el eje Y (izquierda/derecha)
                rotationX: -yPercent * 5, // Rotación en el eje X (arriba/abajo)
                duration: 0.5,
                ease: 'power2.out'
            });
        });
    });

    // Aplicar efecto 3D a las tarjetas de acceso rápido
    const quickLinks = document.querySelectorAll('.quick-link');
    quickLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            gsap.to(link, {
                y: -5,
                scale: 1.05,
                boxShadow: '0 10px 20px rgba(0, 0, 0, 0.1)',
                duration: 0.3
            });
        });

        link.addEventListener('mouseleave', () => {
            gsap.to(link, {
                y: 0,
                scale: 1,
                boxShadow: '0 0 0 rgba(0, 0, 0, 0)',
                duration: 0.3
            });
        });

        // Efecto de rotación 3D al mover el mouse
        link.addEventListener('mousemove', (e) => {
            const rect = link.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const xPercent = (x / rect.width - 0.5) * 2;
            const yPercent = (y / rect.height - 0.5) * 2;
            
            gsap.to(link, {
                rotationY: xPercent * 3,
                rotationX: -yPercent * 3,
                duration: 0.5
            });
        });
    });

    // Animación de entrada para las tarjetas de estadísticas
    gsap.from('.stats-card', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out',
        delay: 0.2
    });

    // Animación de entrada para las gráficas
    gsap.from('.chart-card', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2,
        ease: 'power3.out',
        delay: 0.5
    });

    // Animación de entrada para la tabla de pedidos recientes
    gsap.from('.orders-card', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out',
        delay: 0.7
    });

    // Animación de entrada para los accesos rápidos
    gsap.from('.quick-link', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out',
        delay: 0.9
    });

    // Efecto de profundidad para el sidebar
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        gsap.to(sidebar, {
            boxShadow: '5px 0 25px rgba(0, 0, 0, 0.15)',
            duration: 1,
            delay: 0.5
        });
    }

    // Efecto de profundidad para la barra superior
    const topbar = document.querySelector('.topbar');
    if (topbar) {
        gsap.to(topbar, {
            boxShadow: '0 5px 15px rgba(0, 0, 0, 0.08)',
            duration: 1,
            delay: 0.5
        });
    }
});
