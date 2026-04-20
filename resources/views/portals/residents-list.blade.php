@extends('home.admin')

@section('title', 'Residents List')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Residents List</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- SEARCH & FILTER -->
    <div class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4 items-center">

        <!-- Search -->
        <input
            type="text"
            id="searchInput"
            placeholder="Search name or email..."
            class="border rounded px-4 py-2 w-64"
            onkeyup="filterTable()"
        >
        <span id="recordCount" class="text-sm text-gray-500"></span>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded shadow overflow-x-auto">

        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-8">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Age</th>
                    <th class="px-4 py-3 text-left">Civil Status</th>
                    <th class="px-4 py-3 text-left">Purok</th>
                    <th class="px-4 py-3 text-center min-w-[290px]">Actions</th>
                </tr>
            </thead>

            <tbody id="residentsTable" class="text-gray-800">

                @forelse ($residents as $index => $resident)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-400 text-sm w-8">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $resident->name }}</td>
                        <td class="px-4 py-2">{{ $resident->email }}</td>
                        <td class="px-4 py-2">{{ $resident->age }}</td>
                        <td class="px-4 py-2">{{ $resident->civil_status }}</td>
                        <td class="px-4 py-2">{{ $resident->purok }}</td>
                        <td class="px-4 py-3 text-center align-middle min-w-[330px]">
                            <div class="grid grid-cols-3 gap-2 items-stretch">
                                <button onclick='showResidentDetails(@json($resident))' class="inline-flex h-10 w-full items-center justify-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold leading-none text-blue-700 transition hover:bg-blue-100 sm:text-sm">
                                    View
                                </button>
                                <button onclick='openEditResidentModal(@json($resident))' class="inline-flex h-10 w-full items-center justify-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold leading-none text-amber-700 transition hover:bg-amber-100 sm:text-sm">
                                    Edit Details
                                </button>
                                <form action="{{ route('admin.residents.delete', $resident->user_id) }}" method="POST" onsubmit="return confirm('Delete this resident? This action cannot be undone.');" class="m-0 w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-10 w-full items-center justify-center rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold leading-none text-red-700 transition hover:bg-red-100 sm:text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No residents found.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
</div>
</div>

<!-- RESIDENT DETAILS MODAL -->
<div id="residentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Resident Details</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">User ID</label>
                    <p id="modalUserId" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Name</label>
                    <p id="modalName" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p id="modalEmail" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Contact Number</label>
                    <p id="modalContactNumber" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Age</label>
                    <p id="modalAge" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Civil Status</label>
                    <p id="modalCivilStatus" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Purok</label>
                    <p id="modalPurok" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Barangay</label>
                    <p id="modalBarangay" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">City</label>
                    <p id="modalCity" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Indigent Status</label>
                    <p id="modalIndigent" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">ID Type</label>
                    <p id="modalIdType" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Building No.</label>
                    <p id="modalBuildingNo" class="text-gray-800 mt-1"></p>
                </div>
                <div class="col-span-2">
                    <label class="text-sm font-medium text-gray-600">Full Address</label>
                    <p id="modalFullAddress" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Latitude</label>
                    <p id="modalLatitude" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Longitude</label>
                    <p id="modalLongitude" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Purpose</label>
                    <p id="modalPurpose" class="text-gray-800 mt-1"></p>
                </div>
                <div class="col-span-2">
                    <label class="text-sm font-medium text-gray-600">Date Registered</label>
                    <p id="modalDateIssued" class="text-gray-800 mt-1"></p>
                </div>
                <div class="col-span-2">
                    <label class="text-sm font-medium text-gray-600">Resident ID File</label>
                    <div class="mt-2">
                        <img id="modalIdFileImage" src="" alt="Resident ID" class="hidden mt-2 max-h-48 rounded-lg border border-gray-200 object-contain">
                        <iframe id="modalIdFileFrame" src="" class="hidden mt-2 h-72 w-full rounded-lg border border-gray-200" title="Resident ID Preview"></iframe>
                        <p id="modalIdFileNone" class="text-gray-500 text-sm">No ID file uploaded.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 border-t flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                Close
            </button>
        </div>
    </div>
</div>

<!-- EDIT RESIDENT MODAL -->
<div id="editResidentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-5xl w-full mx-4 max-h-[92vh] overflow-y-auto">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Edit Resident Details</h3>
                <button onclick="closeEditResidentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <form id="editResidentForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" id="edit_name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                    <input type="text" name="contact_number" id="edit_contact_number" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password (Optional)</label>
                    <input type="password" name="password" id="edit_password" class="w-full border rounded px-3 py-2" placeholder="Leave blank to keep current password">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                    <input type="number" name="age" id="edit_age" class="w-full border rounded px-3 py-2" min="0" max="150">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status</label>
                    <select name="civil_status" id="edit_civil_status" class="w-full border rounded px-3 py-2" required>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Type</label>
                    <select name="id_type" id="edit_id_type" class="w-full border rounded px-3 py-2" required>
                        <option value="Barangay ID">Barangay ID</option>
                        <option value="Senior Citizen ID">Senior Citizen ID</option>
                        <option value="UMID">UMID</option>
                        <option value="Voter's ID">Voter's ID</option>
                        <option value="PhilHealth ID">PhilHealth ID</option>
                        <option value="Driver's License">Driver's License</option>
                        <option value="Passport">Passport</option>
                        <option value="Other Government ID">Other Government ID</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Resident ID File (Optional)</label>
                    <input type="file" name="resident_id_file" id="edit_resident_id_file" accept=".jpg,.jpeg,.png,.webp,.avif,.heic,.heif,.pdf,image/*,application/pdf" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purok</label>
                    <select name="purok" id="edit_purok" class="w-full border rounded px-3 py-2" onchange="updateEditFullAddress()" required>
                        @foreach(config('puroks') as $name => $coords)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Building No.</label>
                    <input type="text" name="building_no" id="edit_building_no" class="w-full border rounded px-3 py-2" oninput="updateEditFullAddress()" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barangay</label>
                    <input type="text" name="barangay" id="edit_barangay" class="w-full border rounded px-3 py-2" oninput="updateEditFullAddress()" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" id="edit_city" class="w-full border rounded px-3 py-2" oninput="updateEditFullAddress()" required>
                </div>

                <div class="md:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Address Preview</label>
                    <input type="text" id="edit_full_address" class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="text" name="latitude" id="edit_latitude" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="text" name="longitude" id="edit_longitude" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cash Assistance Program</label>
                    <select name="cash_assistance_programs" id="edit_cash_assistance_programs" class="w-full border rounded px-3 py-2" required>
                        <option value="Pantawid Pamilyang Pilipino Program (4Ps)">Pantawid Pamilyang Pilipino Program (4Ps)</option>
                        <option value="Assistance to Individuals in Crisis Situations (AICS)">Assistance to Individuals in Crisis Situations (AICS)</option>
                        <option value="Sustainable Livelihood Program (SLP)">Sustainable Livelihood Program (SLP)</option>
                        <option value="Targeted Cash Transfers (TCT)">Targeted Cash Transfers (TCT)</option>
                        <option value="N/A">N/A</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                    <input type="text" name="purpose" id="edit_purpose" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Issued</label>
                    <input type="date" name="date_issued" id="edit_date_issued" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t pt-4">
                <button type="button" onclick="closeEditResidentModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SIMPLE SEARCH SCRIPT -->
<script>
const updateResidentRouteTemplate = "{{ route('admin.residents.update', ['id' => '__ID__']) }}";
const residentIdFileRouteTemplate = "{{ route('admin.residents.id-file', ['id' => '__ID__']) }}";

function buildResidentIdFileUrl(residentId) {
    if (!residentId) {
        return '';
    }

    return residentIdFileRouteTemplate.replace('__ID__', residentId);
}

function showResidentDetails(resident) {
    document.getElementById('modalUserId').textContent = resident.user_id || 'N/A';
    document.getElementById('modalName').textContent = resident.name || 'N/A';
    document.getElementById('modalEmail').textContent = resident.email || 'N/A';
    document.getElementById('modalContactNumber').textContent = resident.contact_number || 'N/A';
    document.getElementById('modalAge').textContent = resident.age || 'N/A';
    document.getElementById('modalCivilStatus').textContent = resident.civil_status || 'N/A';
    document.getElementById('modalPurok').textContent = resident.purok || 'N/A';
    document.getElementById('modalBarangay').textContent = resident.barangay || 'N/A';
    document.getElementById('modalCity').textContent = resident.city || 'N/A';
    document.getElementById('modalIndigent').textContent = resident.is_indigent || 'N/A';
    document.getElementById('modalIdType').textContent = resident.id_type || 'N/A';
    document.getElementById('modalBuildingNo').textContent = resident.building_no || 'N/A';
    document.getElementById('modalFullAddress').textContent = resident.full_address || 'N/A';
    document.getElementById('modalLatitude').textContent = resident.latitude || 'N/A';
    document.getElementById('modalLongitude').textContent = resident.longitude || 'N/A';
    document.getElementById('modalPurpose').textContent = resident.purpose || 'N/A';
    document.getElementById('modalDateIssued').textContent = resident.date_issued || 'N/A';

    const idFileImage = document.getElementById('modalIdFileImage');
    const idFileFrame = document.getElementById('modalIdFileFrame');
    const idFileNone = document.getElementById('modalIdFileNone');
    const idFilePath = resident.resident_id_file || '';
    const normalizedIdFilePath = String(idFilePath).toLowerCase();
    const isPdfFile = normalizedIdFilePath.endsWith('.pdf');

    if (idFilePath) {
        const fileUrl = buildResidentIdFileUrl(resident.user_id);
        idFileNone.classList.add('hidden');
        idFileImage.src = '';
        idFileImage.classList.add('hidden');
        idFileImage.onerror = null;
        idFileImage.onload = null;
        idFileFrame.src = '';
        idFileFrame.classList.add('hidden');

        if (isPdfFile) {
            idFileFrame.src = fileUrl;
            idFileFrame.classList.remove('hidden');
        } else {
            idFileImage.onerror = function() {
                idFileImage.classList.add('hidden');
                idFileFrame.src = fileUrl;
                idFileFrame.classList.remove('hidden');
            };

            idFileImage.onload = function() {
                idFileImage.classList.remove('hidden');
                idFileFrame.src = '';
                idFileFrame.classList.add('hidden');
            };

            idFileImage.src = fileUrl;
            idFileImage.classList.remove('hidden');
        }
    } else {
        idFileImage.src = '';
        idFileImage.classList.add('hidden');
        idFileImage.onerror = null;
        idFileImage.onload = null;
        idFileFrame.src = '';
        idFileFrame.classList.add('hidden');
        idFileNone.classList.remove('hidden');
    }

    document.getElementById('residentModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('residentModal').classList.add('hidden');
}

function formatDateForInput(dateValue) {
    if (!dateValue) {
        return '';
    }

    if (/^\d{4}-\d{2}-\d{2}$/.test(dateValue)) {
        return dateValue;
    }

    const parsedDate = new Date(dateValue);
    if (isNaN(parsedDate.getTime())) {
        return '';
    }

    const year = parsedDate.getFullYear();
    const month = String(parsedDate.getMonth() + 1).padStart(2, '0');
    const day = String(parsedDate.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function updateEditFullAddress() {
    const buildingNo = document.getElementById('edit_building_no').value.trim();
    const purok = document.getElementById('edit_purok').value;
    const barangay = document.getElementById('edit_barangay').value.trim();
    const city = document.getElementById('edit_city').value.trim();

    const parts = [buildingNo, purok, barangay, city].filter(Boolean);
    document.getElementById('edit_full_address').value = parts.join(', ');
}

function openEditResidentModal(resident) {
    const editForm = document.getElementById('editResidentForm');
    editForm.action = updateResidentRouteTemplate.replace('__ID__', resident.user_id);

    document.getElementById('edit_name').value = resident.name || '';
    document.getElementById('edit_email').value = resident.email || '';
    document.getElementById('edit_contact_number').value = resident.contact_number || '';
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_age').value = resident.age || '';
    document.getElementById('edit_civil_status').value = resident.civil_status || 'Single';
    document.getElementById('edit_id_type').value = resident.id_type || 'Barangay ID';
    document.getElementById('edit_purok').value = resident.purok || '';
    document.getElementById('edit_building_no').value = resident.building_no || '';
    document.getElementById('edit_barangay').value = resident.barangay || 'Bagacay';
    document.getElementById('edit_city').value = resident.city || 'Dumaguete City';
    document.getElementById('edit_latitude').value = resident.latitude || '';
    document.getElementById('edit_longitude').value = resident.longitude || '';
    document.getElementById('edit_cash_assistance_programs').value = resident.is_indigent || 'N/A';
    document.getElementById('edit_purpose').value = resident.purpose || '';
    document.getElementById('edit_date_issued').value = formatDateForInput(resident.date_issued);

    updateEditFullAddress();
    document.getElementById('editResidentModal').classList.remove('hidden');
}

function closeEditResidentModal() {
    document.getElementById('editResidentModal').classList.add('hidden');
}

function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#residentsTable tr');
    let count = 0;

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const matchesSearch = text.includes(search);
        row.style.display = matchesSearch ? '' : 'none';
        if (matchesSearch) count++;
    });

    document.getElementById('recordCount').textContent = `Showing ${count} record(s)`;
}

document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('#residentsTable tr');
    document.getElementById('recordCount').textContent = `Showing ${rows.length} record(s)`;
});
</script>

@endsection
