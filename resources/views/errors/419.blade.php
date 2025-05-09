@extends('layouts.app')

@section('title', 'Sesión Expirada')

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
    <h1 class="error-code">419</h1>
    <h2 class="error-title">Sesión Expirada</h2>
    <p class="error-message">Lo sentimos, tu sesión ha expirado. Por favor, actualiza la página e intenta nuevamente.</p>
    
    <div class="error-image-container">
        <img src="{{ asset('images/errors/419.svg') }}" alt="Sesión Expirada" class="error-image" onerror="this.src='https://cdn-icons-png.flaticon.com/512/6195/6195678.png'; this.style.width='200px';">
    </div>
    
    <div class="error-actions">
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fas fa-home me-2"></i> Ir al Inicio
        </a>
        <a href="javascript:window.location.reload()" class="btn-back">
            <i class="fas fa-sync-alt me-2"></i> Recargar Página
        </a>
    </div>
</div>
@endsection
