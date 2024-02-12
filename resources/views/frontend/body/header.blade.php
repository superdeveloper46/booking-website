<header class="top-header top-header-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div class="header-right">
                    <ul>
                        <li>
                            <i class='bx bx-moon' style="cursor: pointer" id="dark-mode" onclick="toggleTheme()"></i>
                            <a href=""></a>
                        </li>
                        <li>
                            <i class='bx bx-envelope'></i>
                            <a href="mailto:shucm11@gmail.com">shucm11@gmail.com</a>
                        </li>
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <a href="tel:0926-918-128">0926-918-128</a>
                        </li>

                        @auth
                            <li>
                                <i class='bx bxs-user-pin'></i>
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>

                            <li>
                                <i class='bx bxs-user-rectangle'></i>
                                <a href="{{ route('user.logout') }}">Logout</a>
                            </li>
                        @else
                            <li>
                                <i class='bx bxs-user-pin'></i>
                                <a href="{{ route('login') }}">Login</a>
                            </li>

                            <li>
                                <i class='bx bxs-user-rectangle'></i>
                                <a href="{{ route('register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
