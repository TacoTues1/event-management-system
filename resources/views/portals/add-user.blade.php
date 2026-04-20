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

    <form id="residentForm" action="{{ route('admin.store-resident') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

        <!-- ID Type -->
        <div>
            <label class="block text-sm font-medium text-gray-700">ID Type</label>
            <select name="id_type"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <option value="">Select ID Type</option>
                <option value="National ID" {{ old('id_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                <option value="Postal ID" {{ old('id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                <option value="Barangay ID" {{ old('id_type') == 'Barangay ID' ? 'selected' : '' }}>Barangay ID</option>
                <option value="Senior Citizen ID" {{ old('id_type') == 'Senior Citizen ID' ? 'selected' : '' }}>Senior Citizen ID</option>
                <option value="UMID" {{ old('id_type') == 'UMID' ? 'selected' : '' }}>UMID</option>
                <option value="Voter's ID" {{ old('id_type') == "Voter's ID" ? 'selected' : '' }}>Voter's ID</option>
                <option value="PhilHealth ID" {{ old('id_type') == 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
                <option value="Driver's License" {{ old('id_type') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                <option value="Other Government ID" {{ old('id_type') == 'Other Government ID' ? 'selected' : '' }}>Other Government ID</option>
            </select>
        </div>

        <!-- Resident ID File -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Resident ID File</label>
                 <input type="file" name="resident_id_file" accept=".jpg,.jpeg,.png,.webp,.avif,.heic,.heif,.pdf,image/*,application/pdf"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <p class="text-xs text-gray-500 mt-2">Accepted files: JPG, JPEG, PNG, WEBP, AVIF, HEIC, HEIF, PDF. Max size: 10MB.</p>
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
            <select name="purok" id="purok" onchange="updateMapByPurok(); updateFullAddressPreview();"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
                <option value="">Select Purok</option>
                @foreach(config('puroks') as $name => $coords)
                <option value="{{ $name }}" {{ old('purok') == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Building Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Building No.</label>
            <input type="text" name="building_no" id="building_no" value="{{ old('building_no') }}" oninput="updateFullAddressPreview()"
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" required>
        </div>

        <!-- Barangay (Fixed) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Barangay</label>
            <input type="text" name="barangay" id="barangay" value="Bagacay" readonly
                class="mt-1 w-full border rounded-md px-3 py-2 bg-gray-100 text-gray-500 cursor-not-allowed">
        </div>

        <!-- City (Fixed) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" name="city" id="city" value="Dumaguete City" readonly
                class="mt-1 w-full border rounded-md px-3 py-2 bg-gray-100 text-gray-500 cursor-not-allowed">
        </div>

        <!-- Full Address Preview -->
        <div class="md:col-span-2 lg:col-span-3">
            <label class="block text-sm font-medium text-gray-700">Full Address Preview</label>
            <input type="text" name="full_address" id="full_address" value="{{ old('full_address') }}" readonly
                   class="mt-1 w-full border rounded-md px-3 py-2 bg-gray-100 text-gray-700" required>
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
    const addUserDraftKey = 'admin_add_user_form_draft_v1';

    function getResidentForm() {
        return document.getElementById('residentForm');
    }

    function clearResidentFormDraft() {
        localStorage.removeItem(addUserDraftKey);
    }

    function saveResidentFormDraft() {
        const form = getResidentForm();
        if (!form) {
            return;
        }

        const draft = {};
        const fields = form.querySelectorAll('input, select, textarea');

        fields.forEach((field) => {
            if (!field.name) {
                return;
            }

            if (field.type === 'password' || field.type === 'file') {
                return;
            }

            draft[field.name] = field.value;
        });

        localStorage.setItem(addUserDraftKey, JSON.stringify(draft));
    }

    function restoreResidentFormDraft() {
        const form = getResidentForm();
        if (!form) {
            return;
        }

        const rawDraft = localStorage.getItem(addUserDraftKey);
        if (!rawDraft) {
            return;
        }

        let draft = {};

        try {
            draft = JSON.parse(rawDraft) || {};
        } catch (error) {
            clearResidentFormDraft();
            return;
        }

        Object.keys(draft).forEach((name) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (!field) {
                return;
            }

            if (field.type === 'password' || field.type === 'file') {
                return;
            }

            field.value = draft[name] ?? '';
        });
    }

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

    async function prepareResidentIdFileForSubmit(form) {
        const fileInput = form.querySelector('input[name="resident_id_file"]');
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
    
    document.addEventListener('DOMContentLoaded', function() {
        const registrationSucceeded = @json(session()->has('success'));
        if (registrationSucceeded) {
            clearResidentFormDraft();
        }

        restoreResidentFormDraft();
        ensureFixedAddressValues();
        initMap();
        updateFullAddressPreview();

        const latitudeValue = parseFloat(document.getElementById('latitude').value);
        const longitudeValue = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(latitudeValue) && !isNaN(longitudeValue)) {
            const restoredLocation = [latitudeValue, longitudeValue];
            map.setView(restoredLocation, 16);
            marker.setLatLng(restoredLocation);
            updateCoordinates(latitudeValue, longitudeValue);
        }

        if (document.getElementById('purok').value) {
            updateMapByPurok();
        }

        const residentForm = getResidentForm();
        if (residentForm) {
            residentForm.addEventListener('input', saveResidentFormDraft);
            residentForm.addEventListener('change', saveResidentFormDraft);

            residentForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                if (residentForm.dataset.submitting === '1') {
                    return;
                }

                ensureFixedAddressValues();
                updateFullAddressPreview();
                saveResidentFormDraft();

                const fileReady = await prepareResidentIdFileForSubmit(residentForm);
                if (!fileReady) {
                    return;
                }

                residentForm.dataset.submitting = '1';
                residentForm.submit();
            });
        }
    });
</script>


@endsection
