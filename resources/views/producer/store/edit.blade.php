@extends('layouts.producer')

@section('title', 'Editar Tienda')

@section('content')
    <!-- Título y descripción -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-store" style="color: var(--yellow);"></i> Editar Mi Tienda
                    </h5>
                </div>
                <div class="modern-card-body">
                    <p class="text-muted mb-0">
                        Personaliza la información de tu tienda para que tus clientes puedan conocerte mejor. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card fade-in-up" style="animation-delay: 0.1s;">
                <div class="modern-card-body">
                    <form action="{{ route('producer.store.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Información básica -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre de la Tienda <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $store->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $store->email) }}" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $store->description) }}</textarea>
                            <div class="form-text">Describe tu tienda, tus productos y lo que te hace especial.</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Información de contacto -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $store->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">Número de WhatsApp</label>
                                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}" class="form-control @error('whatsapp') is-invalid @enderror">
                                    <div class="form-text">Incluye el código de país (ej: +573001234567)</div>
                                    @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label">Dirección</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $store->address) }}" class="form-control @error('address') is-invalid @enderror">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Imágenes -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo de la Tienda</label>
                                    @if($store->logo)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="img-thumbnail" style="max-height: 150px; max-width: 150px; border: 3px solid var(--yellow); box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        </div>
                                    @endif
                                    <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                                    <div class="form-text">Tamaño recomendado: 200x200 píxeles</div>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="banner" class="form-label">Banner de la Tienda</label>
                                    @if($store->banner)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}" class="img-thumbnail" style="max-height: 100px; max-width: 100%; border: 3px solid var(--blue); box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        </div>
                                    @endif
                                    <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror">
                                    <div class="form-text">Tamaño recomendado: 1200x300 píxeles</div>
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('producer.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, var(--yellow), var(--yellow-dark)); border: none; box-shadow: 0 4px 10px rgba(255,193,7,0.3);">
                                <i class="fas fa-save me-2"></i> Actualizar Tienda
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para las imágenes al hacer hover
        const images = document.querySelectorAll('.img-thumbnail');

        images.forEach(img => {
            img.addEventListener('mouseover', function() {
                this.style.transform = 'perspective(500px) rotateY(5deg) scale(1.05)';
                this.style.transition = 'all 0.3s ease';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
            });

            img.addEventListener('mouseout', function() {
                this.style.transform = 'perspective(500px) rotateY(0) scale(1)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            });
        });
    });
</script>
@endsection
