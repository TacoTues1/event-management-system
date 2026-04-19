<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events - Barangay Bagacay</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <i data-feather="arrow-left" class="w-4 h-4"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                    <i data-feather="calendar" class="w-6 h-6 text-green-600"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Upcoming Cash Assistance Events</h1>
                    <p class="text-gray-600">View event locations and details</p>
                </div>
            </div>

            <!-- Map View -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Event Locations Map</h2>
                <div id="eventsMap" class="w-full h-96 bg-gray-200 rounded-xl"></div>
            </div>

            <!-- Events List -->
            <div class="space-y-4">
                @forelse($events as $event)
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">{{ $event->event_type }}</span>
                                <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
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
                        @if($event->latitude && $event->longitude)
                        <button onclick="focusOnEvent({{ $event->latitude }}, {{ $event->longitude }}, '{{ $event->title }}')" 
                                class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            <i data-feather="navigation" class="w-4 h-4 inline mr-1"></i>
                            View on Map
                        </button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <i data-feather="calendar" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Upcoming Events</h3>
                    <p class="text-gray-500">Check back later for new cash assistance events</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        feather.replace();
        
        let eventsMap, markers = [];
        
        function initEventsMap() {
            const bagacay = [9.300, 123.292];
            eventsMap = L.map('eventsMap').setView(bagacay, 14);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(eventsMap);
            
            const events = @json($events);
            
            events.forEach(event => {
                if (event.latitude && event.longitude) {
                    const marker = L.marker([parseFloat(event.latitude), parseFloat(event.longitude)], {
                        icon: L.divIcon({
                            className: 'custom-marker',
                            html: `<svg width="32" height="42" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26C32 7.163 24.837 0 16 0z" 
                                          fill="#10b981" stroke="white" stroke-width="2"/>
                                    <circle cx="16" cy="16" r="6" fill="white"/>
                                   </svg>`,
                            iconSize: [32, 42],
                            iconAnchor: [16, 42],
                            popupAnchor: [0, -42]
                        })
                    }).addTo(eventsMap);
                    
                    marker.bindPopup(`
                        <div class="p-3">
                            <h3 class="font-bold text-gray-900 mb-1">${event.title}</h3>
                            <p class="text-sm text-green-600 font-semibold mb-2">${event.event_type}</p>
                            <p class="text-sm text-gray-600 mb-2">${event.description || ''}</p>
                            <p class="text-xs text-gray-500"><i data-feather="map-pin" class="w-3 h-3 inline"></i> ${event.location}</p>
                            <p class="text-xs text-gray-500"><i data-feather="calendar" class="w-3 h-3 inline"></i> ${new Date(event.event_date).toLocaleDateString()}</p>
                            ${event.start_time ? `<p class="text-xs text-gray-500"><i data-feather="clock" class="w-3 h-3 inline"></i> ${event.start_time}</p>` : ''}
                        </div>
                    `);
                    
                    markers.push({ marker, event });
                }
            });
            
            if (markers.length > 0) {
                const group = new L.featureGroup(markers.map(m => m.marker));
                eventsMap.fitBounds(group.getBounds().pad(0.1));
            }
        }
        
        function focusOnEvent(lat, lng, title) {
            eventsMap.setView([parseFloat(lat), parseFloat(lng)], 17);
            
            const marker = markers.find(m => 
                Math.abs(m.marker.getLatLng().lat - parseFloat(lat)) < 0.0001 && 
                Math.abs(m.marker.getLatLng().lng - parseFloat(lng)) < 0.0001
            );
            
            if (marker) {
                marker.marker.openPopup();
            }
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            initEventsMap();
            feather.replace();
        });
    </script>
</body>
</html>
