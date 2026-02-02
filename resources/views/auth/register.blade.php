@extends('layouts.auth')

@section('title', ' - Registro')

@section('content')
    <h4 class="mb-2 text-center">Cadastre-se</h4>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="nome">Nome</label>
            <div class="input-group">
                <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome"
                    placeholder="Digite seu nome" autofocus autocomplete="nome" value="{{ old('nome') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="login">Email</label>
            <div class="input-group">
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    id="email" placeholder="Digite seu email" autofocus autocomplete="email" value="{{ old('email') }}"
                    required>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>
        </div>
        {{-- @include('utils.form.error', ['param' => 'login']) --}}
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
        <div class="form-group mb-3">
            <label class="form-label" for="password">Confirme a Senha</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation" id="password_confirmation" placeholder="Digite sua Senha" required>
                <div class="input-group-text">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="togglePasswordConfirmation">
                        <span class="bi bi-eye" id="eyeIconConfirmation"></span>
                    </button>
                </div>
            </div>
            @include('utils.form.error', ['param' => 'password_confirmation'])
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary mb-3">Cadastrar</button>
        </div>
        Possui cadastro? <a href="{{ route('login') }}">Entre aqui</a>
    </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePasswordConfirmation');
            const password = document.querySelector('#password_confirmation');
            const eyeIcon = document.querySelector('#eyeIconConfirmation');

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
