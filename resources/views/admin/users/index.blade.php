@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Usuarios</h2>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Crear Usuario
            </a>
        </div>
    </div>

    <!-- Los mensajes de éxito y error ahora se muestran con SweetAlert2 -->

    <!-- Users List Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Usuarios</h5>
            <div>
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar usuarios..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
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
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users text-muted mb-3" style="font-size: 2rem;"></i>
                    <p class="text-muted">No se encontraron usuarios.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- No modal needed anymore -->
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar los enlaces de eliminación
        const deleteLinks = document.querySelectorAll('.delete-btn');
        deleteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
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
        });

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
