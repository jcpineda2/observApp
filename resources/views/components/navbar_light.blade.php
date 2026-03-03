<nav class="navbar navbar-expand-lg center-nav transparent position-absolute navbar-dark caret-none">
    <div class="container flex-lg-row flex-nowrap align-items-center">
        <div class="navbar-brand w-100">
            <a href="/">
                <img class="logo-light" src="{{ asset('img/logo-light.png') }}"
                    srcset="{{ asset('img/logo-light@2x.png 2x') }}" alt="" />
                <img class="logo-dark" src="{{ asset('img/logo-dark.png') }}"
                    srcset="{{ asset('img/logo-dark@2x.png 2x') }}" alt="" />
            </a>
        </div>
        @include('public.components.navigator_collapse')
        <!-- /.navbar-collapse -->
        <div class="navbar-other w-100 d-flex ms-auto">
            <ul class="flex-row navbar-nav align-items-center ms-auto">
                <li class="d-none d-md-block nav-item"><a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-info"><a
                            href="{{ route('filament.prestadores.auth.login') }}"
                            class="btn btn-white rounded-pill">Acceso a Prestadores</a></li>
                <li class="nav-item d-lg-none">
                    <button class="hamburger offcanvas-nav-btn"><span></span></button>
                </li>
            </ul>
            <!-- /.navbar-nav -->
        </div>
        <!-- /.navbar-other -->
    </div>
    <!-- /.container -->
</nav>
