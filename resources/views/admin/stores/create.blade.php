@extends('layouts.admin')

@section('title', 'Crear Tienda')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Crear Tienda</h2>
        <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Tiendas
        </a>
    </div>

    <!-- Create Store Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Información de la Tienda</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label">Propietario <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Seleccionar propietario</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre de la Tienda <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}">
                        @error('whatsapp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="logo" class="form-label">Logo</label>
                        <div class="input-group">
                            <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            <button class="btn btn-outline-secondary" type="button" id="clear-logo">Limpiar</button>
                        </div>
                        <small class="text-muted">Tamaño recomendado: 200x200 píxeles</small>
                        <div id="logo-preview" class="mt-2"></div>
                        @error('logo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="banner" class="form-label">Banner</label>
                        <div class="input-group">
                            <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror" accept="image/*">
                            <button class="btn btn-outline-secondary" type="button" id="clear-banner">Limpiar</button>
                        </div>
                        <small class="text-muted">Tamaño recomendado: 1200x300 píxeles</small>
                        <div id="banner-preview" class="mt-2"></div>
                        @error('banner')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Tienda activa</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Tienda
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.querySelector('form');
        const logoInput = document.getElementById('logo');
        const bannerInput = document.getElementById('banner');
        const clearLogoBtn = document.getElementById('clear-logo');
        const clearBannerBtn = document.getElementById('clear-banner');

        // Preview images when selected
        logoInput.addEventListener('change', function() {
            previewImage(this, 'logo-preview');
        });

        bannerInput.addEventListener('change', function() {
            previewImage(this, 'banner-preview');
        });

        // Clear buttons
        clearLogoBtn.addEventListener('click', function() {
            clearFileInput(logoInput, 'logo-preview');
        });

        clearBannerBtn.addEventListener('click', function() {
            clearFileInput(bannerInput, 'banner-preview');
        });

        // Function to preview images
        function previewImage(input, previewId) {
            const previewContainer = document.getElementById(previewId);
            if (!previewContainer) {
                const container = document.createElement('div');
                container.id = previewId;
                container.className = 'mt-2';
                input.parentNode.appendChild(container);
            }

            const preview = document.getElementById(previewId);

            // Clear previous preview
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxHeight = '150px';
                    preview.appendChild(img);

                    // Log to console for debugging
                    console.log(`File selected for ${input.name}:`, input.files[0].name);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Function to clear file input
        function clearFileInput(input, previewId) {
            input.value = '';
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.innerHTML = '';
            }
            console.log(`Cleared ${input.name} input`);
        }

        // Form submission validation
        form.addEventListener('submit', function(e) {
            // Log form data for debugging
            const formData = new FormData(form);
            console.log('Form submission:');
            for (let [key, value] of formData.entries()) {
                if (key === 'logo' || key === 'banner') {
                    console.log(`${key}: ${value.name || 'No file selected'}`);
                } else {
                    console.log(`${key}: ${value}`);
                }
            }
        });
    });
</script>
@endsection
