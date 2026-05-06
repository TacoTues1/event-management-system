<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Barangay Bagacay</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
      display: none;
    }
    input[type="password"]::-webkit-credentials-auto-fill-button,
    input[type="password"]::-webkit-contacts-auto-fill-button {
      visibility: hidden;
      pointer-events: none;
      position: absolute;
      right: 0;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center p-4">

  @include('partials.splash')

  <div class="bg-white/80 backdrop-blur-sm w-full max-w-6xl rounded-3xl shadow-xl border border-white/20 p-4 sm:p-6 md:p-8">

   <div class="flex flex-col items-center mb-6">
      <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-4 shadow-lg">
        <img
            src="{{ asset('images/barangay_logo.jpg') }}"
            alt="Barangay Logo"
            class="w-10 h-10 sm:w-12 sm:h-12 object-contain rounded-full"
        >
      </div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 text-center mb-2 tracking-tight">
          Create Account
      </h1>
      <p class="text-xs text-slate-500 font-light">Join Barangay Bagacay</p>
  </div>

   @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    @if(session('error'))
        <script>alert("{{ session('error') }}");</script>
    @endif

    @if($errors->any())
        <script>
            let messages = "";
            @foreach($errors->all() as $error)
                messages += "{{ $error }}\n";
            @endforeach
            alert(messages);
        </script>
    @endif


    <form action="{{ route('signup.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                <input type="text"
                    name="first_name"
                    id="first_name"
                    value="{{ old('first_name') }}"
                    placeholder="First Name"
                    pattern="^[A-Z].*"
                    maxlength="150"
                    title="First name must start with a capital letter."
                    class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200"
                    required>
            </div>
            <div>
                <label for="middle_name" class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                <input type="text"
                    name="middle_name"
                    id="middle_name"
                    value="{{ old('middle_name') }}"
                    placeholder="Middle Name"
                    pattern="^[A-Z].*"
                    maxlength="150"
                    title="Middle name must start with a capital letter."
                    class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                <input type="text"
                    name="last_name"
                    id="last_name"
                    value="{{ old('last_name') }}"
                    placeholder="Last Name"
                    pattern="^[A-Z].*"
                    maxlength="150"
                    title="Last name must start with a capital letter."
                    class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200"
                    required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div>
                <label for="suffix" class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                <input type="text" name="suffix" id="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III (optional)" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email Address" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
            <div>
                <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-2">Contact Number</label>
                <input type="tel"
                    name="contact_number"
                    id="contact_number"
                    value="{{ old('contact_number') }}"
                    placeholder="Contact Number"
                    pattern="^09\d{9}$"
                    maxlength="11"
                    inputmode="numeric"
                    autocomplete="tel"
                    title="Contact number must be in the format 09XXXXXXXXX."
                    class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200"
                    required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 pr-12 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i data-feather="eye" id="eyeIcon" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <div>
                <label for="id_type" class="block text-sm font-medium text-slate-700 mb-2">ID Type</label>
                <select name="id_type" id="id_type" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select ID Type</option>
                    <option value="National ID" @selected(old('id_type') === 'National ID')>National ID</option>
                    <option value="Barangay ID" @selected(old('id_type') === 'Barangay ID')>Barangay ID</option>
                    <option value="Senior Citizen ID" @selected(old('id_type') === 'Senior Citizen ID')>Senior Citizen ID</option>
                    <option value="UMID" @selected(old('id_type') === 'UMID')>UMID</option>
                    <option value="Voter's ID" @selected(old('id_type') === "Voter's ID")>Voter's ID</option>
                    <option value="PhilHealth ID" @selected(old('id_type') === 'PhilHealth ID')>PhilHealth ID</option>
                    <option value="Driver's License" @selected(old('id_type') === "Driver's License")>Driver's License</option>
                    <option value="Passport" @selected(old('id_type') === 'Passport')>Passport</option>
                    <option value="Other Government ID" @selected(old('id_type') === 'Other Government ID')>Other Government ID</option>
                </select>
            </div>
            <div>
                <label for="resident_id_file" class="block text-sm font-medium text-slate-700 mb-2">Resident ID File</label>
                <input type="file" name="resident_id_file" id="resident_id_file" accept=".jpg,.jpeg,.png,.webp,.avif,.heic,.heif,.pdf,image/*,application/pdf" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-2.5 text-slate-700 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-white hover:file:bg-blue-700" required>
                <p class="text-xs text-slate-500 mt-2">Accepted files: JPG, JPEG, PNG, WEBP, AVIF, HEIC, HEIF, PDF. Max size: 10MB.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div>
                <label for="birthdate" class="block text-sm font-medium text-slate-700 mb-2">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
            <div>
                <label for="civil_status" class="block text-sm font-medium text-slate-700 mb-2">Civil Status</label>
                <select name="civil_status" id="civil_status" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Civil Status</option>
                    <option value="Single" @selected(old('civil_status') === 'Single')>Single</option>
                    <option value="Married" @selected(old('civil_status') === 'Married')>Married</option>
                    <option value="Divorced" @selected(old('civil_status') === 'Divorced')>Divorced</option>
                    <option value="Widowed" @selected(old('civil_status') === 'Widowed')>Widowed</option>
                </select>
            </div>
            <div>
                <label for="purok" class="block text-sm font-medium text-slate-700 mb-2">Purok</label>
                <select name="purok" id="purok" onchange="updateMapByPurok(); updateFullAddressPreview();" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Purok</option>
                    @foreach(config('puroks') as $name => $coords)
                    <option value="{{ $name }}" @selected(old('purok') === $name)>{{ $name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-2">Used as the street/location reference within Barangay Bagacay.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div>
                <label for="building_no" class="block text-sm font-medium text-slate-700 mb-2">Building No.</label>
                <input type="text" name="building_no" id="building_no" value="{{ old('building_no') }}" placeholder="Enter building/house number (optional)" oninput="updateFullAddressPreview()" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200">
            </div>
            <div>
                <label for="barangay" class="block text-sm font-medium text-slate-700 mb-2">Barangay</label>
                <input type="text" name="barangay" id="barangay" value="Bagacay" readonly class="w-full bg-slate-100 border-0 rounded-2xl px-4 py-3 text-slate-500 cursor-not-allowed">
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-slate-700 mb-2">City</label>
                <input type="text" name="city" id="city" value="Dumaguete City" readonly class="w-full bg-slate-100 border-0 rounded-2xl px-4 py-3 text-slate-500 cursor-not-allowed">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="full_address" class="block text-sm font-medium text-slate-700 mb-2">Full Address Preview</label>
                <input type="text" name="full_address" id="full_address" value="{{ old('full_address') }}" readonly class="w-full bg-slate-100 border-0 rounded-2xl px-4 py-3 text-slate-700" required>
            </div>
        </div>

        <!-- Geo-tagging Section -->
        <div class="bg-blue-50/50 rounded-2xl p-4 border border-blue-100">
            <div class="flex items-center justify-between mb-3">
                <label class="block text-sm font-medium text-slate-700">Location (Geo-tagging)</label>
            </div>
            <div id="map" class="w-full h-48 bg-gray-200 rounded-xl mb-3"></div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-slate-600 mb-1">Latitude</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-slate-600">
                </div>
                <div>
                    <label class="block text-xs text-slate-600 mb-1">Longitude</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly class="w-full bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-slate-600">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="cash_assistance_programs" class="block text-sm font-medium text-slate-700 mb-2">Cash Assistance Programs</label>
                <select name="cash_assistance_programs" id="cash_assistance_programs" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Cash Assistance Program</option>
                    <option value="Pantawid Pamilyang Pilipino Program (4Ps)" @selected(old('cash_assistance_programs') === 'Pantawid Pamilyang Pilipino Program (4Ps)')>Pantawid Pamilyang Pilipino Program (4Ps)</option>
                    <option value="Walang Gutom Program (WGP)" @selected(old('cash_assistance_programs') === 'Walang Gutom Program (WGP)')>Walang Gutom Program (WGP)</option>
                    <option value="Sustainable Livelihood Program (SLP)" @selected(old('cash_assistance_programs') === 'Sustainable Livelihood Program (SLP)')>Sustainable Livelihood Program (SLP)</option>
                    <option value="Social Pension Program (SPP)" @selected(old('cash_assistance_programs') === 'Social Pension Program (SPP)')>Social Pension Program (SPP)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 text-base font-medium rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            Create Account
        </button>
        
        <a href="{{ url('/') }}" class="w-full inline-block text-center bg-slate-100 text-slate-700 py-3 text-base font-medium rounded-2xl hover:bg-slate-200 transition-all duration-200">
            Back to Login
        </a>
    </form>

    <div class="text-center mt-6">
      <div class="pt-4 border-t border-slate-100">
        <p class="text-xs text-slate-400 mb-1">Powered by</p>
        <div class="text-xs text-slate-600 font-medium">Negros Oriental State University</div>
      </div>
    </div>

  </div>

  <script>
    let map, marker;

    function ensureFixedAddressValues() {
        const barangayInput = document.getElementById('barangay');
        const cityInput = document.getElementById('city');

        if (barangayInput) {
            barangayInput.value = 'Bagacay';
        }

        if (cityInput) {
            cityInput.value = 'Dumaguete City';
        }
    }
    
    // Purok coordinates
    const purokLocations = @json(array_map(fn($c) => [$c['lat'], $c['lng']], config('puroks')));
    
    // Cash assistance program colors
    const programColors = {
        'Pantawid Pamilyang Pilipino Program (4Ps)': '#ef4444',
        'Social Pension Program (SPP)': '#3b82f6',
        'Sustainable Livelihood Program (SLP)': '#f97316',
        'Walang Gutom Program (WGP)': '#eab308'
    };
    
    // Create custom colored icon
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
    
    // Initialize Leaflet Map
    function initMap() {
        const defaultLocation = [9.300472, 123.293472]; // Barangay Bagacay
        
        map = L.map('map').setView(defaultLocation, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        marker = L.marker(defaultLocation, { 
            draggable: true,
            icon: createColoredIcon('#6b7280')
        }).addTo(map);
        
        // Update coordinates when marker is dragged
        marker.on('dragend', function() {
            const position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
        
        // Click on map to move marker
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });
        
        // Set initial coordinates
        updateCoordinates(defaultLocation[0], defaultLocation[1]);
    }
    
    // Update map based on selected purok
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
    
    // Get current location
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
    
    // Update coordinate inputs
    function updateCoordinates(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }

    function updateFullAddressPreview() {
        const buildingNo = document.getElementById('building_no').value.trim();
        const purok = document.getElementById('purok').value;
        const barangay = document.getElementById('barangay').value;
        const city = document.getElementById('city').value;

        const parts = [buildingNo, purok, barangay, city].filter(Boolean);
        document.getElementById('full_address').value = parts.join(', ');
    }

    const MAX_UPLOAD_BYTES = 900 * 1024; // Keep below common nginx default of 1MB.

    function loadImageFromFile(file) {
        return new Promise((resolve, reject) => {
            const image = new Image();
            const objectUrl = URL.createObjectURL(file);

            image.onload = () => {
                URL.revokeObjectURL(objectUrl);
                resolve(image);
            };

            image.onerror = () => {
                URL.revokeObjectURL(objectUrl);
                reject(new Error('Unable to read image file.'));
            };

            image.src = objectUrl;
        });
    }

    function canvasToBlob(canvas, quality) {
        return new Promise((resolve) => {
            canvas.toBlob((blob) => resolve(blob), 'image/jpeg', quality);
        });
    }

    async function compressImageFileForUpload(file, targetBytes) {
        const sourceImage = await loadImageFromFile(file);
        let width = sourceImage.width;
        let height = sourceImage.height;
        const maxSide = 1600;

        if (Math.max(width, height) > maxSide) {
            const scale = maxSide / Math.max(width, height);
            width = Math.round(width * scale);
            height = Math.round(height * scale);
        }

        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        if (!context) {
            throw new Error('Canvas is not supported on this browser.');
        }

        for (let attempt = 0; attempt < 6; attempt += 1) {
            canvas.width = width;
            canvas.height = height;
            context.clearRect(0, 0, width, height);
            context.drawImage(sourceImage, 0, 0, width, height);

            const quality = Math.max(0.45, 0.85 - attempt * 0.08);
            const blob = await canvasToBlob(canvas, quality);

            if (!blob) {
                throw new Error('Failed to prepare image upload.');
            }

            if (blob.size <= targetBytes || attempt === 5) {
                const safeName = (file.name || 'resident-id').replace(/\.[^.]+$/, '');
                return new File([blob], `${safeName}.jpg`, {
                    type: 'image/jpeg',
                    lastModified: Date.now(),
                });
            }

            width = Math.max(720, Math.round(width * 0.85));
            height = Math.max(720, Math.round(height * 0.85));
        }

        throw new Error('Failed to compress image to the required size.');
    }

    async function prepareResidentIdFileForSubmit() {
        const fileInput = document.getElementById('resident_id_file');
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            return true;
        }

        const selectedFile = fileInput.files[0];
        if (selectedFile.size <= MAX_UPLOAD_BYTES) {
            return true;
        }

        if (!selectedFile.type.startsWith('image/')) {
            alert('The selected file is too large for mobile upload. Please use an image under 900KB or a smaller PDF.');
            fileInput.value = '';
            return false;
        }

        try {
            const compressedFile = await compressImageFileForUpload(selectedFile, MAX_UPLOAD_BYTES);
            if (compressedFile.size > MAX_UPLOAD_BYTES) {
                alert('Image is still too large after compression. Please choose a smaller image.');
                fileInput.value = '';
                return false;
            }

            if (typeof DataTransfer === 'undefined') {
                alert('Your browser does not support automatic image compression. Please choose a smaller image.');
                fileInput.value = '';
                return false;
            }

            const transfer = new DataTransfer();
            transfer.items.add(compressedFile);
            fileInput.files = transfer.files;
            return true;
        } catch (error) {
            alert('Unable to process this image on your device. Please choose a smaller image or convert to JPG.');
            fileInput.value = '';
            return false;
        }
    }
    
    // Update marker color based on selected program
    function updateMarkerColor() {
        const programSelect = document.getElementById('cash_assistance_programs');
        const selectedProgram = programSelect.value;
        
        if (selectedProgram && programColors[selectedProgram]) {
            const color = programColors[selectedProgram];
            const position = marker.getLatLng();
            marker.setIcon(createColoredIcon(color));
        }
    }
    
    function clearFieldsWithValidationErrors() {
        const errorFields = @json(array_keys($errors->toArray()));
        if (!Array.isArray(errorFields) || errorFields.length === 0) {
            return;
        }

        errorFields.forEach((fieldName) => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (!field) {
                return;
            }

            if (field.type === 'file') {
                field.value = '';
                return;
            }

            if (field.tagName === 'SELECT') {
                field.selectedIndex = 0;
                return;
            }

            if (field.type === 'checkbox' || field.type === 'radio') {
                field.checked = false;
                return;
            }

            field.value = '';
        });
    }

    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        ensureFixedAddressValues();
        clearFieldsWithValidationErrors();
        initMap();
        updateFullAddressPreview();
        if (document.getElementById('purok').value) {
            updateMapByPurok();
        }
        
        // Add event listener to cash assistance program dropdown
        document.getElementById('cash_assistance_programs').addEventListener('change', updateMarkerColor);

        const signupForm = document.querySelector('form[action="{{ route('signup.store') }}"]');
        if (signupForm) {
            // Auto-format names (capitalize first letter while typing).
            ['first_name', 'middle_name', 'last_name'].forEach((fieldName) => {
                const input = signupForm.querySelector(`input[name="${fieldName}"]`);
                if (!input) return;

                input.addEventListener('input', () => {
                    const raw = String(input.value || '');
                    const trimmed = raw.replace(/^\s+/, '');
                    if (trimmed.length === 0) {
                        input.value = '';
                        return;
                    }

                    input.value = trimmed.charAt(0).toUpperCase() + trimmed.slice(1);
                });
            });

            // Auto-format contact number to: 09XXXXXXXXX (11 digits).
            const contactInput = signupForm.querySelector('input[name="contact_number"]');
            if (contactInput) {
                contactInput.addEventListener('input', () => {
                    let digits = String(contactInput.value || '').replace(/\D/g, '');
                    if (digits.length === 0) {
                        contactInput.value = '';
                        return;
                    }

                    if (digits.length < 2) {
                        // Keep partial input until user types the 2nd digit.
                        contactInput.value = digits;
                        return;
                    }

                    const lastNine = digits.startsWith('09') ? digits.slice(2) : digits.slice(-9);
                    const rest = lastNine.slice(0, 9);
                    contactInput.value = '09' + rest;
                });
            }

            // Also normalize any pre-filled (old/draft/restored) values on load.
            ['first_name', 'middle_name', 'last_name'].forEach((fieldName) => {
                const input = signupForm.querySelector(`input[name="${fieldName}"]`);
                if (!input) return;
                const trimmed = String(input.value || '').replace(/^\s+/, '');
                if (trimmed.length === 0) return;
                input.value = trimmed.charAt(0).toUpperCase() + trimmed.slice(1);
            });

            const contactInputOnLoad = signupForm.querySelector('input[name="contact_number"]');
            if (contactInputOnLoad) {
                let digits = String(contactInputOnLoad.value || '').replace(/\D/g, '');
                if (digits.length === 0) {
                    contactInputOnLoad.value = '';
                } else if (digits.length < 2) {
                    contactInputOnLoad.value = digits;
                } else {
                    const lastNine = digits.startsWith('09') ? digits.slice(2) : digits.slice(-9);
                    const rest = lastNine.slice(0, 9);
                    contactInputOnLoad.value = '09' + rest;
                }
            }

            signupForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                if (signupForm.dataset.submitting === '1') {
                    return;
                }

                ensureFixedAddressValues();
                updateFullAddressPreview();

                // Normalize contact number digits-only + capitalize name first letters
                // so browser validation patterns pass even with user-entered casing/format.
                const contactInput = signupForm.querySelector('input[name="contact_number"]');
                if (contactInput) {
                    contactInput.value = String(contactInput.value || '').replace(/\D/g, '');
                }

                ['first_name', 'middle_name', 'last_name'].forEach((fieldName) => {
                    const input = signupForm.querySelector(`input[name="${fieldName}"]`);
                    if (!input) return;
                    const raw = String(input.value || '').trim();
                    if (!raw) return;
                    input.value = raw.charAt(0).toUpperCase() + raw.slice(1);
                });

                // Ensure HTML5 validation runs before we proceed with compression.
                if (!signupForm.checkValidity()) {
                    signupForm.reportValidity();
                    return;
                }

                const fileReady = await prepareResidentIdFileForSubmit();
                if (!fileReady) {
                    return;
                }

                signupForm.dataset.submitting = '1';
                signupForm.submit();
            });
        }
    });

    feather.replace();
    
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.setAttribute('data-feather', 'eye-off');
      } else {
        passwordInput.type = 'password';
        eyeIcon.setAttribute('data-feather', 'eye');
      }
      feather.replace();
    }
  </script>
</body>
</html>
