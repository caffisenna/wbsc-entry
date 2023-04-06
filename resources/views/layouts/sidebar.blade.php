<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @auth
        <a href="{{ url('/home') }}" class="brand-link">
        @else
            <a href="{{ url('/') }}" class="brand-link">
            @endauth

            <img src="{{ url('/images/woggle.png') }}" alt="{{ config('app.name') }} Logo"
                class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @include('layouts.menu')
                </ul>
            </nav>
        </div>
</aside>
