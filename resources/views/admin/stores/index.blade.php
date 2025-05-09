@extends('layouts.admin')

@section('title', 'Gestión de Tiendas')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Tiendas</h2>
        <div>
            <a href="{{ route('admin.stores.create') }}" class="btn btn-sm btn-primary me-2">
                <i class="fas fa-plus me-1"></i> Nueva Tienda
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
            </a>
        </div>
    </div>

    <!-- Stores List Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Tiendas</h5>
            <div>
                <form action="{{ route('admin.stores.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar tiendas..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($stores->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Propietario</th>
                                <th>Productos</th>
                                <th>Estado</th>
                                <th>Fecha de Creación</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td>{{ $store->id }}</td>
                                    <td>
                                        <div>{{ $store->name }}</div>
                                        <small class="text-muted">{{ $store->slug }}</small>
                                    </td>
                                    <td>{{ $store->user->name }}</td>
                                    <td>{{ $store->products_count ?? 0 }}</td>
                                    <td>
                                        @if($store->is_active)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-danger">Inactiva</span>
                                        @endif
                                    </td>
                                    <td>{{ $store->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.stores.show', $store) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $store->id }}" data-name="{{ $store->name }}">
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
                    {{ $stores->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-store text-muted mb-3" style="font-size: 2rem;"></i>
                    <p class="text-muted">No se encontraron tiendas.</p>
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
                    <p>¿Estás seguro de que deseas eliminar la tienda <span id="storeName" class="fw-bold"></span>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer y eliminará todos los productos asociados a esta tienda.</p>
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
        // Set up delete modal
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const storeId = button.getAttribute('data-id');
                const storeName = button.getAttribute('data-name');

                document.getElementById('storeName').textContent = storeName;
                document.getElementById('deleteForm').action = "{{ route('admin.stores.destroy', '') }}/" + storeId;
            });
        }
    });
</script>
@endsection
