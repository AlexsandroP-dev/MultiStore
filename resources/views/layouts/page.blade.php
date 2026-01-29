@extends('layouts.base')

@section('body')
    <div class="d-flex">
        @include('layouts.pagePartials.sidebar')

        <div class="w-100 d-flex flex-column min-vh-100">
            <main class="flex-grow-1 p-4">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>

            @include('layouts.pagePartials.footer')
        </div>
    </div>
@endsection
