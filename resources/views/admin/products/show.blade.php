@extends('layouts.admin')

@section('title', 'Detalles del Producto')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">{{ $product->name }}</h2>
        <div>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Productos
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Imágenes del Producto</h5>
                </div>
                <div class="card-body">
                    @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0 && isset($product->images[0]))
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($product->images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Anterior</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Siguiente</span>
                                </button>
                            @endif
                        </div>

                        <div class="row mt-3">
                            @foreach($product->images as $index => $image)
                                <div class="col-3 mb-3">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">No hay imágenes disponibles para este producto.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información del Producto</h5>
                    <div>
                        @if($product->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif

                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark ms-1">Destacado</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Tienda</h6>
                        <p class="mb-0">
                            <a href="{{ route('admin.stores.show', $product->store) }}">
                                {{ $product->store->name }}
                            </a>
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Categoría</h6>
                        <p class="mb-0">{{ $product->category->name }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">SKU</h6>
                        <p class="mb-0">{{ $product->sku ?? 'No especificado' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Precio</h6>
                        <h4 class="text-primary">${{ number_format($product->price, 2) }}</h4>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Stock</h6>
                        <p class="mb-0">
                            @if($product->stock > 10)
                                <span class="text-success">{{ $product->stock }} unidades</span>
                            @elseif($product->stock > 0)
                                <span class="text-warning">{{ $product->stock }} unidades (Bajo)</span>
                            @else
                                <span class="text-danger">Sin stock</span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Descripción</h6>
                        <p class="mb-0">{{ $product->description ?? 'Sin descripción' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Fecha de Creación</h6>
                        <p class="mb-0">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Última Actualización</h6>
                        <p class="mb-0">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Ver en Tienda
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash me-1"></i> Eliminar Producto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirm delete
        const deleteForm = document.querySelector('.delete-form');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        }
    });
</script>
@endsection
