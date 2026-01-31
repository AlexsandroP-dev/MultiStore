@extends('layouts.base')

@section('body')
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-3">
                            <a href="/" target="_blank">
                                <img src="['nada aqui']" class="img-fluid" alt="['nada aqui']">
                            </a>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        body {
            background-color: #e9ecef !important;
        }
    </style>
@endsection
