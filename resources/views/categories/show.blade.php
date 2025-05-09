@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    @if($category->image)
                        <div class="me-4">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="rounded-circle" style="width: 64px; height: 64px; object-fit: cover;">
                        </div>
                    @else
                        <div class="me-4 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-folder fa-2x text-muted"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="h3 mb-1">{{ $category->name }}</h1>
                        @if($category->description)
                            <p class="text-muted mb-0">{{ $category->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="h5 mb-0">Productos en {{ $category->name }}</h3>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                            @foreach($products as $product)
                                <div class="col">
                                    <div class="card h-100 product-card">
                                        <div class="product-img">
                                            @if($product->first_image)
                                                <img src="{{ asset('storage/' . $product->first_image) }}" class="card-img-top" alt="{{ $product->name }}">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                    <i class="fas fa-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="fw-bold text-primary">${{ number_format($product->price, 0, ',', '.') }}</span>
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">Ver detalles</a>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <small class="text-muted">
                                                <a href="{{ route('stores.show', $product->store->slug) }}" class="text-decoration-none">
                                                    <i class="fas fa-store me-1"></i> {{ $product->store->name }}
                                                </a>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h4 class="mb-2">No hay productos</h4>
                            <p class="text-muted">No hay productos disponibles en esta categoría.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
