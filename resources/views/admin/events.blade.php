@extends('home.admin')

@section('title', 'Cash Assistance Events')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<div class="p-6 space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Cash Assistance Events</h2>
        
        <button onclick="openCreateModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 mb-4">
            <i data-feather="plus" class="w-4 h-4 inline mr-1"></i> Create Event
        </button>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-8">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($events as $index => $event)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $event->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $event->event_type ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $event->location }}</td>
                        <td class="px-4 py-3 text-sm">
                            <button onclick="viewEvent({{ $event->event_id }})" class="text-blue-600 hover:text-blue-800 mr-2">
                                <i data-feather="eye" class="w-4 h-4 inline"></i>
                            </button>
                            <form action="{{ route('admin.events.delete', $event->event_id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this event?')">
                                    <i data-feather="trash-2" class="w-4 h-4 inline"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No events yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Event Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Create Cash Assistance Event</h3>
        
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <ul class="text-sm text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Event Title</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                    <select name="event_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="">Select Type</option>
                        <option value="Pantawid Pamilyang Pilipino Program (4Ps)">Pantawid Pamilyang Pilipino Program (4Ps)</option>
                        <option value="Assistance to Individuals in Crisis Situations (AICS)">Assistance to Individuals in Crisis Situations (AICS)</option>
                        <option value="Targeted Cash Transfers (TCT)">Targeted Cash Transfers (TCT)</option>
                        <option value="Sustainable Livelihood Program (SLP)">Sustainable Livelihood Program (SLP)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                        <input type="date" name="event_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" name="start_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" name="end_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purok</label>
                    <select name="location" id="purokSelect" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" onchange="zoomToPurok(this.value)">
                        <option value="">Select Purok</option>
                        @foreach(config('puroks') as $name => $coords)
                        <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Set Event Location on Map</label>
                    <p class="text-xs text-gray-600 mb-2">Select a purok above, then click on the map to set the exact event location</p>
                    <div id="eventMap" class="w-full h-96 bg-gray-200 rounded-xl relative z-0"></div>
                    <p class="text-xs text-gray-500 mt-2">📌 Coordinates: <span id="coordsDisplay" class="font-semibold text-blue-600">Not set</span></p>
                </div>
                
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                
                <div class="flex gap-2 justify-end mt-6">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- View Event Modal -->
<div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 w-full max-w-2xl">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Event Details</h3>
        <div id="eventDetails"></div>
        <button onclick="closeViewModal()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Close</button>
    </div>
</div>

<script>
    feather.replace();
    
    let eventMap, eventMarker;
    let selectedLat = null;
    let selectedLng = null;
    let purokCircles = {};
    
    const purokCoordinates = @json(array_map(fn($c) => [$c['lat'], $c['lng']], config('puroks')));
    
    function drawPurokCircles() {
        Object.entries(purokCoordinates).forEach(([name, coords]) => {
            const circle = L.circle(coords, {
                radius: 80,
                color: '#6366f1',
                fillColor: '#6366f1',
                fillOpacity: 0.12,
                weight: 2,
            }).addTo(eventMap).bindTooltip(name, { permanent: false, direction: 'top' });
            purokCircles[name] = circle;
        });
    }
    
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        feather.replace();
        
        setTimeout(() => {
            if (!eventMap) {
                const bagacay = [9.300472, 123.293472];
                eventMap = L.map('eventMap').setView(bagacay, 15);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(eventMap);

                drawPurokCircles();
                
                eventMap.on('click', function(e) {
                    selectedLat = e.latlng.lat;
                    selectedLng = e.latlng.lng;
                    
                    if (eventMarker) eventMap.removeLayer(eventMarker);
                    
                    eventMarker = L.marker([selectedLat, selectedLng], {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: `<svg width="32" height="42" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26C32 7.163 24.837 0 16 0z" 
                                          fill="#ef4444" stroke="white" stroke-width="2"/>
                                    <circle cx="16" cy="16" r="6" fill="white"/>
                                   </svg>`,
                            iconSize: [32, 42],
                            iconAnchor: [16, 42]
                        })
                    }).addTo(eventMap);
                    
                    document.getElementById('latitude').value = selectedLat.toFixed(8);
                    document.getElementById('longitude').value = selectedLng.toFixed(8);
                    document.getElementById('coordsDisplay').textContent = `${selectedLat.toFixed(6)}, ${selectedLng.toFixed(6)}`;
                });
            }
            
            setTimeout(() => eventMap.invalidateSize(), 100);
        }, 100);
    }
    
    function zoomToPurok(purok) {
        if (purok && purokCoordinates[purok] && eventMap) {
            eventMap.setView(purokCoordinates[purok], 17);
            if (eventMarker) {
                eventMap.removeLayer(eventMarker);
                eventMarker = null;
            }
            // Highlight selected circle, reset others
            Object.entries(purokCircles).forEach(([name, circle]) => {
                if (name === purok) {
                    circle.setStyle({ color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.2, weight: 3 });
                } else {
                    circle.setStyle({ color: '#6366f1', fillColor: '#6366f1', fillOpacity: 0.12, weight: 2 });
                }
            });
        }
    }
    
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        if (eventMarker) {
            eventMap.removeLayer(eventMarker);
            eventMarker = null;
        }
        // Reset all circles
        Object.values(purokCircles).forEach(c => c.setStyle({ color: '#6366f1', fillColor: '#6366f1', fillOpacity: 0.12, weight: 2 }));
        document.getElementById('purokSelect').value = '';
        document.getElementById('coordsDisplay').textContent = 'Not set';
    }
    
    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }
    
    function viewEvent(id) {
        fetch(`/admin/events/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('eventDetails').innerHTML = `
                    <div class="space-y-3">
                        <p><strong>Title:</strong> ${data.title}</p>
                        <p><strong>Type:</strong> ${data.event_type || 'N/A'}</p>
                        <p><strong>Description:</strong> ${data.description || 'N/A'}</p>
                        <p><strong>Date:</strong> ${data.event_date}</p>
                        <p><strong>Start Time:</strong> ${data.start_time || 'N/A'}</p>
                        <p><strong>End Time:</strong> ${data.end_time || 'N/A'}</p>
                        <p><strong>Location:</strong> ${data.location}</p>
                        <p><strong>Coordinates:</strong> ${data.latitude || 'N/A'}, ${data.longitude || 'N/A'}</p>
                    </div>
                `;
                document.getElementById('viewModal').classList.remove('hidden');
            });
    }
</script>
@endsection
