@extends('layouts.auth')

@section('title', ' - Login')

@section('content')
    <h4 class="mb-2 text-center">Faça Login</h4>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-group">
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    placeholder="Entre com email" autofocus autocomplete="email" value="{{ old('email') }}"
                    required>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>
        </div>
        @include('utils.form.error', ['param' => 'login'])
        <div class="form-group">
            <label class="form-label" for="password">Senha</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    id="password" placeholder="Digite sua Senha" required>
                <div class="input-group-text">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="togglePassword">
                        <span class="bi bi-eye" id="eyeIcon"></span>
                    </button>
                </div>
            </div>
            @include('utils.form.error', ['param' => 'password'])
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="custom-control custom-checkbox ms-1">
                <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                <label class="form-check-label" for="basic_checkbox_1">Lembrar-me</label>
            </div>
            <a href="{{ route('password.request') }}">Esqueci minha senha</a>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary mb-3">Logar</button>
        </div>
    </form>
    @if (Route::has('register'))
        <span>Não possui cadastro?</span>
        <a class="text-primary" href="{{ route('register') }}">Cadastre-se</a>
    @endif
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    // Alterna o tipo do input
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // Alterna o ícone (olho aberto / olho cortado)
                    eyeIcon.classList.toggle('bi-eye');
                    eyeIcon.classList.toggle('bi-eye-slash');
                });
            }
        });
    </script>
@endsection