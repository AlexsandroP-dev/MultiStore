<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container text-center">
        <span>© {{ date('Y') }} <a class="text-muted text-decoration-none"
                href="{{ route(config('themes.mainTheme.sidebar.sideBarHeaderRoute')) }}">{{ config('themes.mainTheme.base.HeaderTitle') }}</a>
            - Todos os direitos reservados. </span>
    </div>
</footer>
