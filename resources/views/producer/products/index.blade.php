@extends('layouts.producer')

@section('title', 'Administrar Productos')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-box text-primary"></i> Mis Productos
                    </h5>
                    <a href="{{ route('producer.products.create') }}" class="btn btn-modern btn-modern-primary">
                        <i class="fas fa-plus me-2"></i> Añadir Nuevo Producto
                    </a>
                </div>
                <div class="modern-card-body">

                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3" style="width: 50px; height: 50px;">
                                                        <img class="rounded w-100 h-100 object-fit-cover" src="{{ $product->first_image ? asset('storage/' . $product->first_image) : 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $product->category ? $product->category->name : 'Sin categoría' }}
                                            </td>
                                            <td>
                                                <strong class="text-primary">${{ number_format($product->price, 2) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $product->stock }}</span>
                                            </td>
                                            <td>
                                                @if($product->is_active)
                                                    <span class="modern-badge badge-success">Activo</span>
                                                @else
                                                    <span class="modern-badge badge-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('products.show', $product) }}" class="action-icon" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('producer.products.edit', $product) }}" class="action-icon action-icon-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('producer.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-icon action-icon-danger" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-products.svg') }}" alt="No hay productos" class="img-fluid mb-3" style="max-width: 150px;">
                            <h5>No se encontraron productos</h5>
                            <p class="text-muted mb-4">Aún no has añadido ningún producto a tu tienda.</p>
                            <a href="{{ route('producer.products.create') }}" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-plus me-2"></i> Añadir Mi Primer Producto
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
