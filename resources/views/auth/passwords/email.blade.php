@extends('layouts.app')

@section('styles')
<style>
    :root {
        --primary: #2E7D32;
        --primary-light: #60ad5e;
        --primary-dark: #005005;
        --secondary: #FFA000;
        --secondary-light: #ffd149;
        --secondary-dark: #c67100;
    }

    body {
        background: url('https://images.pexels.com/photos/1132047/pexels-photo-1132047.jpeg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .reset-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
    }

    .reset-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(5px);
        z-index: 0;
    }

    .reset-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 900px;
        width: 100%;
        position: relative;
        z-index: 1;
        background-color: white;
    }

    .reset-card .row {
        min-height: 400px;
    }

    .reset-image {
        background: url('https://images.pexels.com/photos/1638280/pexels-photo-1638280.jpeg') no-repeat center center;
        background-size: cover;
        position: relative;
        border-radius: 15px 0 0 15px;
    }

    .reset-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(46,125,50,0.9) 0%, rgba(255,160,0,0.9) 100%);
        border-radius: 15px 0 0 15px;
    }

    @media (max-width: 767.98px) {
        .reset-image {
            border-radius: 15px 15px 0 0;
            min-height: 200px;
        }

        .reset-image::before {
            border-radius: 15px 15px 0 0;
        }

        .reset-card .row {
            min-height: auto;
        }
    }

    .reset-image-content {
        position: relative;
        z-index: 1;
        padding: 2rem;
        color: white;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .reset-form {
        padding: 2rem;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .reset-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--primary-dark);
        position: relative;
        display: inline-block;
        margin-left: auto;
        margin-right: auto;
    }

    .reset-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: var(--secondary);
        border-radius: 2px;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 1rem 1rem 1rem 0.75rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
        height: calc(3.5rem + 2px);
        background-color: #f8f9fa;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15);
        background-color: white;
    }

    .form-floating > label {
        padding: 1rem 0.75rem;
        color: #6c757d;
    }

    .btn-reset {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
        margin-top: 1rem;
        font-size: 1rem;
    }

    .btn-reset:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .login-link {
        margin-top: 1.5rem;
        text-align: center;
    }

    .login-link a {
        color: var(--secondary);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: var(--secondary-dark);
        text-decoration: underline;
    }

    .alert-success-custom {
        background-color: rgba(46, 125, 50, 0.1);
        color: var(--primary-dark);
        border: none;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary);
    }
</style>
@endsection

@section('content')
<div class="reset-container">
    <div class="container">
        <div class="card reset-card">
            <div class="row g-0">
                <div class="col-md-5 reset-image">
                    <div class="reset-image-content">
                        <h2 class="h1 mb-4">¿Olvidaste tu contraseña?</h2>
                        <p class="lead mb-4">No te preocupes, te enviaremos un enlace para que puedas restablecerla fácilmente.</p>
                        <div class="mt-4">
                            <i class="fas fa-lock-open fa-3x mb-3" style="color: var(--secondary-light);"></i>
                            <p>Recupera el acceso a tu cuenta de forma segura y rápida.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 d-flex align-items-center">
                    <div class="reset-form w-100">
                        <h3 class="reset-title text-center">{{ __('Reset Password') }}</h3>

                        @if (session('status'))
                            <div class="alert alert-success-custom mx-auto" style="max-width: 400px;" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="mx-auto" style="max-width: 400px;">
                            @csrf

                            <div class="form-floating">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}">
                                <label for="email">{{ __('Email Address') }}</label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-reset">
                                {{ __('Send Password Reset Link') }}
                            </button>

                            <div class="login-link">
                                <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Volver al inicio de sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar mensaje de error si existe
        @if($errors->any())
            Swal.fire({
                title: '¡Error!',
                text: 'Por favor verifica tu correo electrónico e intenta nuevamente.',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#2E7D32'
            });
        @endif

        // Mostrar mensaje de éxito si se envió el enlace
        @if(session('status'))
            Swal.fire({
                title: '¡Enlace enviado!',
                text: 'Hemos enviado un enlace para restablecer tu contraseña a tu correo electrónico.',
                icon: 'success',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#2E7D32'
            });
        @endif

        // Interceptar el envío del formulario para mostrar un mensaje de carga
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                if (this.checkValidity()) {
                    Swal.fire({
                        title: 'Enviando enlace',
                        text: 'Por favor espera un momento...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        }
    });
</script>
@endsection
