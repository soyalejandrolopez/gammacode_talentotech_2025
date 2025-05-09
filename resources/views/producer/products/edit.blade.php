@extends('layouts.producer')

@section('title', 'Editar Producto')

@section('content')
    <!-- Título y descripción -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card fade-in-up">
                <div class="modern-card-header">
                    <h5 class="modern-card-title">
                        <i class="fas fa-edit" style="color: var(--yellow);"></i> Editar Producto: {{ $product->name }}
                    </h5>
                </div>
                <div class="modern-card-body">
                    <p class="text-muted mb-0">
                        Actualiza la información de tu producto. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
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
                    <form action="{{ route('producer.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Información básica -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categoría</label>
                                    <div class="input-group">
                                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Seleccionar Categoría</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal" title="Añadir nueva categoría">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Selecciona una categoría o crea una nueva si no existe.</div>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" class="form-control @error('stock') is-invalid @enderror" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="form-control @error('sku') is-invalid @enderror">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Imágenes Actuales</label>
                            @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                                <div class="row mb-3">
                                    @foreach($product->images as $image)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
                                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="img-thumbnail product-image" style="height: 120px; width: 100%; object-fit: cover; border: 3px solid var(--blue); box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-muted small mb-3">Subir nuevas imágenes reemplazará todas las imágenes actuales.</p>
                            @else
                                <p class="text-muted mb-3">No hay imágenes subidas aún.</p>
                            @endif

                            <label for="images" class="form-label">Subir Nuevas Imágenes</label>
                            <input type="file" name="images[]" id="images" multiple class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror">
                            <div class="form-text">Puedes seleccionar múltiples imágenes. Tamaño recomendado: 800x600 píxeles</div>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="form-check-input">
                                    <label for="is_active" class="form-check-label">Producto Activo</label>
                                </div>
                                <div class="form-text">Los productos activos son visibles en la tienda.</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="form-check-input">
                                    <label for="is_featured" class="form-check-label">Producto Destacado</label>
                                </div>
                                <div class="form-text">Los productos destacados aparecerán en secciones especiales de tu tienda.</div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('producer.products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Volver a Productos
                            </a>
                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, var(--blue), var(--blue-dark)); border: none; box-shadow: 0 4px 10px rgba(13,71,161,0.3);">
                                <i class="fas fa-save me-2"></i> Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal para crear nueva categoría -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--yellow-light), var(--yellow)); color: #333;">
                <h5 class="modal-title" id="newCategoryModalLabel">
                    <i class="fas fa-folder-plus me-2"></i> Crear Nueva Categoría
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newCategoryForm">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Nombre de la Categoría <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="category_name" name="name" required>
                        <div id="category_name_error" class="text-danger mt-1"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category_description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="category_description" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="saveCategory" class="btn btn-primary" style="background: linear-gradient(135deg, var(--yellow), var(--yellow-dark)); border: none; box-shadow: 0 4px 10px rgba(255,193,7,0.3);">
                    <i class="fas fa-save me-2"></i> Guardar Categoría
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto 3D para las imágenes al hacer hover
        const images = document.querySelectorAll('.product-image');

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

        // Guardar nueva categoría
        document.getElementById('saveCategory').addEventListener('click', function() {
            const form = document.getElementById('newCategoryForm');
            const formData = new FormData(form);

            // Mostrar indicador de carga
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Guardando...';
            this.disabled = true;

            // Resetear errores
            document.getElementById('category_name_error').textContent = '';
            document.getElementById('category_name').classList.remove('is-invalid');

            fetch('{{ route('producer.categories.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Restaurar botón
                this.innerHTML = '<i class="fas fa-save me-2"></i> Guardar Categoría';
                this.disabled = false;

                if (data.success) {
                    // Añadir nueva categoría al select
                    const categorySelect = document.getElementById('category_id');
                    const option = document.createElement('option');
                    option.value = data.category.id;
                    option.text = data.category.name;
                    option.selected = true;
                    categorySelect.appendChild(option);

                    // Cerrar modal y resetear formulario
                    const modal = bootstrap.Modal.getInstance(document.getElementById('newCategoryModal'));
                    modal.hide();
                    form.reset();

                    // Mostrar mensaje de éxito
                    const alertContainer = document.createElement('div');
                    alertContainer.className = 'alert alert-success alert-dismissible fade show';
                    alertContainer.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i> Categoría <strong>${data.category.name}</strong> creada exitosamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;

                    // Insertar alerta al principio del formulario
                    const formElement = document.querySelector('form[action="{{ route('producer.products.update', $product) }}"]');
                    formElement.prepend(alertContainer);

                    // Auto-cerrar alerta después de 5 segundos
                    setTimeout(() => {
                        alertContainer.remove();
                    }, 5000);

                    // Aplicar efecto de destaque al select
                    categorySelect.style.boxShadow = '0 0 0 0.25rem rgba(255, 193, 7, 0.5)';
                    setTimeout(() => {
                        categorySelect.style.boxShadow = '';
                    }, 2000);
                } else {
                    // Mostrar errores de validación
                    if (data.errors && data.errors.name) {
                        document.getElementById('category_name').classList.add('is-invalid');
                        document.getElementById('category_name_error').textContent = data.errors.name[0];
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Restaurar botón
                this.innerHTML = '<i class="fas fa-save me-2"></i> Guardar Categoría';
                this.disabled = false;

                // Mostrar mensaje de error
                document.getElementById('category_name_error').textContent = 'Ha ocurrido un error al crear la categoría. Inténtalo de nuevo.';
            });
        });
    });
</script>
@endsection
