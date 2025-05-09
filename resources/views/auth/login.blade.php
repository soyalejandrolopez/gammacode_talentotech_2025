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
        background: url('https://images.pexels.com/photos/440731/pexels-photo-440731.jpeg') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
    }

    .login-container::before {
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

    .login-card {
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

    .login-card .row {
        min-height: 500px;
    }

    .login-image {
        background: url('https://images.pexels.com/photos/2933243/pexels-photo-2933243.jpeg') no-repeat center center;
        background-size: cover;
        position: relative;
        border-radius: 15px 0 0 15px;
    }

    .login-image::before {
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
        .login-image {
            border-radius: 15px 15px 0 0;
            min-height: 200px;
        }

        .login-image::before {
            border-radius: 15px 15px 0 0;
        }

        .login-card .row {
            min-height: auto;
        }
    }

    .login-image-content {
        position: relative;
        z-index: 1;
        padding: 2rem;
        color: white;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-form {
        padding: 3rem 2rem;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .login-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--primary-dark);
        position: relative;
        display: inline-block;
    }

    .login-title::after {
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

    .btn-login {
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

    .btn-login:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .forgot-password {
        color: var(--primary);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .forgot-password:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .register-link {
        margin-top: 1.5rem;
        text-align: center;
    }

    .register-link a {
        color: var(--secondary);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .register-link a:hover {
        color: var(--secondary-dark);
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="container">
        <div class="card login-card">
            <div class="row g-0">
                <div class="col-md-6 login-image">
                    <div class="login-image-content">
                        <h2 class="h1 mb-4">¡Bienvenido a AgroGastro!</h2>
                        <p class="lead mb-4">Conectamos productores locales directamente con los consumidores. Productos frescos, naturales y de temporada.</p>
                        <div class="d-flex mt-4">
                            <div class="me-4">
                                <i class="fas fa-leaf fa-2x mb-2" style="color: var(--secondary-light);"></i>
                                <p>Productos Frescos</p>
                            </div>
                            <div>
                                <i class="fas fa-users fa-2x mb-2" style="color: var(--secondary-light);"></i>
                                <p>Apoyo Local</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="login-form w-100">
                        <h3 class="login-title text-center">{{ __('Login') }}</h3>

                        <form method="POST" action="{{ route('login') }}" id="loginForm" class="mx-auto" style="max-width: 400px;">
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

                            <div class="form-floating">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
                                <label for="password">{{ __('Password') }}</label>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="forgot-password" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-login">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('register'))
                                <div class="register-link">
                                    ¿No tienes una cuenta? <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                </div>
                            @endif
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
                text: 'Por favor verifica tus credenciales e intenta nuevamente.',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#2E7D32'
            });
        @endif

        // Mostrar mensaje de éxito si el usuario acaba de registrarse
        @if(session('status'))
            Swal.fire({
                title: '¡Bienvenido!',
                text: '{{ session('status') }}',
                icon: 'success',
                confirmButtonText: 'Continuar',
                confirmButtonColor: '#2E7D32'
            });
        @endif

        // Interceptar el envío del formulario para mostrar un mensaje de carga
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                if (this.checkValidity()) {
                    Swal.fire({
                        title: 'Iniciando sesión',
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
