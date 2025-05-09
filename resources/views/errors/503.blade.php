@extends('layouts.app')

@section('title', 'Servicio No Disponible')

@section('styles')
<style>
    .error-container {
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
    }
    
    .error-code {
        font-size: 8rem;
        font-weight: 900;
        color: #f8f9fa;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 0;
        line-height: 1;
        background: linear-gradient(to right, #FEE12B 33.33%, #2A52BE 33.33%, 66.66%, #CE1126 66.66%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .error-message {
        font-size: 1.2rem;
        color: #6c757d;
        max-width: 600px;
        margin: 0 auto 2rem;
    }
    
    .error-image {
        max-width: 100%;
        height: auto;
        margin-bottom: 2rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .btn-home {
        background-color: #2E7D32;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-home:hover {
        background-color: #1B5E20;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        color: white;
    }
    
    .btn-back {
        background-color: transparent;
        color: #2E7D32;
        border: 2px solid #2E7D32;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-left: 1rem;
    }
    
    .btn-back:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        color: #1B5E20;
    }
    
    .error-actions {
        margin-top: 2rem;
    }
    
    .maintenance-timer {
        margin-top: 2rem;
        font-size: 1.2rem;
        color: #333;
    }
    
    .timer-value {
        font-weight: 700;
        color: #2E7D32;
    }
    
    @media (max-width: 768px) {
        .error-code {
            font-size: 6rem;
        }
        
        .error-title {
            font-size: 2rem;
        }
        
        .error-message {
            font-size: 1rem;
        }
        
        .btn-home, .btn-back {
            display: block;
            margin: 1rem auto;
            width: 100%;
            max-width: 300px;
        }
    }
</style>
@endsection

@section('content')
<div class="container error-container">
    <h1 class="error-code">503</h1>
    <h2 class="error-title">Servicio No Disponible</h2>
    <p class="error-message">Lo sentimos, estamos realizando tareas de mantenimiento en este momento. Por favor, vuelve a intentarlo más tarde.</p>
    
    <div class="error-image-container">
        <img src="{{ asset('images/errors/503.svg') }}" alt="Servicio No Disponible" class="error-image" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4076/4076478.png'; this.style.width='200px';">
    </div>
    
    <div class="maintenance-timer">
        <p>Volveremos aproximadamente en <span class="timer-value" id="maintenance-countdown">--:--:--</span></p>
    </div>
    
    <div class="error-actions">
        <a href="javascript:window.location.reload()" class="btn-home">
            <i class="fas fa-sync-alt me-2"></i> Recargar Página
        </a>
        <a href="mailto:soporte@campesino.com" class="btn-back">
            <i class="fas fa-envelope me-2"></i> Contactar Soporte
        </a>
    </div>
</div>

@section('scripts')
<script>
    // Simulación de tiempo de mantenimiento (2 horas desde ahora)
    const endTime = new Date();
    endTime.setHours(endTime.getHours() + 2);
    
    function updateCountdown() {
        const now = new Date();
        const diff = endTime - now;
        
        if (diff <= 0) {
            document.getElementById('maintenance-countdown').textContent = "¡Ya terminamos! Recargando...";
            setTimeout(() => {
                window.location.reload();
            }, 3000);
            return;
        }
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        document.getElementById('maintenance-countdown').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Actualizar cada segundo
    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
@endsection
@endsection
