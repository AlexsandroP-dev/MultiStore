@extends('layouts.auth')

@section('title', ' - Recuperar Senha')

@section('content')
    <h4 class="mb-2 text-center">Digite seu Email para Recuperar sua Senha</h4>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-group mb-3">
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" placeholder="Digite seu email" autofocus autocomplete="email" value="{{ old('email') }}"
                    required>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>
        </div>
        @include('utils.form.error', ['param' => 'email'])
        <div class="d-grid">
            <button type="submit" class="btn btn-primary mb-3">Enviar link para redefinir senha</button>
        </div>
    </form>
    <p>{{ session('status') }}</p>
    <span>Retornar ao </span>
    <a class="text-primary" href="{{ route('login') }}">
        Login
    </a>
@endsection
