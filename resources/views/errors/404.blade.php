@extends('layouts.app')

@section('title', 'Página No Encontrada')

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
    
    .search-container {
        max-width: 500px;
        margin: 2rem auto;
        width: 100%;
    }
    
    .search-form {
        display: flex;
        position: relative;
    }
    
    .search-input {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
        outline: none;
    }
    
    .search-input:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
    }
    
    .search-button {
        position: absolute;
        right: 5px;
        top: 5px;
        background-color: #2E7D32;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .search-button:hover {
        background-color: #1B5E20;
    }
    
    .error-actions {
        margin-top: 2rem;
    }
    
    .error-links {
        margin-top: 2rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }
    
    .error-link {
        color: #2E7D32;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .error-link:hover {
        color: #1B5E20;
        text-decoration: underline;
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
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Página No Encontrada</h2>
    <p class="error-message">Lo sentimos, la página que estás buscando no existe o ha sido movida. Por favor, verifica la URL o utiliza la búsqueda para encontrar lo que necesitas.</p>
    
    <div class="error-image-container">
        <img src="{{ asset('images/errors/404.svg') }}" alt="Página No Encontrada" class="error-image" onerror="this.src='https://cdn-icons-png.flaticon.com/512/755/755014.png'; this.style.width='200px';">
    </div>
    
    <div class="search-container">
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Buscar productos..." class="search-input">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <div class="error-actions">
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fas fa-home me-2"></i> Ir al Inicio
        </a>
        <a href="javascript:history.back()" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Volver Atrás
        </a>
    </div>
    
    <div class="error-links">
        <a href="{{ route('products.index') }}" class="error-link">
            <i class="fas fa-shopping-basket me-1"></i> Productos
        </a>
        <a href="{{ route('categories.index') }}" class="error-link">
            <i class="fas fa-tags me-1"></i> Categorías
        </a>
        <a href="{{ route('stores.index') }}" class="error-link">
            <i class="fas fa-store me-1"></i> Tiendas
        </a>
    </div>
</div>
@endsection
