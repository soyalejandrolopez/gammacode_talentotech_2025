@extends('layouts.app')

@section('title', 'Tiendas')

@section('styles')
<style>
    .store-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
    }
    
    .store-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    .store-banner {
        height: 150px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .store-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        position: absolute;
        bottom: -40px;
        left: 20px;
    }
    
    .store-body {
        padding: 2.5rem 1.5rem 1.5rem;
    }
    
    .store-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .store-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 4.5rem;
    }
    
    .store-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .store-products {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .btn-view-store {
        background-color: #2E7D32;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-view-store:hover {
        background-color: #1B5E20;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        color: white;
    }
    
    .page-header {
        background-color: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
    }
    
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .page-description {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="page-header text-center mb-5">
        <h1 class="page-title">Nuestros Productores</h1>
        <p class="page-description">Descubre a los productores locales que ofrecen productos frescos, naturales y de temporada directamente del campo a tu mesa.</p>
    </div>
    
    <div class="row g-4">
        @forelse($stores as $store)
            <div class="col-md-6 col-lg-4">
                <div class="store-card">
                    <div class="store-banner" style="background-image: url('{{ $store->banner_url }}')">
                        <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="store-logo">
                    </div>
                    <div class="store-body">
                        <h3 class="store-title">{{ $store->name }}</h3>
                        <p class="store-description">{{ $store->description }}</p>
                        <div class="store-footer">
                            <div class="store-products">
                                <i class="fas fa-shopping-basket me-1"></i> {{ $store->products->count() }} productos
                            </div>
                            <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-view-store">
                                Ver Tienda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-store-slash fa-4x text-muted mb-3"></i>
                <h3 class="mb-3">No hay tiendas disponibles</h3>
                <p class="text-muted">Pronto tendremos nuevos productores en nuestra plataforma.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
