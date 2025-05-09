@extends('layouts.admin')

@section('title', 'Detalles del Usuario')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Detalles del Usuario</h2>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Volver a Usuarios
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit me-1"></i> Editar Usuario
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Information -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="avatar-initials">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h4 class="mb-0">{{ $user->name }}</h4>
                        <p class="text-muted">
                            @foreach($user->roles as $role)
                                @if($role->slug == 'admin')
                                    <span class="badge bg-danger">{{ $role->name }}</span>
                                @elseif($role->slug == 'producer')
                                    <span class="badge bg-success">{{ $role->name }}</span>
                                @elseif($role->slug == 'customer')
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $role->name }}</span>
                                @endif
                            @endforeach
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Email</h6>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Teléfono</h6>
                        <p class="mb-0">{{ $user->phone ?? 'No especificado' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Dirección</h6>
                        <p class="mb-0">{{ $user->address ?? 'No especificada' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Fecha de Registro</h6>
                        <p class="mb-0">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div>
                        <h6 class="text-muted mb-1">Última Actualización</h6>
                        <p class="mb-0">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="col-lg-6">
            @if($user->hasRole('producer') && $user->store)
                <!-- Store Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Información de la Tienda</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Nombre de la Tienda</h6>
                            <p class="mb-0">{{ $user->store->name }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Descripción</h6>
                            <p class="mb-0">{{ $user->store->description ?? 'Sin descripción' }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Estado</h6>
                            @if($user->store->is_active)
                                <span class="badge bg-success">Activa</span>
                            @else
                                <span class="badge bg-danger">Inactiva</span>
                            @endif
                        </div>

                        <div>
                            <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-store me-1"></i> Ver Detalles de la Tienda
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if($user->hasRole('customer'))
                <!-- Orders Information -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pedidos Recientes</h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                            Ver Todos <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if($user->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pedido #</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->orders->take(5) as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    @if($order->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                                    @elseif($order->status == 'processing')
                                                        <span class="badge bg-info">Procesando</span>
                                                    @elseif($order->status == 'completed')
                                                        <span class="badge bg-success">Completado</span>
                                                    @elseif($order->status == 'cancelled')
                                                        <span class="badge bg-danger">Cancelado</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="text-muted">Este usuario no ha realizado pedidos.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Editar Usuario
                        </a>
                        <a href="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-danger delete-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                            <i class="fas fa-trash me-1"></i> Borrar Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- No modal needed anymore -->
@endsection

@section('styles')
<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: #2E7D32;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .avatar-initials {
        color: white;
        font-size: 48px;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar el enlace de eliminación
        const deleteLink = document.querySelector('.delete-btn');
        if (deleteLink) {
            deleteLink.addEventListener('click', function(e) {
                e.preventDefault(); // Prevenir la navegación normal

                const userId = this.getAttribute('data-id');
                const userName = this.getAttribute('data-name');
                const deleteUrl = this.getAttribute('href');

                console.log('URL de eliminación:', deleteUrl);

                // Mostrar mensaje de confirmación con SweetAlert2
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `¿Realmente deseas borrar al usuario <strong>${userName}</strong>?<br><span class="text-danger">Esta acción no se puede deshacer.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar mensaje de procesamiento
                        const loadingMessage = document.createElement('div');
                        loadingMessage.className = 'alert alert-info fixed-top m-3';
                        loadingMessage.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Procesando...';
                        document.body.appendChild(loadingMessage);

                        // Crear un formulario dinámico para enviar la solicitud DELETE
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;
                        form.style.display = 'none';

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);

                        // Enviar el formulario
                        form.submit();
                    }
                });
            });
        }

        // Mostrar mensajes de éxito o error con SweetAlert2
        @if(session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4CAF50',
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: '¡Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#EF5350',
                confirmButtonText: 'Aceptar'
            });
        @endif
    });
</script>
@endsection
