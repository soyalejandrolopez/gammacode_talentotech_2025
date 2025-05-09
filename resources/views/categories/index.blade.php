@extends('layouts.app')

@section('title', 'Categorías')

@section('styles')
<style>
    .category-card {
        position: relative;
        height: 250px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.5s;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
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
        <h1 class="page-title">Explora Nuestras Categorías</h1>
        <p class="page-description">Descubre una amplia variedad de productos frescos y naturales organizados por categorías para facilitar tu búsqueda.</p>
    </div>
    
    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-4 mb-4">
                <a href="{{ route('category', $category->slug) }}" class="text-decoration-none">
                    <div class="category-card">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        @else
                            <img src="https://via.placeholder.com/600x400?text={{ urlencode($category->name) }}" alt="{{ $category->name }}">
                        @endif
                        <div class="category-overlay">
                            <h3>{{ $category->name }}</h3>
                            <p>{{ $category->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                <h3 class="mb-3">No hay categorías disponibles</h3>
                <p class="text-muted">Pronto agregaremos nuevas categorías de productos.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
