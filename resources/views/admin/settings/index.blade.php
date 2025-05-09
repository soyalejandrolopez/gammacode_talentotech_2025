@extends('layouts.admin')

@section('title', 'Ajustes del Sistema')

@section('styles')
<style>
    .settings-nav .list-group-item {
        border-radius: 0;
        padding: 1rem 1.25rem;
        border-left: 3px solid transparent;
    }

    .settings-nav .list-group-item.active {
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        border-left: 3px solid var(--bs-primary);
    }

    .settings-nav .icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-primary-light {
        background-color: rgba(var(--bs-primary-rgb), 0.15);
    }

    .bg-success-light {
        background-color: rgba(var(--bs-success-rgb), 0.15);
    }

    .bg-info-light {
        background-color: rgba(var(--bs-info-rgb), 0.15);
    }

    .bg-warning-light {
        background-color: rgba(var(--bs-warning-rgb), 0.15);
    }

    .bg-danger-light {
        background-color: rgba(var(--bs-danger-rgb), 0.15);
    }

    .bg-secondary-light {
        background-color: rgba(var(--bs-secondary-rgb), 0.15);
    }

    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="card chart-card fade-in-up">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-sliders-h text-primary me-2"></i>
                <span class="fw-bold">Panel de Ajustes</span>
            </div>
            <div class="list-group list-group-flush settings-nav">
                <a href="#general" class="list-group-item list-group-item-action d-flex align-items-center active" data-bs-toggle="pill">
                    <div class="icon-circle bg-primary-light text-primary me-3">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div>
                        <div class="fw-medium">General</div>
                        <small class="text-muted">Nombre, descripción y textos</small>
                    </div>
                </a>
                <a href="#contact" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="pill">
                    <div class="icon-circle bg-success-light text-success me-3">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Contacto</div>
                        <small class="text-muted">Email, teléfono y dirección</small>
                    </div>
                </a>
                <a href="#social" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="pill">
                    <div class="icon-circle bg-info-light text-info me-3">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Redes Sociales</div>
                        <small class="text-muted">Facebook, Instagram, Twitter</small>
                    </div>
                </a>
                <a href="#appearance" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="pill">
                    <div class="icon-circle bg-warning-light text-warning me-3">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Apariencia</div>
                        <small class="text-muted">Logo, favicon e imágenes</small>
                    </div>
                </a>
                <a href="#ecommerce" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="pill">
                    <div class="icon-circle bg-danger-light text-danger me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <div class="fw-medium">E-Commerce</div>
                        <small class="text-muted">Moneda, impuestos, envíos</small>
                    </div>
                </a>
                <a href="#maintenance" class="list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="pill">
                    <div class="icon-circle bg-secondary-light text-secondary me-3">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div>
                        <div class="fw-medium">Mantenimiento</div>
                        <small class="text-muted">Modo de mantenimiento</small>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-9">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card chart-card fade-in-up">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-cog text-primary me-2"></i>
                    <span class="fw-bold">Configuración del Sistema</span>
                </div>
                <span class="badge bg-primary rounded-pill">Ajustes Globales</span>
            </div>
            <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content">
                            <!-- General Settings -->
                            <div class="tab-pane fade show active" id="general">
                                <h5 class="border-bottom pb-2 mb-3">Ajustes Generales</h5>

                                <div class="mb-3">
                                    <label for="site_name" class="form-label">Nombre del Sitio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('site_name') is-invalid @enderror" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="site_description" class="form-label">Descripción del Sitio</label>
                                    <textarea class="form-control @error('site_description') is-invalid @enderror" id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="footer_text" class="form-label">Texto del Pie de Página</label>
                                    <textarea class="form-control @error('footer_text') is-invalid @enderror" id="footer_text" name="footer_text" rows="2">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
                                    @error('footer_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Settings -->
                            <div class="tab-pane fade" id="contact">
                                <h5 class="border-bottom pb-2 mb-3">Información de Contacto</h5>

                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Email de Contacto <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required>
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Teléfono de Contacto</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_address" class="form-label">Dirección</label>
                                    <input type="text" class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}">
                                    @error('contact_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Social Media Settings -->
                            <div class="tab-pane fade" id="social">
                                <h5 class="border-bottom pb-2 mb-3">Redes Sociales</h5>

                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">URL de Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                                        @error('facebook_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">URL de Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">URL de Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}">
                                        @error('twitter_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">URL de YouTube</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}">
                                        @error('youtube_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Appearance Settings -->
                            <div class="tab-pane fade" id="appearance">
                                <h5 class="border-bottom pb-2 mb-3">Apariencia</h5>

                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                                        @if(isset($settings['logo']) && !empty($settings['logo']))
                                            <button class="btn btn-outline-danger" type="button" id="clear-logo">Eliminar</button>
                                        @endif
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(isset($settings['logo']) && !empty($settings['logo']))
                                        <div class="mt-2" id="logo-preview">
                                            <div class="card p-2 bg-light">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo" class="img-thumbnail me-3" style="max-height: 100px;">
                                                    <div>
                                                        <p class="mb-1 text-muted small">Logo actual</p>
                                                        <p class="mb-0 small text-truncate">{{ $settings['logo'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2" id="logo-preview"></div>
                                    @endif
                                    <div class="form-text">Formatos recomendados: PNG, JPG, SVG. Tamaño máximo: 2MB.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon" accept="image/x-icon,image/png">
                                        @if(isset($settings['favicon']) && !empty($settings['favicon']))
                                            <button class="btn btn-outline-danger" type="button" id="clear-favicon">Eliminar</button>
                                        @endif
                                        @error('favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if(isset($settings['favicon']) && !empty($settings['favicon']))
                                        <div class="mt-2" id="favicon-preview">
                                            <div class="card p-2 bg-light">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="img-thumbnail me-3" style="max-height: 32px;">
                                                    <div>
                                                        <p class="mb-1 text-muted small">Favicon actual</p>
                                                        <p class="mb-0 small text-truncate">{{ $settings['favicon'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2" id="favicon-preview"></div>
                                    @endif
                                    <div class="form-text">Formatos recomendados: ICO, PNG. Tamaño máximo: 1MB.</div>
                                </div>
                            </div>

                            <!-- E-Commerce Settings -->
                            <div class="tab-pane fade" id="ecommerce">
                                <h5 class="border-bottom pb-2 mb-3">Configuración de E-Commerce</h5>

                                <div class="mb-3">
                                    <label for="currency_symbol" class="form-label">Símbolo de Moneda</label>
                                    <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" id="currency_symbol" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol'] ?? '$') }}">
                                    @error('currency_symbol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="currency_code" class="form-label">Código de Moneda</label>
                                    <input type="text" class="form-control @error('currency_code') is-invalid @enderror" id="currency_code" name="currency_code" value="{{ old('currency_code', $settings['currency_code'] ?? 'COP') }}">
                                    @error('currency_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">Tasa de Impuesto (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" class="form-control @error('tax_rate') is-invalid @enderror" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? 19) }}">
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="shipping_fee" class="form-label">Tarifa de Envío</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ $settings['currency_symbol'] ?? '$' }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control @error('shipping_fee') is-invalid @enderror" id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $settings['shipping_fee'] ?? 0) }}">
                                        @error('shipping_fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="min_order_amount" class="form-label">Monto Mínimo de Pedido</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ $settings['currency_symbol'] ?? '$' }}</span>
                                        <input type="number" step="0.01" min="0" class="form-control @error('min_order_amount') is-invalid @enderror" id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount', $settings['min_order_amount'] ?? 0) }}">
                                        @error('min_order_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Maintenance Settings -->
                            <div class="tab-pane fade" id="maintenance">
                                <h5 class="border-bottom pb-2 mb-3">Modo de Mantenimiento</h5>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="maintenance_mode">Activar modo de mantenimiento</label>
                                </div>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Al activar el modo de mantenimiento, el sitio solo será accesible para los administradores. Los usuarios normales verán una página de mantenimiento.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> Los cambios se aplicarán inmediatamente al guardar
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activar la pestaña correspondiente si hay un hash en la URL
        let hash = window.location.hash;
        if (hash) {
            $('.list-group-item[href="' + hash + '"]').tab('show');
        }

        // Actualizar la URL cuando se cambia de pestaña
        $('.list-group-item').on('click', function(e) {
            window.location.hash = $(this).attr('href');
        });

        // Manejar la vista previa de imágenes
        const logoInput = document.getElementById('logo');
        const faviconInput = document.getElementById('favicon');
        const clearLogoBtn = document.getElementById('clear-logo');
        const clearFaviconBtn = document.getElementById('clear-favicon');

        // Vista previa del logo
        if (logoInput) {
            logoInput.addEventListener('change', function() {
                previewImage(this, 'logo-preview');
            });
        }

        // Vista previa del favicon
        if (faviconInput) {
            faviconInput.addEventListener('change', function() {
                previewImage(this, 'favicon-preview');
            });
        }

        // Eliminar logo
        if (clearLogoBtn) {
            clearLogoBtn.addEventListener('click', function() {
                // Crear un campo oculto para indicar que se debe eliminar el logo
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_logo';
                hiddenInput.value = '1';
                document.querySelector('form').appendChild(hiddenInput);

                // Limpiar la vista previa
                document.getElementById('logo-preview').innerHTML = '<div class="alert alert-info">El logo será eliminado al guardar los cambios.</div>';

                // Ocultar el botón de eliminar
                this.style.display = 'none';
            });
        }

        // Eliminar favicon
        if (clearFaviconBtn) {
            clearFaviconBtn.addEventListener('click', function() {
                // Crear un campo oculto para indicar que se debe eliminar el favicon
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_favicon';
                hiddenInput.value = '1';
                document.querySelector('form').appendChild(hiddenInput);

                // Limpiar la vista previa
                document.getElementById('favicon-preview').innerHTML = '<div class="alert alert-info">El favicon será eliminado al guardar los cambios.</div>';

                // Ocultar el botón de eliminar
                this.style.display = 'none';
            });
        }

        // Función para mostrar vista previa de imágenes
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="card p-2 bg-light">
                            <div class="d-flex align-items-center">
                                <img src="${e.target.result}" alt="Vista previa" class="img-thumbnail me-3" style="max-height: 100px;">
                                <div>
                                    <p class="mb-1 text-muted small">Nueva imagen seleccionada</p>
                                    <p class="mb-0 small text-truncate">${input.files[0].name} (${Math.round(input.files[0].size / 1024)} KB)</p>
                                </div>
                            </div>
                        </div>
                    `;
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '';
            }
        }
    });
</script>
@endsection
