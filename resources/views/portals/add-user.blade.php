@extends('home.admin')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>



<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center mb-6">
        Register Resident
    </h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.store-resident') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @csrf

        <!-- First Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Middle Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
            <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Last Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Suffix -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Suffix</label>
            <input type="text" name="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III (optional)"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>


        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Contact Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="tel" name="contact_number" value="{{ old('contact_number') }}"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Birthdate -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Birthdate</label>
            <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Civil Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Civil Status</label>
            <select name="civil_status"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <option value="">Select status</option>
                <option {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                <option {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                <option {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                <option {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
            </select>
        </div>

        <!-- Purok -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Purok</label>
            <select name="purok" id="purok" onchange="updateMapByPurok()"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <option value="">Select Purok</option>
                @foreach(config('puroks') as $name => $coords)
                <option value="{{ $name }}" {{ old('purok') == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Full Address -->
        <div class="md:col-span-2 lg:col-span-3">
            <label class="block text-sm font-medium text-gray-700">Full Address</label>
            <textarea name="full_address" rows="3"
                      class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>{{ old('full_address') }}</textarea>
        </div>

        <!-- Geo-tagging Section -->
        <div class="md:col-span-2 lg:col-span-3 bg-blue-50 rounded-lg p-4 border border-blue-200">
            <div class="flex items-center justify-between mb-3">
                <label class="block text-sm font-medium text-gray-700">Location (Geo-tagging)</label>
                <button type="button" onclick="getCurrentLocation()" class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700">
                    Get Current Location
                </button>
            </div>
            <div id="map" class="w-full h-64 bg-gray-200 rounded-md mb-3 relative z-0"></div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Latitude</label>
                    <input type="text" name="latitude" id="latitude" readonly class="w-full bg-white border rounded-md px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Longitude</label>
                    <input type="text" name="longitude" id="longitude" readonly class="w-full bg-white border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
        </div>

        <!-- Cash Assistance Programs -->
        <div class="md:col-span-2 lg:col-span-3">
            <label class="block text-sm font-medium text-gray-700">Cash Assistance Programs</label>
            <select name="cash_assistance_programs"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <option value="">Select Cash Assistance Program</option>
                <option value="Pantawid Pamilyang Pilipino Program (4Ps)" {{ old('cash_assistance_programs') == 'Pantawid Pamilyang Pilipino Program (4Ps)' ? 'selected' : '' }}>Pantawid Pamilyang Pilipino Program (4Ps)</option>
                <option value="Assistance to Individuals in Crisis Situations (AICS)" {{ old('cash_assistance_programs') == 'Assistance to Individuals in Crisis Situations (AICS)' ? 'selected' : '' }}>Assistance to Individuals in Crisis Situations (AICS)</option>
                <option value="Sustainable Livelihood Program (SLP)" {{ old('cash_assistance_programs') == 'Sustainable Livelihood Program (SLP)' ? 'selected' : '' }}>Sustainable Livelihood Program (SLP)</option>
                <option value="Targeted Cash Transfers (TCT)" {{ old('cash_assistance_programs') == 'Targeted Cash Transfers (TCT)' ? 'selected' : '' }}>Targeted Cash Transfers (TCT)</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-4 mt-6">
            <a href="{{ url()->previous() }}"
               class="px-6 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                Cancel
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                Register Resident
            </button>
        </div>

    </form>
</div>

<script>
    let map, marker;
    
    const purokLocations = @json(array_map(fn($c) => [$c['lat'], $c['lng']], config('puroks')));
    
    function initMap() {
        const bagacay = [9.300472, 123.293472]; // Barangay Bagacay center
        
        map = L.map('map').setView(bagacay, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        marker = L.marker(bagacay, { draggable: true }).addTo(map);
        
        marker.on('dragend', function() {
            const position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
        
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });
        
        updateCoordinates(bagacay[0], bagacay[1]);
    }
    
    function updateMapByPurok() {
        const purokSelect = document.getElementById('purok');
        const selectedPurok = purokSelect.value;
        
        if (selectedPurok && purokLocations[selectedPurok]) {
            const location = purokLocations[selectedPurok];
            map.setView(location, 17);
            marker.setLatLng(location);
            updateCoordinates(location[0], location[1]);
        }
    }
    
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateCoordinates(lat, lng);
                },
                function(error) {
                    alert('Error getting location: ' + error.message);
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }
    
    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>


@endsection
