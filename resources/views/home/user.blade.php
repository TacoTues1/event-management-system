<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Barangay Bagacay</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .animate-slide-up { animation: slideUp 0.8s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-32 left-40 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="relative min-h-screen">
        <!-- Header -->
        <header class="glass-effect sticky top-0 z-50 animate-fade-in">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-12 h-12 rounded-full shadow-lg ring-4 ring-white/50">
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-pulse-slow"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Barangay Bagacay</h1>
                            <p class="text-sm text-gray-600 font-medium">Digital Services Portal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="hidden md:flex items-center space-x-2 bg-white/50 rounded-full px-4 py-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">Online</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                <p class="text-xs text-gray-600">{{ $user->purok }}</p>
                            </div>
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                @if($upcomingEvents->count() > 0)
                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-pulse"></div>
                                @endif
                                <button onclick="toggleProfileMenu()" class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center hover:scale-110 transition-transform">
                                    <i data-feather="chevron-down" class="w-3 h-3 text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Dropdown -->
            <div id="profileMenu" class="absolute right-4 top-20 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 hidden animate-fade-in">
                <div class="p-4 border-b border-gray-100">
                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>
                <div class="p-2">
                    <a href="{{ route('user.events') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <i data-feather="calendar" class="w-4 h-4 text-green-600"></i>
                            <span class="text-sm font-medium">Upcoming Events</span>
                        </div>
                        @if($upcomingEvents->count() > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $upcomingEvents->count() }}</span>
                        @endif
                    </a>
                    <a href="{{ route('user.requests') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <i data-feather="file-text" class="w-4 h-4 text-blue-600"></i>
                        <span class="text-sm font-medium">My Requests</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-600 transition-colors">
                            <i data-feather="log-out" class="w-4 h-4"></i>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-2xl p-4 animate-fade-in">
                    <div class="flex items-center space-x-3">
                        <i data-feather="check-circle" class="w-5 h-5 text-green-600"></i>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Welcome Hero Section -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-3xl shadow-2xl animate-slide-up">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative px-8 py-12 md:px-12 md:py-16">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 animate-fade-in">Welcome back, {{ explode(' ', $user->name)[0] }}! 👋</h2>
                        <p class="text-blue-100 text-lg mb-8 animate-fade-in" style="animation-delay: 0.2s;">Your digital gateway to Barangay Bagacay services. Request documents, track applications, and stay connected with your community.</p>
                        <div class="flex flex-wrap gap-4 animate-fade-in" style="animation-delay: 0.4s;">
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3 border border-white/30">
                                <div class="flex items-center space-x-2">
                                    <i data-feather="map-pin" class="w-4 h-4 text-white"></i>
                                    <span class="text-white font-medium">{{ $user->purok }}, {{ $user->barangay }}</span>
                                </div>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3 border border-white/30">
                                <div class="flex items-center space-x-2">
                                    <i data-feather="calendar" class="w-4 h-4 text-white"></i>
                                    <span class="text-white font-medium">{{ now()->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
                        <div class="w-full h-full bg-white rounded-full animate-pulse-slow"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.2s;">
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Requests</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $recentRequests->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <i data-feather="file-text" class="w-6 h-6 text-blue-600"></i>
                        </div>
                    </div>
                </div>
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $recentRequests->where('status', 'pending')->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                            <i data-feather="clock" class="w-6 h-6 text-orange-600"></i>
                        </div>
                    </div>
                </div>
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-green-600">{{ $recentRequests->where('status', 'approved')->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                            <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cash Assistance Events -->
            @if($upcomingEvents->count() > 0)
            <div class="glass-effect rounded-3xl p-8 animate-slide-up" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Upcoming Cash Assistance Events</h3>
                        <p class="text-gray-600">Events scheduled in your area</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                        <i data-feather="calendar" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ $event->event_type }}</span>
                                    <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $event->title }}</h4>
                                <p class="text-gray-600 text-sm mb-3">{{ $event->description }}</p>
                                <div class="flex items-center gap-4 text-sm">
                                    <div class="flex items-center gap-1 text-gray-700">
                                        <i data-feather="map-pin" class="w-4 h-4"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    @if($event->start_time)
                                    <div class="flex items-center gap-1 text-gray-700">
                                        <i data-feather="clock" class="w-4 h-4"></i>
                                        <span>{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Document Services -->
            <div class="glass-effect rounded-3xl p-8 animate-slide-up" style="animation-delay: 0.4s;">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Document Services</h3>
                    <p class="text-gray-600">Request official documents from Barangay Bagacay</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('user.request.indigency') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 card-hover border border-blue-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="file" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Certificate of Indigency</h4>
                                <p class="text-sm text-gray-600">For financial assistance</p>
                            </div>
                        </div>
                        <div class="flex items-center text-blue-600 text-sm font-medium">
                            <span>Request Now</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.request.barangay') }}" class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 card-hover border border-purple-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-purple-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="award" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Barangay Certification</h4>
                                <p class="text-sm text-gray-600">General purpose certificate</p>
                            </div>
                        </div>
                        <div class="flex items-center text-purple-600 text-sm font-medium">
                            <span>Request Now</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.request.business') }}" class="group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 card-hover border border-green-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="briefcase" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Business Permit</h4>
                                <p class="text-sm text-gray-600">For business operations</p>
                            </div>
                        </div>
                        <div class="flex items-center text-green-600 text-sm font-medium">
                            <span>Request Now</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.request.agricultural') }}" class="group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 card-hover border border-yellow-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-yellow-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="sun" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Agricultural Certificate</h4>
                                <p class="text-sm text-gray-600">For farming activities</p>
                            </div>
                        </div>
                        <div class="flex items-center text-yellow-600 text-sm font-medium">
                            <span>Request Now</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.request.good-moral') }}" class="group bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-6 card-hover border border-teal-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-teal-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="check-circle" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Good Moral Certificate</h4>
                                <p class="text-sm text-gray-600">Character reference</p>
                            </div>
                        </div>
                        <div class="flex items-center text-teal-600 text-sm font-medium">
                            <span>Request Now</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    
                    <a href="{{ route('user.requests') }}" class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 card-hover border border-gray-200">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-gray-500 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-feather="list" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">My Requests</h4>
                                <p class="text-sm text-gray-600">Track your applications</p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600 text-sm font-medium">
                            <span>View All</span>
                            <i data-feather="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl p-8 shadow-2xl text-center animate-fade-in">
            <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Loading...</h3>
            <p class="text-gray-600">Please wait while we process your request</p>
        </div>
    </div>

    <script>
        feather.replace();
        
        function showLoading() {
            document.getElementById('loadingModal').classList.remove('hidden');
        }
        
        function hideLoading() {
            document.getElementById('loadingModal').classList.add('hidden');
        }
        
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close profile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileMenu');
            const button = e.target.closest('[onclick="toggleProfileMenu()"]');
            if (!button && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
        
        // Show loading on form submissions and link clicks
        document.addEventListener('DOMContentLoaded', function() {
            // Show loading for all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    showLoading();
                });
            });
            
            // Show loading for document request links
            const docLinks = document.querySelectorAll('a[href*="request"]');
            docLinks.forEach(link => {
                link.addEventListener('click', function() {
                    showLoading();
                });
            });
            
            // Stagger animation for cards
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate-fade-in');
            });
        });
    </script>
</body>
</html>