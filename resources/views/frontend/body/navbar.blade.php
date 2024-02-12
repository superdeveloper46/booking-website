<div class="navbar-area">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="/" class="logo">
            <img src="{{ asset('/frontend/assets/img/logos/logo.png') }}" class="logo-one" alt="Logo">
            <img src="{{ asset('/frontend/assets/img/logos/logo.png') }}" class="logo-two" alt="Logo">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light ">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('/frontend/assets/img/logos/logo.png') }}" class="logo-one" alt="Logo">
                    <img src="{{ asset('/frontend/assets/img/logos/logo.png') }}" class="logo-two" alt="Logo">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ request()->path() == '/' ? 'active' : '' }}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('book') }}" class="nav-link {{ request()->routeIs('book') ? 'active' : '' }}">
                                Book Now
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
