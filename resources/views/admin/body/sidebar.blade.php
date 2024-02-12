<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Booking</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">

        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="{{ route('bookingCalendar') }}">
                <div class="parent-icon"><i class='bx bx-calendar'></i>
                </div>
                <div class="menu-title">Booking Canlendar</div>
            </a>
        </li>
        <li>
            <a href="{{ route('all.booking') }}">
                <div class="parent-icon"><i class='bx bx-book-content'></i>
                </div>
                <div class="menu-title">Booking List</div>
            </a>
        </li>

        <li>
            <a href="{{ route('all.room') }}">
                <div class="parent-icon"><i class='bx bx-windows'></i>
                </div>
                <div class="menu-title">Manage Room</div>
            </a>
        </li>

        <li>
            <a href="{{ route('all.user') }}">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Manage User</div>
            </a>
        </li>
    </ul>
</div>
