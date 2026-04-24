<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="flex min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">

    @include('partials.splash')

    <!-- Sidebar -->
    <div id="sidebar" class="w-72 bg-white/90 backdrop-blur-sm border-r border-white/20 flex-shrink-0 shadow-xl fixed left-0 top-0 h-screen flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-4 mx-auto shadow-lg">
                <i data-feather="map-pin" class="w-8 h-8 text-white"></i>
            </div>
            <h2 class="text-lg font-bold text-blue-700 mb-1">Barangay Bagacay</h2>
            <p class="text-sm text-blue-500 font-light">Management System</p>
        </div>

        <!-- Scrollable navigation area -->
        <div class="flex-1 overflow-y-auto">
            <nav class="px-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="home" class="w-5 h-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.events') }}" class="flex items-center gap-3 py-3 px-4 rounded-2xl {{ request()->routeIs('admin.events*') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="calendar" class="w-5 h-5"></i>
                    <span class="font-medium">Cash Assistance Events</span>
                </a>

                <a href="{{ route('dashboard.document-requests') }}" class="flex items-center gap-3 py-3 px-4 rounded-2xl {{ request()->routeIs('dashboard.document-requests') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="file-text" class="w-5 h-5"></i>
                    <span class="font-medium">Document Requests</span>
                </a>
            </nav>

        @php
            $documentsOpen =
                request()->routeIs('dashboard.portal') ||
                request()->routeIs('dashboard.agriculture') ||
                request()->routeIs('dashboard.barangay-certification') ||
                request()->routeIs('dashboard.business-certification') ||
                request()->routeIs('dashboard.good-moral-certification') ||
                request()->routeIs('events.*');

            $usersOpen =
                request()->routeIs('dashboard-residents.*') ||
                request()->routeIs('add-user.*');
        @endphp


        <div class="px-6 mt-6">
            <button onclick="toggleRequest()" class="w-full flex justify-between items-center text-left py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <div class="flex items-center gap-3">
                    <i data-feather="folder" class="w-5 h-5"></i>
                    <span class="font-medium">Create Documents</span>
                </div>
                <i data-feather="chevron-down" id="requestIcon" class="w-4 h-4 transition-transform duration-300 {{ $documentsOpen ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="requestMenu" class="ml-8 mt-2 space-y-1 overflow-hidden transition-all duration-300 {{ $documentsOpen ? 'max-h-96' : 'max-h-0' }}">
                <a href="{{ route('dashboard.portal') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.portal') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="file" class="w-4 h-4"></i>
                    <span>Indigency</span>
                </a>

                <a href="{{ route('dashboard.agriculture') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.agriculture') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="sun" class="w-4 h-4"></i>
                    <span>Agricultural Certification</span>
                </a>

                <a href="{{ route('dashboard.barangay-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.barangay-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="award" class="w-4 h-4"></i>
                    <span>Barangay Certification</span>
                </a>

                <a href="{{ route('dashboard.business-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.business-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="briefcase" class="w-4 h-4"></i>
                    <span>Business Certification</span>
                </a>

                <a href="{{ route('dashboard.good-moral-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.good-moral-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="check-circle" class="w-4 h-4"></i>
                    <span>Certificate of Good Moral</span>
                </a>
            </div>
        </div>

        <div class="px-6 mt-4">
            <button onclick="toggleRequestUser()" class="w-full flex justify-between items-center text-left py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <div class="flex items-center gap-3">
                    <i data-feather="users" class="w-5 h-5"></i>
                    <span class="font-medium">User Management</span>
                </div>
                <i data-feather="chevron-down" id="requestIcongg" class="w-4 h-4 transition-transform duration-300 {{ $usersOpen ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="requestMenuNice" class="ml-8 mt-2 space-y-1 overflow-hidden transition-all duration-300 {{ $usersOpen ? 'max-h-60' : 'max-h-0' }}">
                <a href="{{ route('dashboard-residents.residents') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard-residents.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="user" class="w-4 h-4"></i>
                    <span>Residents</span>
                </a>

                <a href="{{ route('add-user.portal') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('add-user.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="user-plus" class="w-4 h-4"></i>
                    <span>Add Residents</span>
                </a>

                <a href="{{ route('admin.residents-map') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('admin.residents-map') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="map" class="w-4 h-4"></i>
                    <span>Residents Map</span>
                </a>
            </div>
        </div>

        <div class="px-6 mt-4">
            <button onclick="toggleAdminMenu()" class="w-full flex justify-between items-center text-left py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <div class="flex items-center gap-3">
                    <i data-feather="settings" class="w-5 h-5"></i>
                    <span class="font-medium">Administration</span>
                </div>
                <i data-feather="chevron-down" id="adminMenuIcon" class="w-4 h-4 transition-transform duration-300"></i>
            </button>

            <div id="adminMenu" class="ml-8 mt-2 space-y-1 overflow-hidden transition-all duration-300 max-h-0">
                <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('admin.logs') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="activity" class="w-4 h-4"></i>
                    <span>Activity Logs</span>
                </a>

                <a href="{{ route('admin.create-admin') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('admin.create-admin') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="user-plus" class="w-4 h-4"></i>
                    <span>Create Admin</span>
                </a>

                <a href="{{ route('admin.admins-list') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('admin.admins-list') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="users" class="w-4 h-4"></i>
                    <span>Admin List</span>
                </a>

                <a href="{{ route('admin.archive') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('admin.archive') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="archive" class="w-4 h-4"></i>
                    <span>Archive List</span>
                </a>
            </div>
        </div>
        </div>

        <!-- Profile section at bottom -->
        <div class="flex-shrink-0 p-6 bg-gradient-to-r from-blue-50 to-blue-100 backdrop-blur-sm border-t border-blue-200">
            <div class="relative">
                <button id="sidebarProfileBtn" class="w-full flex items-center gap-3 p-3 rounded-2xl hover:bg-blue-100 transition-all duration-200 focus:outline-none">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center">
                        <i data-feather="user" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="flex-1 text-left">
                        <p class="text-sm font-medium text-blue-800">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-blue-600">Admin</p>
                    </div>
                    <i data-feather="chevron-up" class="w-4 h-4 text-blue-600"></i>
                </button>

                <div id="sidebarProfileDropdown" class="absolute bottom-full left-0 right-0 mb-2 bg-white border border-blue-200 rounded-2xl shadow-lg py-2 hidden">
                    <a href="{{ route('welcome-portal') }}" class="flex items-center gap-3 px-4 py-2 text-blue-700 hover:bg-blue-50 transition-colors">
                        <i data-feather="log-out" class="w-4 h-4"></i>
                        <span class="text-sm">Logout</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Main content -->
    <main class="flex-1 lg:ml-72 ml-0">
        <!-- Header -->
        <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 shadow-sm p-6 mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button id="mobileMenuBtn" class="lg:hidden bg-gradient-to-r from-blue-600 to-blue-700 text-white p-2 rounded-xl shadow-lg">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
                <h1 class="text-2xl lg:text-3xl font-bold text-blue-800 tracking-tight">Barangay Bagacay Management System</h1>
            </div>

            <div class="flex items-center gap-2 text-blue-700">
                <i data-feather="calendar" class="w-5 h-5"></i>
                <p class="text-sm font-semibold" id="philippineTime"></p>
            </div>
        </header>

        <script>
            feather.replace();
            
            // Philippine Time Display
            function updatePhilippineTime() {
                const now = new Date();
                const philippineTime = new Intl.DateTimeFormat('en-PH', {
                    timeZone: 'Asia/Manila',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }).format(now);
                document.getElementById('philippineTime').textContent = philippineTime;
            }
            
            updatePhilippineTime();
            setInterval(updatePhilippineTime, 1000);
            
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');

            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 &&
                    !sidebar.contains(e.target) &&
                    !mobileMenuBtn.contains(e.target) &&
                    !e.target.closest('button[onclick]')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Get sidebar profile elements
            const sidebarProfileBtn = document.getElementById('sidebarProfileBtn');
            const sidebarProfileDropdown = document.getElementById('sidebarProfileDropdown');

            // Toggle sidebar profile dropdown
            if (sidebarProfileBtn) {
                sidebarProfileBtn.addEventListener('click', () => {
                    sidebarProfileDropdown.classList.toggle('hidden');
                });
            }

            // Close sidebar profile dropdown when clicking outside
            window.addEventListener('click', function(e) {
                if (sidebarProfileBtn && !sidebarProfileBtn.contains(e.target) && !sidebarProfileDropdown.contains(e.target)) {
                    sidebarProfileDropdown.classList.add('hidden');
                }
            });

            function toggleRequest() {
                const menu = document.getElementById('requestMenu');
                const icon = document.getElementById('requestIcon');

                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-96');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-96');
                    icon.classList.remove('rotate-180');
                }
            }

            function toggleRequestUser() {
                const menu = document.getElementById('requestMenuNice');
                const icon = document.getElementById('requestIcongg');

                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-60');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-60');
                    icon.classList.remove('rotate-180');
                }
            }

            function toggleAdminMenu() {
                const menu = document.getElementById('adminMenu');
                const icon = document.getElementById('adminMenuIcon');

                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-40');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-60');
                    icon.classList.remove('rotate-180');
                }
            }
        </script>

        @yield('content')

    </main>

</body>
</html>
