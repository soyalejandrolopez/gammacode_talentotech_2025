@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('styles')
<link href="{{ asset('css/dashboard-modern.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Productos</h2>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus me-1"></i> Nuevo Producto
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card primary fade-in-up">
                <div class="stats-icon bg-primary-light text-primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stats-info">
                    <h3>Total de Productos</h3>
                    <p class="counter">{{ $products->total() }}</p>
                    <small class="text-muted">En el catálogo</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card success fade-in-up" style="animation-delay: 0.1s">
                <div class="stats-icon bg-success-light text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h3>Productos Activos</h3>
                    <p class="counter">{{ $products->where('is_active', true)->count() }}</p>
                    <small class="text-muted">Disponibles para compra</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card warning fade-in-up" style="animation-delay: 0.2s">
                <div class="stats-icon bg-warning-light text-warning">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stats-info">
                    <h3>Categorías</h3>
                    <p class="counter">{{ $categories->count() }}</p>
                    <small class="text-muted">Clasificaciones disponibles</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card info fade-in-up" style="animation-delay: 0.3s">
                <div class="stats-icon bg-info-light text-info">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stats-info">
                    <h3>Tiendas</h3>
                    <p class="counter">{{ $stores->count() }}</p>
                    <small class="text-muted">Con productos registrados</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Nombre, SKU, tienda..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="store_id" class="form-label">Tienda</label>
                    <select name="store_id" id="store_id" class="form-select">
                        <option value="">Todas las tiendas</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="is_active" class="form-label">Estado</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="all" {{ request('is_active') == 'all' ? 'selected' : '' }}>Todos</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products List Card -->
    <div class="card fade-in-up" style="animation-delay: 0.4s">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-list text-primary me-2"></i>
                <span class="fw-bold">Lista de Productos</span>
            </div>
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reiniciar
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Tienda</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" alt="{{ $product->name }}" class="table-img" width="50" height="50">
                                        @else
                                            <div class="bg-light text-center rounded" style="width: 50px; height: 50px; line-height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ Str::limit($product->slug, 30) }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-success-light text-success me-2" style="width: 25px; height: 25px; font-size: 12px;">
                                                <i class="fas fa-store"></i>
                                            </div>
                                            {{ $product->store->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-warning-light text-warning me-2" style="width: 25px; height: 25px; font-size: 12px;">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            {{ $product->category->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">${{ number_format($product->price, 2) }}</div>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success rounded-pill">Activo</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Ver en tienda">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-bs-toggle="tooltip" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="icon-circle bg-light mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-box text-muted" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No se encontraron productos</h4>
                    <p class="text-muted mb-4">No hay productos que coincidan con los criterios de búsqueda.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Crear Nuevo Producto
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar el producto <span id="productName" class="fw-bold"></span>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar contadores animados
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            const duration = 1000;
            const increment = target / (duration / 20);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };

            updateCounter();
        });

        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                delay: { show: 300, hide: 100 }
            });
        });

        // Set up delete modal
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-id');
                const productName = button.getAttribute('data-name');

                document.getElementById('productName').textContent = productName;
                document.getElementById('deleteForm').action = "{{ route('admin.products.destroy', '') }}/" + productId;
            });
        }

        // Efectos de hover en filas de tabla
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'translateX(5px)';
                row.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                row.style.backgroundColor = 'rgba(0, 0, 0, 0.01)';
            });

            row.addEventListener('mouseleave', () => {
                row.style.transform = 'translateX(0)';
                row.style.boxShadow = 'none';
                row.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection
