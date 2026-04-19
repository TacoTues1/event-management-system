@extends('home.admin')

@section('title', 'Residents Location Map')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="p-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Residents Location Map</h2>
            <p class="text-gray-600 mt-1">View resident addresses and geo-tagged locations</p>
        </div>
        
        <div class="p-6">
            <!-- Filter Section -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Filter by Cash Assistance Program</h3>
                <div class="flex flex-wrap gap-2 mb-4">
                    <button onclick="filterByProgram('all')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-600 text-white" data-program="all">
                        All Programs
                    </button>
                    <button onclick="filterByProgram('Pantawid Pamilyang Pilipino Program (4Ps)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-red-500 hover:text-white" data-program="Pantawid Pamilyang Pilipino Program (4Ps)">
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>Pantawid (4Ps)
                        @if(($programCounts['Pantawid Pamilyang Pilipino Program (4Ps)'] ?? 0) > 0)
                        <span class="ml-1 bg-red-100 text-red-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Pantawid Pamilyang Pilipino Program (4Ps)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Targeted Cash Transfers (TCT)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white" data-program="Targeted Cash Transfers (TCT)">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-2"></span>TCT
                        @if(($programCounts['Targeted Cash Transfers (TCT)'] ?? 0) > 0)
                        <span class="ml-1 bg-blue-100 text-blue-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Targeted Cash Transfers (TCT)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Sustainable Livelihood Program (SLP)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-orange-500 hover:text-white" data-program="Sustainable Livelihood Program (SLP)">
                        <span class="inline-block w-3 h-3 rounded-full bg-orange-500 mr-2"></span>SLP
                        @if(($programCounts['Sustainable Livelihood Program (SLP)'] ?? 0) > 0)
                        <span class="ml-1 bg-orange-100 text-orange-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Sustainable Livelihood Program (SLP)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Assistance to Individuals in Crisis Situations (AICS)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-yellow-500 hover:text-white" data-program="Assistance to Individuals in Crisis Situations (AICS)">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>AICS
                        @if(($programCounts['Assistance to Individuals in Crisis Situations (AICS)'] ?? 0) > 0)
                        <span class="ml-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Assistance to Individuals in Crisis Situations (AICS)'] }}</span>
                        @endif
                    </button>
                </div>
                
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Filter by Purok</h3>
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterByPurok('all')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-indigo-600 text-white" data-purok="all">
                        All Puroks
                    </button>
                    @foreach(config('puroks') as $name => $coords)
                    <button onclick="filterByPurok('{{ $name }}')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="{{ $name }}">
                        {{ $name }}
                        @if(($purokCounts[$name] ?? 0) > 0)
                        <span class="ml-1 bg-indigo-100 text-indigo-700 text-xs font-semibold px-1.5 py-0.5 rounded-full purok-badge">{{ $purokCounts[$name] }}</span>
                        @endif
                    </button>
                    @endforeach
                </div>

                <!-- Purok Summary Bar -->
                <div id="purokSummary" class="hidden mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <i data-feather="map-pin" class="w-5 h-5 text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-500 font-medium">Selected Purok</p>
                                <p id="summaryPurokName" class="text-base font-bold text-indigo-900"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-indigo-500 font-medium">Members</p>
                            <p id="summaryMemberCount" class="text-3xl font-extrabold text-indigo-700"></p>
                        </div>
                    </div>
                    <div id="summaryProgramBreakdown" class="flex flex-wrap gap-2"></div>
                </div>
            </div>
            
            <!-- Map Container -->
            <div id="residentsMap" class="w-full h-[500px] bg-gray-200 rounded-xl mb-6 relative z-0"></div>
            
            <!-- Residents List -->
            <div id="residentCards" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($residents as $resident)
                <div class="resident-card bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors {{ $resident->latitude && $resident->longitude ? 'cursor-pointer' : '' }}" 
                     data-program="{{ $resident->is_indigent }}"
                     data-purok="{{ $resident->purok }}"
                     @if($resident->latitude && $resident->longitude)
                     onclick="focusOnResident({{ $resident->latitude }}, {{ $resident->longitude }})"
                     @endif>
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ $resident->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $resident->purok }}</p>
                            <p class="text-xs text-blue-600 mt-1">{{ $resident->is_indigent ?? 'No Program' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $resident->full_address ?? 'No address provided' }}</p>
                        </div>
                        <div class="text-right text-xs text-gray-400">
                            @if($resident->latitude && $resident->longitude)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-700 mb-1">
                                    📍 Mapped
                                </span>
                                <p>{{ $resident->latitude }}, {{ $resident->longitude }}</p>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-500">
                                    No location
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-12" id="emptyState">
                    <i data-feather="map-pin" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Geo-tagged Residents</h3>
                    <p class="text-gray-500">Residents with location data will appear here</p>
                </div>
                @endforelse
            </div>
            <div id="noFilterResults" class="col-span-2 text-center py-12 hidden">
                <i data-feather="filter" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Matching Residents</h3>
                <p class="text-gray-500">No residents match the selected filters</p>
            </div>
            
            <!-- Residents Modal -->
            <div id="residentsModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" id="modalTitle">Residents</h3>
                            <p class="text-xs text-gray-500 mt-0.5" id="modalSubtitle"></p>
                        </div>
                        <button onclick="closeResidentsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-feather="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div id="modalBody" class="divide-y divide-gray-50 max-h-80 overflow-y-auto"></div>
                </div>
            </div>

            <!-- Pagination -->
            @if($residents->hasPages())
            <div class="mt-6">
                {{ $residents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    const purokCounts = @json($purokCounts);
    const purokProgramCounts = @json($purokProgramCounts);
    const purokCoords = @json(config('puroks'));
    const allResidentsForModal = @json($allResidentsForModal);

    const programLabels = {
        'Pantawid Pamilyang Pilipino Program (4Ps)': 'Pantawid',
        'Targeted Cash Transfers (TCT)': 'TCT',
        'Sustainable Livelihood Program (SLP)': 'SLP',
        'Assistance to Individuals in Crisis Situations (AICS)': 'AICS'
    };

    let map, markers = [], purokMarkers = [];
    let currentProgramFilter = 'all';
    let currentPurokFilter = 'all';
    
    const programColors = {
        'Pantawid Pamilyang Pilipino Program (4Ps)': '#ef4444',
        'Targeted Cash Transfers (TCT)': '#3b82f6',
        'Sustainable Livelihood Program (SLP)': '#f97316',
        'Assistance to Individuals in Crisis Situations (AICS)': '#eab308'
    };

    // 4 fixed pinned puroks
    const pinnedPuroks = ['Fuente', 'Kalipay', 'Cebasca', 'Riverside'];
    
    function createColoredIcon(color) {
        return L.divIcon({
            className: 'custom-marker',
            html: `<svg width="32" height="42" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26C32 7.163 24.837 0 16 0z" 
                          fill="${color}" stroke="white" stroke-width="2"/>
                    <circle cx="16" cy="16" r="6" fill="white"/>
                   </svg>`,
            iconSize: [32, 42],
            iconAnchor: [16, 42],
            popupAnchor: [0, -42]
        });
    }

    function createPurokPinIcon(label) {
        return L.divIcon({
            className: '',
            html: `<div style="background:#4f46e5;color:#fff;font-size:11px;font-weight:700;padding:4px 8px;border-radius:8px;white-space:nowrap;box-shadow:0 2px 6px rgba(0,0,0,0.3);border:2px solid #fff">${label}</div>`,
            iconAnchor: [0, 0],
            popupAnchor: [0, -10]
        });
    }

    function getPurokPopupContent(purokName, program) {
        const counts = purokProgramCounts[purokName] || {};
        const total = purokCounts[purokName] || 0;
        const programLabel = program !== 'all' ? (programLabels[program] || program) : null;
        const programCount = program !== 'all' ? (counts[program] || 0) : null;

        let rows = '';
        if (program !== 'all') {
            rows = `<tr><td style="padding:2px 6px;color:#6b7280">${programLabel}</td><td style="padding:2px 6px;font-weight:700;color:#4f46e5">${programCount}</td></tr>`;
        } else {
            Object.entries(programLabels).forEach(([key, label]) => {
                const c = counts[key] || 0;
                if (c > 0) rows += `<tr><td style="padding:2px 6px;color:#6b7280">${label}</td><td style="padding:2px 6px;font-weight:700;color:#4f46e5">${c}</td></tr>`;
            });
        }

        return `<div style="min-width:160px">
            <div style="font-weight:700;font-size:13px;margin-bottom:6px;color:#1e1b4b">📍 Purok ${purokName}</div>
            <table style="width:100%;border-collapse:collapse">
                ${rows || '<tr><td colspan="2" style="color:#9ca3af;font-size:12px">No data</td></tr>'}
            </table>
            <div style="margin-top:6px;padding-top:6px;border-top:1px solid #e5e7eb;font-size:11px;color:#6b7280">Total members: <strong>${total}</strong></div>
        </div>`;
    }

    function updatePurokMarkers() {
        purokMarkers.forEach(({ marker, purokName }) => {
            marker.setPopupContent(getPurokPopupContent(purokName, currentProgramFilter));

            const counts = purokProgramCounts[purokName] || {};
            const count = currentProgramFilter !== 'all'
                ? (counts[currentProgramFilter] || 0)
                : (purokCounts[purokName] || 0);
            const label = currentProgramFilter !== 'all'
                ? `${purokName}: ${count}`
                : `${purokName} (${count})`;
            marker.setIcon(createPurokPinIcon(label));
        });
    }

    function initPurokPins() {
        pinnedPuroks.forEach(purokName => {
            const coords = purokCoords[purokName];
            if (!coords) return;
            const count = purokCounts[purokName] || 0;
            const marker = L.marker([coords.lat, coords.lng], {
                icon: createPurokPinIcon(`${purokName} (${count})`),
                zIndexOffset: 1000
            })
            .addTo(map)
            .bindPopup(getPurokPopupContent(purokName, 'all'));

            marker.on('click', () => filterByPurok(purokName));
            purokMarkers.push({ marker, purokName });
        });
    }
    
    function initResidentsMap() {
        const bagacay = [9.300472, 123.293472];
        
        map = L.map('residentsMap').setView(bagacay, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        const residents = @json($allResidents);
        
        residents.forEach(resident => {
            if (resident.latitude && resident.longitude) {
                const program = resident.is_indigent ?? 'Unknown';
                const color = programColors[program] || '#6b7280';
                
                const marker = L.marker([parseFloat(resident.latitude), parseFloat(resident.longitude)], {
                    icon: createColoredIcon(color)
                })
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2">
                            <h3 class="font-medium text-gray-900">${resident.name}</h3>
                            <p class="text-sm text-gray-600">${resident.purok}</p>
                            <p class="text-sm text-gray-500 mt-1">${resident.full_address || 'No address provided'}</p>
                            <p class="text-xs font-medium text-blue-600 mt-2">${program}</p>
                            <p class="text-xs text-gray-400 mt-1">Coordinates: ${resident.latitude}, ${resident.longitude}</p>
                        </div>
                    `);
                
                markers.push({ marker, resident, program, purok: resident.purok });
            }
        });
        
        if (markers.length > 0) {
            const group = new L.featureGroup(markers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }

        initPurokPins();
    }
    
    function normalizePurok(purok) {
        return purok.toLowerCase().replace(/^purok\s+/i, '').trim();
    }

    function purokMatch(stored, filter) {
        if (filter === 'all') return true;
        return normalizePurok(stored) === normalizePurok(filter);
    }

    function applyFilters() {
        const visibleMarkers = [];

        markers.forEach(({ marker, program, purok }) => {
            const programMatches = currentProgramFilter === 'all' || program === currentProgramFilter;
            const purokMatches = purokMatch(purok, currentPurokFilter);
            
            if (programMatches && purokMatches) {
                marker.addTo(map);
                visibleMarkers.push({ marker });
            } else {
                map.removeLayer(marker);
            }
        });
        
        if (visibleMarkers.length > 0) {
            const group = new L.featureGroup(visibleMarkers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Filter resident cards
        let visibleCards = 0;
        document.querySelectorAll('.resident-card').forEach(card => {
            const programMatches = currentProgramFilter === 'all' || card.dataset.program === currentProgramFilter;
            const purokMatches = purokMatch(card.dataset.purok, currentPurokFilter);
            if (programMatches && purokMatches) {
                card.style.display = '';
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('noFilterResults');
        if (noResults) noResults.classList.toggle('hidden', visibleCards > 0);

        updatePurokMarkers();
    }
    
    function filterByProgram(program) {
        currentProgramFilter = program;
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.dataset.program === program) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-gray-600', 'text-white');
            } else {
                btn.classList.remove('bg-gray-600', 'text-white', 'bg-red-500', 'bg-blue-500', 'bg-orange-500', 'bg-yellow-500');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        
        applyFilters();
        updateSummaryBar();
    }
    
    function filterByPurok(purok) {
        currentPurokFilter = purok;
        
        document.querySelectorAll('.purok-btn').forEach(btn => {
            if (btn.dataset.purok === purok) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-indigo-600', 'text-white');
                btn.querySelectorAll('.purok-badge').forEach(b => {
                    b.classList.remove('bg-indigo-100', 'text-indigo-700');
                    b.classList.add('bg-white', 'text-indigo-700');
                });
            } else {
                btn.classList.remove('bg-indigo-600', 'text-white', 'bg-indigo-500');
                btn.classList.add('bg-gray-200', 'text-gray-700');
                btn.querySelectorAll('.purok-badge').forEach(b => {
                    b.classList.remove('bg-white');
                    b.classList.add('bg-indigo-100', 'text-indigo-700');
                });
            }
        });

        updateSummaryBar();
        applyFilters();
    }

    function updateSummaryBar() {
        const summary = document.getElementById('purokSummary');
        if (currentPurokFilter === 'all') {
            summary.classList.add('hidden');
            return;
        }

        const counts = purokProgramCounts[currentPurokFilter] || {};
        const total = purokCounts[currentPurokFilter] || 0;

        // Build program breakdown badges
        let badges = '';
        const badgeColors = {
            'Pantawid Pamilyang Pilipino Program (4Ps)': 'bg-red-100 text-red-700',
            'Targeted Cash Transfers (TCT)': 'bg-blue-100 text-blue-700',
            'Sustainable Livelihood Program (SLP)': 'bg-orange-100 text-orange-700',
            'Assistance to Individuals in Crisis Situations (AICS)': 'bg-yellow-100 text-yellow-700'
        };

        if (currentProgramFilter !== 'all') {
            const label = programLabels[currentProgramFilter] || currentProgramFilter;
            const count = counts[currentProgramFilter] || 0;
            const colorClass = badgeColors[currentProgramFilter] || 'bg-gray-100 text-gray-700';
            badges = `<button onclick="openResidentsModal('${currentPurokFilter}', '${currentProgramFilter}')" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold cursor-pointer hover:opacity-75 transition-opacity ${colorClass}">${label}: ${count}</button>`;
        } else {
            Object.entries(programLabels).forEach(([key, label]) => {
                const c = counts[key] || 0;
                const colorClass = badgeColors[key] || 'bg-gray-100 text-gray-700';
                badges += `<button onclick="openResidentsModal('${currentPurokFilter}', '${key}')" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold cursor-pointer hover:opacity-75 transition-opacity ${colorClass}">${label}: ${c}</button>`;
            });
        }

        document.getElementById('summaryPurokName').textContent = currentPurokFilter;
        document.getElementById('summaryMemberCount').textContent = 
            currentProgramFilter !== 'all' ? (counts[currentProgramFilter] || 0) : total;
        document.getElementById('summaryProgramBreakdown').innerHTML = badges;
        summary.classList.remove('hidden');
        feather.replace();
    }
    
    function openResidentsModal(purokName, programKey) {
        const programLabel = programLabels[programKey] || programKey;
        const filtered = allResidentsForModal.filter(r => {
            const rPurok = r.purok ? r.purok.toLowerCase().replace(/^purok\s+/i, '').trim() : '';
            return rPurok === purokName.toLowerCase().trim() && r.is_indigent === programKey;
        });

        document.getElementById('modalTitle').textContent = `${programLabel} — Purok ${purokName}`;
        document.getElementById('modalSubtitle').textContent = `${filtered.length} resident${filtered.length !== 1 ? 's' : ''} found`;

        const body = document.getElementById('modalBody');
        body.innerHTML = filtered.length === 0
            ? `<div class="px-6 py-8 text-center text-gray-400 text-sm">No residents found.</div>`
            : filtered.map((r, i) => `
                <div class="px-6 py-3 flex items-center gap-3 hover:bg-gray-50">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold flex-shrink-0">${i + 1}</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 text-sm truncate">${r.name}</p>
                        <p class="text-xs text-gray-500 truncate">${r.full_address || 'No address'}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-400">${r.age ? r.age + ' yrs' : ''}</p>
                        <p class="text-xs text-gray-400">${r.civil_status || ''}</p>
                    </div>
                </div>
            `).join('');

        document.getElementById('residentsModal').classList.remove('hidden');
        feather.replace();
    }

    function closeResidentsModal() {
        document.getElementById('residentsModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('residentsModal').addEventListener('click', function(e) {
            if (e.target === this) closeResidentsModal();
        });
    });

    function focusOnResident(lat, lng) {
        map.setView([parseFloat(lat), parseFloat(lng)], 18);
        
        const found = markers.find(m => 
            Math.abs(m.marker.getLatLng().lat - parseFloat(lat)) < 0.0001 && 
            Math.abs(m.marker.getLatLng().lng - parseFloat(lng)) < 0.0001
        );
        
        if (found) found.marker.openPopup();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        initResidentsMap();
    });
    
    feather.replace();
</script>
@endsection