<?php
$notifications = App\Models\Notification::where("user_id", Auth::user()->id)->where("is_read", 0)->count();
$organization = DB::table('x_organizations')
    ->where('id', '=', 1)->first();
?>

<style>
.header-navbar.pcoded-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
}

.navbar-logo a, .navbar-logo h1 {
    color: #ffffff !important;
}

.nav-left a, .mobile-menu, .mobile-options, .dropdown-toggle {
    color: #ffffff !important;
}

.dropdown-toggle span {
    color: #ffffff !important;
}

.dropdown-toggle i {
    color: #ffffff !important;
}

/* Modern Dropdown Styling */
.dropdown-menu {
    background: #ffffff !important;
    border: none !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    padding: 8px 0 !important;
    margin-top: 8px !important;
    min-width: 200px !important;
    overflow: hidden !important;
}

.dropdown-menu li {
    margin: 0 !important;
}

.dropdown-menu a {
    color: #374151 !important;
    padding: 12px 20px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    text-decoration: none !important;
}

.dropdown-menu a:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #ffffff !important;
    text-decoration: none !important;
    transform: translateX(4px);
}

.dropdown-menu a i {
    font-size: 16px !important;
    width: 18px !important;
    text-align: center !important;
    transition: all 0.2s ease !important;
}

.dropdown-menu a:hover i {
    color: #ffffff !important;
    transform: scale(1.1);
}
</style>

<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a href="{{url('/')}}">
                <h1>Payroll</h1>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu icon-toggle-right"></i>
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="full-screen feather icon-maximize"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                            <span>{{Auth::user()->name}}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <a href="#!">
                                    <i class="feather icon-settings"></i> Settings
                                    {{--  TODO setup language settings here --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{url('users/profile',Auth::user()->id)}}">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="feather icon-log-out"></i>{{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>