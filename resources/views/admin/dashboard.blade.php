@extends('home.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6 space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-3xl p-8 text-white shadow-2xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 text-lg">Here's what's happening in Barangay Bagacay today</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center">
                    <i data-feather="activity" class="w-12 h-12 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Residents</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalUsers) }}</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i data-feather="trending-up" class="w-4 h-4 inline mr-1"></i>
                        +{{ $monthlyUsers }} this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i data-feather="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Requests -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Document Requests</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalRequests) }}</p>
                    <p class="text-blue-600 text-sm mt-2">
                        <i data-feather="file-text" class="w-4 h-4 inline mr-1"></i>
                        +{{ $monthlyRequests }} this month
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i data-feather="file-text" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending Requests</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($pendingRequests) }}</p>
                    <p class="text-orange-600 text-sm mt-2">
                        <i data-feather="clock" class="w-4 h-4 inline mr-1"></i>
                        Needs attention
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <i data-feather="clock" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Events</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($totalEvents) }}</p>
                    <p class="text-purple-600 text-sm mt-2">
                        <i data-feather="calendar" class="w-4 h-4 inline mr-1"></i>
                        Community events
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i data-feather="calendar" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Request Status Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Request Status Overview</h3>
            <div class="space-y-4">
                <!-- Approved -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 font-medium">Approved</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-900 font-bold mr-2">{{ $approvedRequests }}</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalRequests > 0 ? ($approvedRequests / $totalRequests) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 font-medium">Pending</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-900 font-bold mr-2">{{ $pendingRequests }}</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $totalRequests > 0 ? ($pendingRequests / $totalRequests) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Rejected -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-gray-700 font-medium">Rejected</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-900 font-bold mr-2">{{ $rejectedRequests }}</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalRequests > 0 ? ($rejectedRequests / $totalRequests) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Types -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Popular Document Types</h3>
            <div class="space-y-3">
                @forelse($documentTypes->take(5) as $type)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <span class="text-gray-700 font-medium">{{ $type->doc_type ?: 'Unknown Document' }}</span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $type->count }}</span>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i data-feather="file-x" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                    <p>No document requests yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Purok Distribution and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Purok Distribution -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Residents by Purok</h3>
            <div class="space-y-3">
                @forelse($purokDistribution as $purok)
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl cursor-pointer hover:from-blue-100 hover:to-blue-200 transition-all"
                     onclick="showPurokDetail('{{ addslashes($purok->purok) }}', {{ $purok->count }})">  
                    <div class="flex items-center">
                        <i data-feather="map-pin" class="w-4 h-4 text-blue-600 mr-2"></i>
                        <span class="text-gray-700 font-medium">{{ $purok->purok ?: 'Unknown Purok' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">{{ $purok->count }}</span>
                        <i data-feather="chevron-right" class="w-4 h-4 text-blue-400"></i>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i data-feather="map" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                    <p>No purok data available</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Residents with Cash Assistance -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Cash Assistance</h3>
                <div class="flex gap-2 items-center">
                    <span id="assistanceCount" class="text-xs text-gray-500"></span>
                    <select id="purokFilter" class="px-2 py-1 text-xs border border-gray-300 rounded-lg">
                        <option value="">All Puroks</option>
                        @foreach($purokDistribution as $purok)
                            <option value="{{ $purok->purok }}">{{ $purok->purok }}</option>
                        @endforeach
                    </select>
                    <select id="assistanceFilter" class="px-2 py-1 text-xs border border-gray-300 rounded-lg">
                        <option value="">All Types</option>
                        <option value="4Ps">4Ps</option>
                        <option value="AICS">AICS</option>
                        <option value="DSWD">DSWD</option>
                        <option value="Senior">Senior</option>
                        <option value="PWD">PWD</option>
                    </select>
                </div>
            </div>
            <div id="assistanceList" class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($residentsWithAssistance as $index => $resident)
                <div class="resident-item flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-xl" 
                     data-purok="{{ $resident->purok }}" 
                     data-assistance="{{ $resident->is_indigent }}">
                    <div>
                        <p class="text-gray-900 font-medium text-sm"><span class="text-gray-400 mr-1">{{ $index + 1 }}.</span>{{ $resident->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $resident->purok }}</p>
                    </div>
                    <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs font-semibold">{{ $resident->is_indigent }}</span>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i data-feather="users" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                    <p>No residents with cash assistance</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

<!-- Purok Detail Modal -->
<div id="purokModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 id="modalPurokName" class="text-xl font-bold text-gray-900"></h3>
                <p class="text-sm text-gray-500 mt-1">Total Members: <span id="modalTotalCount" class="font-bold text-blue-600 text-base"></span></p>
            </div>
            <button onclick="closePurokModal()" class="text-gray-400 hover:text-gray-600">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div id="modalAssistanceList" class="space-y-3 max-h-72 overflow-y-auto">
        </div>
        <p id="modalNoAssistance" class="text-center text-gray-400 text-sm py-4 hidden">No assistance program members in this purok.</p>
    </div>
</div>
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Recent Document Requests</h3>
            <div class="space-y-3">
                @forelse($recentRequests as $request)
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                    <div>
                        <p class="font-medium text-gray-900">{{ $request->resident->name ?? 'Unknown User' }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit(explode(' - ', $request->purpose)[0] ?? $request->purpose, 30) }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($request->status === 'approved') bg-green-100 text-green-800
                            @elseif($request->status === 'rejected') bg-red-100 text-red-800
                            @else bg-orange-100 text-orange-800 @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $request->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i data-feather="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                    <p>No recent requests</p>
                </div>
                @endforelse
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('dashboard.document-requests') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    View all requests →
                </a>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6">System Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                <i data-feather="server" class="w-8 h-8 text-blue-600 mx-auto mb-2"></i>
                <p class="text-sm text-gray-600">System Status</p>
                <p class="font-bold text-green-600">Online</p>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                <i data-feather="database" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="text-sm text-gray-600">Database</p>
                <p class="font-bold text-green-600">Connected</p>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                <i data-feather="shield" class="w-8 h-8 text-purple-600 mx-auto mb-2"></i>
                <p class="text-sm text-gray-600">Security</p>
                <p class="font-bold text-green-600">Secure</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('dashboard.document-requests') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors group">
                <i data-feather="file-text" class="w-8 h-8 text-blue-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-blue-800">View Requests</span>
            </a>
            <a href="{{ route('dashboard-residents.residents') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-colors group">
                <i data-feather="users" class="w-8 h-8 text-green-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-green-800">Manage Residents</span>
            </a>
            <a href="{{ route('add-user.portal') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition-colors group">
                <i data-feather="user-plus" class="w-8 h-8 text-purple-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-purple-800">Add Resident</span>
            </a>
            <a href="{{ route('dashboard.portal') }}" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition-colors group">
                <i data-feather="file" class="w-8 h-8 text-orange-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <span class="text-sm font-medium text-orange-800">Create Document</span>
            </a>
        </div>
    </div>
</div>

<script>
    // Initialize Feather icons
    feather.replace();

    const assistanceByPurok = @json($assistanceByPurok);

    const programColors = {
        'Pantawid Pamilyang Pilipino Program (4Ps)': 'bg-red-100 text-red-700',
        'Targeted Cash Transfers (TCT)': 'bg-blue-100 text-blue-700',
        'Sustainable Livelihood Program (SLP)': 'bg-orange-100 text-orange-700',
        'Assistance to Individuals in Crisis Situations (AICS)': 'bg-yellow-100 text-yellow-700',
    };

    function showPurokDetail(purokName, totalCount) {
        document.getElementById('modalPurokName').textContent = purokName;
        document.getElementById('modalTotalCount').textContent = totalCount;

        const list = document.getElementById('modalAssistanceList');
        const noAssistance = document.getElementById('modalNoAssistance');
        list.innerHTML = '';

        const programs = assistanceByPurok[purokName];
        if (programs && programs.length > 0) {
            noAssistance.classList.add('hidden');
            programs.forEach(p => {
                const colorClass = programColors[p.is_indigent] || 'bg-gray-100 text-gray-700';
                list.innerHTML += `
                    <div class="flex items-center justify-between p-3 rounded-xl ${colorClass}">
                        <span class="font-medium text-sm">${p.is_indigent}</span>
                        <span class="font-bold text-sm">${p.count} member${p.count > 1 ? 's' : ''}</span>
                    </div>`;
            });
        } else {
            noAssistance.classList.remove('hidden');
        }

        document.getElementById('purokModal').classList.remove('hidden');
        feather.replace();
    }

    function closePurokModal() {
        document.getElementById('purokModal').classList.add('hidden');
    }

    document.getElementById('purokModal').addEventListener('click', function(e) {
        if (e.target === this) closePurokModal();
    });
    
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const purokFilter = document.getElementById('purokFilter');
        const assistanceFilter = document.getElementById('assistanceFilter');
        
        function applyFilters() {
            const purok = purokFilter.value.toLowerCase();
            const assistance = assistanceFilter.value.toLowerCase();
            const items = document.querySelectorAll('.resident-item');
            let count = 0;
            
            items.forEach(item => {
                const itemPurok = item.dataset.purok.toLowerCase();
                const itemAssistance = item.dataset.assistance.toLowerCase();
                const purokMatch = !purok || itemPurok.includes(purok);
                const assistanceMatch = !assistance || itemAssistance.includes(assistance);
                const visible = purokMatch && assistanceMatch;
                item.style.display = visible ? 'flex' : 'none';
                if (visible) count++;
            });

            document.getElementById('assistanceCount').textContent = `${count} record(s)`;
        }
        
        purokFilter.addEventListener('change', applyFilters);
        assistanceFilter.addEventListener('change', applyFilters);
        
        // Animate cards on load
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection