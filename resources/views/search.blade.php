@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Resultados de búsqueda: "{{ $query }}"</h1>

    <div class="card">
        <div class="card-body">
            @if($products->count() > 0)
                <p class="lead mb-4">Se encontraron {{ $products->total() }} productos que coinciden con tu búsqueda.</p>

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
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">
                                            <a href="{{ route('stores.show', $product->store->slug) }}" class="text-decoration-none">
                                                <i class="fas fa-store me-1"></i> {{ $product->store->name }}
                                            </a>
                                        </small>
                                        <small class="text-muted">
                                            <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none">
                                                <i class="fas fa-tag me-1"></i> {{ $product->category->name }}
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(['query' => $query])->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h3 class="h4 mb-3">No se encontraron resultados</h3>
                    <p class="text-muted mb-4">No pudimos encontrar productos que coincidan con "{{ $query }}".</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        Ver todos los productos
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
