@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Editar Producto</h2>
        <div>
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-primary me-2">
                <i class="fas fa-eye me-1"></i> Ver Detalles
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Productos
            </a>
        </div>
    </div>

    <!-- Edit Product Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Información del Producto</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="store_id" class="form-label">Tienda <span class="text-danger">*</span></label>
                        <select name="store_id" id="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                            <option value="">Seleccionar tienda</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Seleccionar categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="name" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Current Images -->
                @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                    <div class="mb-3">
                        <label class="form-label">Imágenes Actuales</label>
                        <div class="row">
                            @foreach($product->images as $index => $image)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="card-img-top">
                                        <div class="card-body p-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="remove_images[]" id="remove_image_{{ $index }}" class="form-check-input" value="{{ $image }}">
                                                <label for="remove_image_{{ $index }}" class="form-check-label">Eliminar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="images" class="form-label">Añadir Imágenes</label>
                    <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" multiple>
                    <small class="text-muted">Puedes seleccionar múltiples imágenes. Formatos permitidos: JPG, PNG, GIF.</small>
                    @error('images.*')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Producto activo</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label">Producto destacado</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- New Category Modal -->
    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCategoryModalLabel">Nueva Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newCategoryForm">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                            <div class="invalid-feedback" id="category_name_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveCategory">Guardar Categoría</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Save new category
        document.getElementById('saveCategory').addEventListener('click', function() {
            const form = document.getElementById('newCategoryForm');
            const formData = new FormData(form);

            // Reset errors
            document.getElementById('category_name_error').textContent = '';
            document.getElementById('category_name').classList.remove('is-invalid');

            fetch('{{ route('admin.categories.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add new category to select
                    const categorySelect = document.getElementById('category_id');
                    const option = document.createElement('option');
                    option.value = data.category.id;
                    option.text = data.category.name;
                    option.selected = true;
                    categorySelect.appendChild(option);

                    // Close modal and reset form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newCategoryModal'));
                    modal.hide();
                    form.reset();

                    // Show success message
                    alert('Categoría creada exitosamente');
                } else {
                    // Show validation errors
                    if (data.errors && data.errors.name) {
                        document.getElementById('category_name').classList.add('is-invalid');
                        document.getElementById('category_name_error').textContent = data.errors.name[0];
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ha ocurrido un error al crear la categoría');
            });
        });
    });
</script>
@endsection
