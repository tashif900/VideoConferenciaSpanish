<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        <li class="nav-item dropdown" id="notifications-list-container">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                @if ($notifications->count() > 0)
                    <span class="badge badge-warning navbar-badge">{{ $notifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifications-list">
                <span class="dropdown-item dropdown-header">{{ $notifications->count() }} Notificaciones</span>
                <div class="dropdown-divider"></div>
                @if ($notifications->count() > 0)
                    @foreach ($notifications as $notification)
                        <a href="{{ route('admin.notifications') }}" class="dropdown-item">
                            <i class="fas {{ $notification->type }} mr-2"></i> <span style="font-size: 14px">{{ $notification->message }}</span>
                            <span class="float-right text-muted text-sm">{{ \Date::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    <a href="{{ route('admin.notifications') }}" class="dropdown-item dropdown-footer">Ver más Notificationes</a>
                @else
                    <p class="text-center my-3">No tienes notificationes</p>
                @endif
            </div>
        </li>

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
