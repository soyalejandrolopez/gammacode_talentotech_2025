@extends('layouts.admin')

@section('title', 'Detalles de Tienda')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Detalles de Tienda</h2>
        <div>
            <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Tiendas
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Store Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Información de la Tienda</h5>
                    <span class="badge {{ $store->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $store->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Nombre</h6>
                                <p class="mb-0">{{ $store->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Slug</h6>
                                <p class="mb-0">{{ $store->slug }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Propietario</h6>
                                <p class="mb-0">
                                    <a href="{{ route('admin.users.show', $store->user) }}">
                                        {{ $store->user->name }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Email</h6>
                                <p class="mb-0">{{ $store->email ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Teléfono</h6>
                                <p class="mb-0">{{ $store->phone ?? 'No especificado' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">WhatsApp</h6>
                                <p class="mb-0">{{ $store->whatsapp ?? 'No especificado' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Dirección</h6>
                                <p class="mb-0">{{ $store->address ?? 'No especificada' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Fecha de Creación</h6>
                                <p class="mb-0">{{ $store->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-1">Descripción</h6>
                        <p class="mb-0">{{ $store->description ?? 'Sin descripción' }}</p>
                    </div>
                    
                    <div class="row">
                        @if($store->logo)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-1">Logo</h6>
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        
                        @if($store->banner)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted mb-1">Banner</h6>
                                <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Ver Tienda en el Sitio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Products -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Productos Recientes</h5>
                    <span class="badge bg-primary">{{ $store->products->count() }} productos</span>
                </div>
                <div class="card-body">
                    @if($store->products->count() > 0)
                        <ul class="list-group">
                            @foreach($store->products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div>{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->price }} €</small>
                                    </div>
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-box text-muted mb-3" style="font-size: 2rem;"></i>
                            <p class="text-muted">No hay productos en esta tienda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
