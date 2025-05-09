/**
 * Script para el Dashboard 3D de Productor - AgroGastro
 * Versión 2.0
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar efectos 3D
    initializeParallaxEffect();

    // Inicializar gráficas
    initializeCharts();

    // Inicializar animaciones de entrada
    initializeAnimations();

    // Inicializar efectos de hover 3D
    initialize3DHoverEffects();
});

/**
 * Inicializa el efecto parallax para las tarjetas
 */
function initializeParallaxEffect() {
    const cards = document.querySelectorAll('.modern-card, .stat-card');

    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const deltaX = (x - centerX) / centerX;
            const deltaY = (y - centerY) / centerY;

            // Limitar la rotación a un máximo de 5 grados
            const rotateX = deltaY * -5;
            const rotateY = deltaX * 5;

            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            this.style.boxShadow = `0 ${10 + Math.abs(rotateY)}px ${20 + Math.abs(rotateX) * 2}px rgba(0, 0, 0, 0.1)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
            this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.1)';
        });
    });
}

/**
 * Inicializa las animaciones de entrada
 */
function initializeAnimations() {
    const elements = document.querySelectorAll('.fade-in-up');

    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.animationDelay = `${0.1 * index}s`;

        setTimeout(() => {
            el.style.opacity = '1';
        }, 100);
    });
}

/**
 * Inicializa efectos de hover 3D para botones y elementos interactivos
 */
function initialize3DHoverEffects() {
    const buttons = document.querySelectorAll('.btn-modern, .action-icon');

    buttons.forEach(button => {
        button.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const deltaX = (x - centerX) / centerX;
            const deltaY = (y - centerY) / centerY;

            this.style.transform = `translateY(-3px) scale(1.02)`;
            this.style.boxShadow = '0 7px 14px rgba(0, 0, 0, 0.1)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });
    });
}

/**
 * Inicializa las gráficas del dashboard
 */
function initializeCharts() {
    // Verificar si existen los elementos para las gráficas
    if (document.getElementById('salesChart')) {
        initializeSalesChart();
    }

    if (document.getElementById('productsChart')) {
        initializeProductsChart();
    }

    if (document.getElementById('ordersStatusChart')) {
        initializeOrdersStatusChart();
    }

    if (document.getElementById('customerActivityChart')) {
        initializeCustomerActivityChart();
    }
}

/**
 * Inicializa la gráfica de ventas
 */
function initializeSalesChart() {
    const ctx = document.getElementById('salesChart').getContext('2d');

    // Colores de la bandera de Colombia
    const gradientYellow = ctx.createLinearGradient(0, 0, 0, 400);
    gradientYellow.addColorStop(0, 'rgba(255, 193, 7, 0.8)');
    gradientYellow.addColorStop(1, 'rgba(255, 193, 7, 0.2)');

    const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
    gradientBlue.addColorStop(0, 'rgba(13, 71, 161, 0.8)');
    gradientBlue.addColorStop(1, 'rgba(13, 71, 161, 0.2)');

    const gradientRed = ctx.createLinearGradient(0, 0, 0, 400);
    gradientRed.addColorStop(0, 'rgba(211, 47, 47, 0.8)');
    gradientRed.addColorStop(1, 'rgba(211, 47, 47, 0.2)');

    // Configuración de la gráfica
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 15,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                padding: 10,
                cornerRadius: 6,
                caretSize: 6,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        return `Ventas: $${context.parsed.y.toLocaleString('es-CO', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        })}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString('es-CO', {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };

    // Crear gráfica con datos de carga
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Cargando...'],
            datasets: [{
                label: 'Cargando datos...',
                data: [0],
                backgroundColor: gradientYellow,
                borderColor: '#FFC107',
                borderWidth: 3
            }]
        },
        options: chartOptions
    });

    // Cargar datos reales desde la API
    fetch('/producer/charts/sales?period=monthly')
        .then(response => response.json())
        .then(data => {
            // Actualizar la gráfica con datos reales
            salesChart.data = data;
            salesChart.options = chartOptions;
            salesChart.update();

            // Configurar botones de período
            setupPeriodButtons(salesChart);
        })
        .catch(error => {
            console.error('Error al cargar datos de ventas:', error);
            // Mostrar mensaje de error en la gráfica
            salesChart.data = {
                labels: ['Error al cargar datos'],
                datasets: [{
                    label: 'Error',
                    data: [0],
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: '#FF0000'
                }]
            };
            salesChart.update();
        });
}

/**
 * Configura los botones de período para la gráfica de ventas
 */
function setupPeriodButtons(chart) {
    const periodButtons = document.querySelectorAll('.period-selector .btn');

    if (periodButtons.length > 0) {
        // Almacenar el período actual para evitar recargas innecesarias
        let currentPeriod = 'monthly';

        periodButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el período del atributo data-period
                const period = this.getAttribute('data-period') || 'monthly';

                // Solo actualizar si el período ha cambiado
                if (period !== currentPeriod) {
                    // Remover clase activa de todos los botones
                    periodButtons.forEach(btn => btn.classList.remove('active'));

                    // Añadir clase activa al botón clickeado
                    this.classList.add('active');

                    // Actualizar el período actual
                    currentPeriod = period;

                    // Actualizar la gráfica con el nuevo período
                    updateSalesChart(chart, period);
                }
            });
        });
    }
}

/**
 * Actualiza la gráfica de ventas con datos del período seleccionado
 */
function updateSalesChart(chart, period) {
    // Guardar la configuración original
    const originalOptions = { ...chart.options };

    // Mostrar estado de carga
    chart.data = {
        labels: ['Cargando...'],
        datasets: [{
            label: 'Cargando datos...',
            data: [0],
            backgroundColor: 'rgba(200, 200, 200, 0.2)',
            borderColor: '#cccccc'
        }]
    };
    chart.update();

    // Cargar datos del período seleccionado
    fetch(`/producer/charts/sales?period=${period}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Verificar si los datos son válidos
            if (!data || !data.labels || !data.datasets || data.datasets.length === 0) {
                throw new Error('Formato de datos inválido');
            }

            // Actualizar la gráfica con los nuevos datos
            chart.data = data;

            // Restaurar opciones originales
            chart.options = originalOptions;

            // Actualizar la gráfica
            chart.update();
        })
        .catch(error => {
            console.error(`Error al cargar datos de ventas (${period}):`, error);

            // Determinar mensaje de error apropiado
            let errorMessage = 'Error al cargar datos';
            if (error.message.includes('HTTP')) {
                errorMessage = 'Error de conexión al servidor';
            } else if (error.message.includes('inválido')) {
                errorMessage = 'Datos no disponibles';
            }

            // Mostrar mensaje de error
            chart.data = {
                labels: [errorMessage],
                datasets: [{
                    label: 'Error',
                    data: [0],
                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                    borderColor: '#FF0000'
                }]
            };

            // Configurar opciones para mensaje de error
            chart.options = {
                ...originalOptions,
                plugins: {
                    ...originalOptions.plugins,
                    tooltip: {
                        callbacks: {
                            label: function() {
                                return 'Intente nuevamente más tarde';
                            }
                        }
                    }
                }
            };

            chart.update();
        });
}

/**
 * Inicializa la gráfica de estado de pedidos
 */
function initializeOrdersStatusChart() {
    const ctx = document.getElementById('ordersStatusChart').getContext('2d');

    // Configuración de la gráfica
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                        const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    };

    // Crear gráfica con datos de carga
    const ordersStatusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Cargando...'],
            datasets: [{
                data: [1],
                backgroundColor: ['#cccccc'],
                borderColor: '#FFF',
                borderWidth: 2
            }]
        },
        options: chartOptions
    });

    // Cargar datos reales desde la API
    fetch('/producer/charts/order-status')
        .then(response => response.json())
        .then(data => {
            // Actualizar la gráfica con datos reales
            ordersStatusChart.data = data;
            ordersStatusChart.update();

            // Añadir animación 3D al hover
            add3DEffectToDoughnut(ordersStatusChart);
        })
        .catch(error => {
            console.error('Error al cargar datos de estado de pedidos:', error);
            // Mostrar mensaje de error
            ordersStatusChart.data = {
                labels: ['Error al cargar datos'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['rgba(255, 0, 0, 0.2)'],
                    borderColor: '#FF0000'
                }]
            };
            ordersStatusChart.update();
        });
}

/**
 * Añade efecto 3D al hover en gráficas de tipo doughnut
 */
function add3DEffectToDoughnut(chart) {
    const canvas = chart.canvas;

    canvas.addEventListener('mousemove', function(e) {
        const activePoints = chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);

        if (activePoints.length > 0) {
            const firstPoint = activePoints[0];
            const index = firstPoint.index;

            // Resetear todos los segmentos
            chart.data.datasets[0].offset = chart.data.datasets[0].data.map(() => 0);

            // Aplicar offset al segmento activo para efecto 3D
            chart.data.datasets[0].offset[index] = 10;

            chart.update();
        } else {
            // Resetear todos los offsets cuando no hay hover
            if (chart.data.datasets[0].offset && chart.data.datasets[0].offset.some(o => o !== 0)) {
                chart.data.datasets[0].offset = chart.data.datasets[0].data.map(() => 0);
                chart.update();
            }
        }
    });

    canvas.addEventListener('mouseleave', function() {
        // Resetear todos los offsets al salir del canvas
        if (chart.data.datasets[0].offset && chart.data.datasets[0].offset.some(o => o !== 0)) {
            chart.data.datasets[0].offset = chart.data.datasets[0].data.map(() => 0);
            chart.update();
        }
    });
}

/**
 * Inicializa la gráfica de productos por categoría
 */
function initializeProductsChart() {
    const ctx = document.getElementById('productsChart').getContext('2d');

    // Configuración de la gráfica
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',  // Barras horizontales para mejor visualización
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label}: ${context.parsed.x} productos`;
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    precision: 0  // Solo mostrar números enteros
                }
            },
            y: {
                grid: {
                    display: false
                }
            }
        }
    };

    // Crear gráfica con datos de carga
    const productsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Cargando...'],
            datasets: [{
                label: 'Cargando datos...',
                data: [0],
                backgroundColor: ['#cccccc'],
                borderColor: '#FFF',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: chartOptions
    });

    // Cargar datos reales desde la API
    fetch('/producer/charts/products-by-category')
        .then(response => response.json())
        .then(data => {
            // Actualizar la gráfica con datos reales
            productsChart.data = data;

            // Añadir efecto 3D a las barras
            add3DEffectToBars(productsChart);

            productsChart.update();
        })
        .catch(error => {
            console.error('Error al cargar datos de productos por categoría:', error);
            // Mostrar mensaje de error
            productsChart.data = {
                labels: ['Error al cargar datos'],
                datasets: [{
                    label: 'Error',
                    data: [0],
                    backgroundColor: ['rgba(255, 0, 0, 0.2)'],
                    borderColor: '#FF0000'
                }]
            };
            productsChart.update();
        });
}

/**
 * Añade efecto 3D a las barras de la gráfica
 */
function add3DEffectToBars(chart) {
    // Añadir sombras para efecto 3D
    chart.options.elements = {
        bar: {
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
            // Añadir sombra para efecto 3D
            shadowOffsetX: 3,
            shadowOffsetY: 3,
            shadowBlur: 10,
            shadowColor: 'rgba(0, 0, 0, 0.2)'
        }
    };

    // Añadir evento de hover para efecto 3D
    const canvas = chart.canvas;

    canvas.addEventListener('mousemove', function(e) {
        const activePoints = chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, false);

        if (activePoints.length > 0) {
            const firstPoint = activePoints[0];
            const index = firstPoint.index;

            // Guardar los datos originales si no se han guardado aún
            if (!chart._originalBarThickness) {
                chart._originalBarThickness = chart.data.datasets[0].barThickness;
            }

            // Resetear todas las barras
            chart.data.datasets[0].barThickness = chart._originalBarThickness;

            // Aumentar el grosor de la barra activa para efecto 3D
            chart.data.datasets[0].barThickness = chart._originalBarThickness * 1.1;

            chart.update();
        } else {
            // Resetear todas las barras cuando no hay hover
            if (chart._originalBarThickness) {
                chart.data.datasets[0].barThickness = chart._originalBarThickness;
                chart.update();
            }
        }
    });

    canvas.addEventListener('mouseleave', function() {
        // Resetear todas las barras al salir del canvas
        if (chart._originalBarThickness) {
            chart.data.datasets[0].barThickness = chart._originalBarThickness;
            chart.update();
        }
    });
}

/**
 * Inicializa la gráfica de actividad de clientes
 */
function initializeCustomerActivityChart() {
    const ctx = document.getElementById('customerActivityChart').getContext('2d');

    // Gradiente para el área
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(13, 71, 161, 0.6)');
    gradient.addColorStop(1, 'rgba(13, 71, 161, 0.1)');

    // Días de la semana en español
    const diasSemana = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];

    // Datos de ejemplo - Reemplazar con datos reales
    const customerActivityChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: diasSemana,
            datasets: [{
                label: 'Actividad de Clientes',
                data: [5, 10, 15, 12, 20, 18, 8],
                backgroundColor: gradient,
                borderColor: '#0D47A1',
                borderWidth: 3,
                pointBackgroundColor: '#0D47A1',
                pointBorderColor: '#FFF',
                pointBorderWidth: 2,
                pointRadius: 6,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
