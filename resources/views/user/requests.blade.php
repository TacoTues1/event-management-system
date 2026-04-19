<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Requests - Barangay Bagacay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .animate-slide-up { animation: slideUp 0.8s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        
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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative min-h-screen">
        <!-- Header -->
        <header class="glass-effect sticky top-0 z-50 animate-fade-in">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('user.dashboard') }}" class="p-2 rounded-xl hover:bg-white/50 transition-colors">
                            <i data-feather="arrow-left" class="w-5 h-5 text-gray-600"></i>
                        </a>
                        <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-12 h-12 rounded-full shadow-lg ring-4 ring-white/50">
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">My Document Requests</h1>
                            <p class="text-sm text-gray-600 font-medium">Track your application status</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600">{{ Auth::user()->purok }}</p>
                        </div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <button onclick="toggleProfileMenu()" class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center hover:scale-110 transition-transform">
                                <i data-feather="chevron-down" class="w-3 h-3 text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Dropdown -->
            <div id="profileMenu" class="absolute right-4 top-20 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 hidden animate-fade-in">
                <div class="p-4 border-b border-gray-100">
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <div class="p-2">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <i data-feather="home" class="w-4 h-4 text-blue-600"></i>
                        <span class="text-sm font-medium">Dashboard</span>
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

        </header>

        <!-- Profile Menu Script -->
        <script>
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
        </script>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if($requests->count() > 0)
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-slide-up">
                    <div class="glass-effect rounded-2xl p-6 text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i data-feather="file-text" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $requests->count() }}</p>
                        <p class="text-sm text-gray-600">Total Requests</p>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 text-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i data-feather="clock" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-orange-600">{{ $requests->where('status', 'pending')->count() }}</p>
                        <p class="text-sm text-gray-600">Pending</p>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-green-600">{{ $requests->where('status', 'approved')->count() }}</p>
                        <p class="text-sm text-gray-600">Approved</p>
                    </div>
                    <div class="glass-effect rounded-2xl p-6 text-center">
                        <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <i data-feather="x-circle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <p class="text-2xl font-bold text-red-600">{{ $requests->where('status', 'rejected')->count() }}</p>
                        <p class="text-sm text-gray-600">Rejected</p>
                    </div>
                </div>

                <!-- Requests List -->
                <div class="space-y-4 animate-slide-up" style="animation-delay: 0.2s;">
                    @foreach($requests as $index => $request)
                        <div class="glass-effect rounded-2xl p-6 card-hover" style="animation-delay: {{ $index * 0.1 }}s;">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center
                                        @if($request->status == 'approved') bg-green-100
                                        @elseif($request->status == 'rejected') bg-red-100
                                        @else bg-orange-100 @endif">
                                        @if($request->status == 'approved')
                                            <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
                                        @elseif($request->status == 'rejected')
                                            <i data-feather="x-circle" class="w-6 h-6 text-red-600"></i>
                                        @else
                                            <i data-feather="clock" class="w-6 h-6 text-orange-600"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-xs mb-1">#{{ $index + 1 }}</p>
                                        <h3 class="font-semibold text-gray-900 text-lg">
                                            {{ explode(' - ', $request->purpose)[0] ?? 'Document Request' }}
                                        </h3>
                                        <p class="text-gray-600 mt-1">
                                            {{ explode(' - ', $request->purpose, 2)[1] ?? $request->purpose }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                            <div class="flex items-center space-x-1">
                                                <i data-feather="calendar" class="w-4 h-4"></i>
                                                <span>{{ $request->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <i data-feather="clock" class="w-4 h-4"></i>
                                                <span>{{ $request->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        @if($request->status == 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                                Ready for Pickup
                                            </span>
                                        @elseif($request->status == 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i data-feather="x" class="w-3 h-3 mr-2"></i>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                                <div class="w-2 h-2 bg-orange-400 rounded-full mr-2 animate-pulse"></div>
                                                Under Review
                                            </span>
                                        @endif
                                    </div>
                                    <button onclick="viewRequestDetails({{ $request->request_id }})" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors flex items-center space-x-2">
                                        <i data-feather="eye" class="w-4 h-4"></i>
                                        <span>View Details</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="glass-effect rounded-3xl p-12 text-center animate-fade-in">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i data-feather="file-text" class="w-12 h-12 text-gray-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Document Requests Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">You haven't requested any documents yet. Start by requesting the documents you need from Barangay Bagacay.</p>
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-2xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                        <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                        Request Documents
                    </a>
                </div>
            @endif
        </main>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-3xl p-8 shadow-2xl text-center animate-fade-in">
            <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Loading...</h3>
            <p class="text-gray-600">Please wait while we fetch your request details</p>
        </div>
    </div>

    <!-- Request Details Modal -->
    <div id="requestModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-0 w-96 animate-fade-in">
            <div class="glass-effect rounded-3xl shadow-2xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Request Details</h3>
                    <button onclick="closeModal()" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                        <i data-feather="x" class="w-4 h-4 text-gray-600"></i>
                    </button>
                </div>
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
                <div class="mt-8">
                    <button onclick="closeModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-2xl font-medium transition-colors">
                        Close
                    </button>
                </div>
            </div>
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
        
        function viewRequestDetails(requestId) {
            showLoading();
            fetch(`/user/request-status/${requestId}`)
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    const statusColor = data.status === 'approved' ? 'text-green-600' : 
                                      data.status === 'rejected' ? 'text-red-600' : 'text-orange-600';
                    const statusBg = data.status === 'approved' ? 'bg-green-50 border-green-200' : 
                                   data.status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-orange-50 border-orange-200';
                    
                    document.getElementById('modalContent').innerHTML = `
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-sm font-medium text-gray-600 mb-1">Document Type</p>
                            <p class="font-semibold text-gray-900">${data.document_type}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-sm font-medium text-gray-600 mb-1">Purpose</p>
                            <p class="font-semibold text-gray-900">${data.purpose}</p>
                        </div>
                        <div class="${statusBg} border rounded-2xl p-4">
                            <p class="text-sm font-medium text-gray-600 mb-1">Status</p>
                            <p class="font-semibold ${statusColor}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-sm font-medium text-gray-600 mb-1">Request Date</p>
                            <p class="font-semibold text-gray-900">${data.request_date}</p>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-sm font-medium text-gray-600 mb-1">Last Updated</p>
                            <p class="font-semibold text-gray-900">${data.updated_at}</p>
                        </div>
                    `;
                    
                    document.getElementById('requestModal').classList.remove('hidden');
                    feather.replace();
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    alert('Error loading request details');
                });
        }
        
        function closeModal() {
            document.getElementById('requestModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('requestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Stagger animation for request cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.classList.add('animate-fade-in');
            });
        });
    </script>
</body>
</html>