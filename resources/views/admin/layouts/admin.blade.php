<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard | Rio Jimmy Motor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/images/favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon-32x32.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom styling containing Dark/Light variables -->
    <style>
        :root {
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #212529;
            --border-color: #dee2e6;
            --sidebar-bg: #111111;
            --sidebar-text: rgba(255, 255, 255, 0.7);
            --sidebar-active: #d91e18;
            --accent-red: #d91e18;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --border-color: #333333;
            --sidebar-bg: #0b0b0b;
            --sidebar-text: rgba(255, 255, 255, 0.6);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar styling - fixed so it stays put while content scrolls */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #ffffff;
            transition: all 0.3s;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
            /* Keep sidebar pinned to viewport */
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1030;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-brand {
            padding: 20px;
            font-weight: 800;
            font-size: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-item a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 25px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }

        .sidebar-item a:hover, .sidebar-item.active a {
            color: #ffffff;
            background-color: rgba(255,255,255,0.02);
            border-left: 4px solid var(--sidebar-active);
        }

        /* Main content area - offset by sidebar width so it doesn't hide under the fixed sidebar */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Top navbar sticks to the top of the scrollable content area */
        .top-navbar {
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-body {
            padding: 30px;
            flex-grow: 1;
        }

        .admin-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            margin-bottom: 25px;
        }

        .admin-card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
        }

        .admin-card-body {
            padding: 25px;
        }

        /* Widgets */
        .widget-card {
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        }

        .widget-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Theme Toggle */
        .theme-toggle {
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            color: var(--text-color);
        }

        [data-theme="dark"] .theme-toggle {
            background-color: rgba(255,255,255,0.05);
        }

        /* Mobile responsive - sidebar slides in from left on small screens */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -260px;
                z-index: 1050;
            }

            .sidebar.active {
                left: 0;
            }

            /* Remove the left offset on mobile since sidebar is hidden by default */
            .main-content {
                margin-left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0,0,0,0.4);
                z-index: 1040;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
    @stack('admin-styles')
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar overlay for mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/admin/dashboard') }}" class="sidebar-brand py-2 justify-content-center">
                <img src="{{ asset('frontend/images/riojimmymotorLogo.webp') }}" alt="Rio Jimmy Motor Logo" style="max-height: 45px; object-fit: contain;">
            </a>
            
            <ul class="sidebar-menu">
                <li class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/admin/dashboard') }}"><i class="fa fa-chart-line"></i> Dashboard</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/products*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}"><i class="fa fa-boxes-stacked"></i> Products</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}"><i class="fa fa-folder-tree"></i> Categories</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}"><i class="fa fa-file-invoice-dollar"></i> Orders</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/blogs*') ? 'active' : '' }}">
                    <a href="{{ route('admin.blogs.index') }}"><i class="fa fa-newspaper"></i> Blog Posts</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/leads*') ? 'active' : '' }}">
                    <a href="{{ route('admin.leads.index') }}"><i class="fa fa-headset"></i> Leads / Inquiries</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/seo*') ? 'active' : '' }}">
                    <a href="{{ route('admin.seo.index') }}"><i class="fa fa-globe"></i> SEO Manager</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
                    <a href="{{ route('admin.payments.index') }}"><i class="fa fa-credit-card"></i> Payments</a>
                </li>
                <li class="sidebar-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"><i class="fa fa-gears"></i> Website Settings</a>
                </li>
                <li class="sidebar-item mt-4 border-top border-secondary pt-3">
                    <a href="{{ url('/') }}" target="_blank"><i class="fa fa-external-link"></i> Live Website</a>
                </li>
            </ul>

            <div class="p-3 border-top border-secondary text-center small text-white-50">
                <span>Logged as Super Admin</span>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="main-content">
            <!-- Top Navbar -->
            <header class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-light border d-lg-none" id="sidebarToggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h5 class="m-0 fw-bold d-none d-md-block">Marketplace Administration Panel</h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Light / Dark toggle -->
                    <button class="theme-toggle" id="themeToggler" title="Toggle Light/Dark Theme">
                        <i class="fa fa-moon" id="themeIcon"></i>
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm py-2 px-3" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-circle me-1"></i> Admin user
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            <li><a class="dropdown-menu-item dropdown-item small" href="{{ route('admin.settings.index') }}"><i class="fa fa-shield me-2"></i>Security Logs</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-menu-item dropdown-item small text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt me-2"></i> Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme management and Sidebar toggling script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Theme Management
            const html = document.documentElement;
            const themeToggler = document.getElementById('themeToggler');
            const themeIcon = document.getElementById('themeIcon');

            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);

            themeToggler.addEventListener('click', function () {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('admin-theme', newTheme);
                updateThemeIcon(newTheme);
            });

            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.className = 'fa fa-sun';
                } else {
                    themeIcon.className = 'fa fa-moon';
                }
            }

            // Mobile Sidebar Toggle
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggleBtn && sidebar && overlay) {
                const toggleSidebar = () => {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                };

                toggleBtn.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @stack('admin-scripts')
</body>
</html>
