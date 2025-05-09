@extends('layouts.app')

@section('content')
<div class="container py-5">
    @if(isset($category))
        <h1 class="mb-4">Productos de la categoría: {{ $category->name }}</h1>
    @elseif(isset($store))
        <h1 class="mb-4">Productos de: {{ $store->name }}</h1>
    @else
        <h1 class="mb-4">Todos los Productos</h1>
    @endif

    <div class="card">
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
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h3 class="h4 mb-3">No se encontraron productos</h3>
                    <p class="text-muted mb-0">No pudimos encontrar productos que coincidan con tus criterios.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
