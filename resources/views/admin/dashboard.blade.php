<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Admin — Sistem Informasi Kerjasama Polimdo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
</head>

<body>
    <!-- navbar -->
    <nav>
        <div class="nav-inner">
            <div class="nav-brand">
                <button id="hamburger" aria-label="Toggle sidebar">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <div class="brand-icon"><img src="{{ asset('img/logo.png') }}" alt="Handshake" width="35" height="35"></div>
                <div class="brand-text">
                    <h1>POLIMDO &amp; DUDIKA</h1>
                    <p>Sistem Informasi Kerjasama</p>
                </div>
            </div>

            <div class="nav-actions">
                <!-- Search hint (desktop) -->
                <div class="search-bar" style="width:220px; display:none; align-items:center;" id="navSearch">
                    <i class="fas fa-search"></i>
                    <span>Cari data...</span>
                </div>

                <button class="icon-btn" id="darkModeBtn" title="Toggle dark mode">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                <button class="icon-btn" id="notificationBtn" title="Notifications">
                    <i class="fas fa-bell" id="notificationIcon"></i>
                    <span class="notification-badge">3</span>
                </button>

                <form method="POST" action="/logout" style="display: inline;">
                    @csrf
                    <button type="submit" class="icon-btn danger" id="logoutBtn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- sidebar -->
    <div class="layout">
        <!-- ── SIDEBAR ──────────────────────────────────────────── -->
        <aside id="sidebar">
            <div class="menu-section">Administration</div>

            <a class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="menu-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            @php
                $isUserManagementActive = request()->routeIs('users') || request()->routeIs('roles.*') || request()->routeIs('profiles');
            @endphp
            <div id="dataMasterParent" class="menu-item {{ $isUserManagementActive ? 'active' : '' }}" style="flex-direction:column; align-items:stretch; padding:0;">
                <div id="dataMasterBtn" class="menu-item {{ $isUserManagementActive ? 'submenu-open' : '' }}" style="margin:0; cursor: pointer;">
                    <div class="menu-icon"><i class="fas fa-users"></i></div>
                    <span style="flex:1; font-size:13px; font-weight:600;">User Management</span>
                    <i class="fas fa-chevron-down menu-chevron"></i>
                </div>
                <div class="submenu {{ $isUserManagementActive ? 'open' : '' }}" id="dataMasterSub">
                    <a class="submenu-item {{ request()->routeIs('users') ? 'active' : '' }}" href="{{ route('users') }}">
                        <span class="submenu-dot"></span>Users
                    </a>
                    <a class="submenu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <span class="submenu-dot"></span>Roles
                    </a>
                    <a class="submenu-item {{ request()->routeIs('profiles') ? 'active' : '' }}" href="{{ route('profiles') }}">
                        <span class="submenu-dot"></span>Profiles
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        @yield('content')

        <div id="sidebarOverlay"></div>
    </div>

    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
</body>

</html>