@extends('layouts.customer')

@section('title', 'Productos')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-shopping-basket" style="color: var(--blue);"></i>
                        @if(isset($category))
                            Productos de la categoría: {{ $category->name }}
                        @elseif(isset($store))
                            Productos de: {{ $store->name }}
                        @else
                            Explorar Productos
                        @endif
                    </h5>
                    <div>
                        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar productos..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Categorías</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item border-0 px-0">
                                            <a href="{{ route('products.index') }}" class="text-decoration-none {{ !request('category') ? 'fw-bold text-primary' : 'text-dark' }}">
                                                Todas las categorías
                                            </a>
                                        </li>
                                        @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                            <li class="list-group-item border-0 px-0">
                                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-decoration-none {{ request('category') == $category->slug ? 'fw-bold text-primary' : 'text-dark' }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                @forelse($products as $product)
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 border-0 shadow-sm product-card" style="border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                                            <div style="height: 180px; overflow: hidden;">
                                                @if($product->first_image)
                                                    <img src="{{ asset('storage/' . $product->first_image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                                                        <i class="fas fa-image fa-3x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title mb-1" style="font-size: 1rem;">{{ $product->name }}</h5>
                                                <p class="text-muted small mb-2">{{ $product->store->name }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-bold text-primary">${{ number_format($product->price, 0, ',', '.') }}</span>
                                                    <div class="d-flex">
                                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary me-1" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="btn btn-sm btn-primary" title="Añadir al carrito">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <img src="{{ asset('images/empty-products.svg') }}" alt="No hay productos" class="img-fluid mb-3" style="max-width: 150px;">
                                            <h5>No se encontraron productos</h5>
                                            <p class="text-muted mb-0">Intenta con otra búsqueda o categoría</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para las tarjetas de productos
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 15px 30px rgba(0,0,0,0.1)';
                const img = this.querySelector('.card-img-top');
                if (img) img.style.transform = 'scale(1.1)';
            });

            card.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
                const img = this.querySelector('.card-img-top');
                if (img) img.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endsection
