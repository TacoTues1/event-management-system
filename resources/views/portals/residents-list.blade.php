@extends('home.admin')

@section('title', 'Residents List')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Residents List</h2>
    </div>

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
    <div class="bg-white rounded shadow overflow-hidden">

        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-8">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Age</th>
                    <th class="px-4 py-3 text-left">Civil Status</th>
                    <th class="px-4 py-3 text-left">Purok</th>
                    <th class="px-4 py-3 text-center">Actions</th>
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
                        <td class="px-4 py-2 text-center">
                            <button onclick='showResidentDetails(@json($resident))' class="text-blue-600 hover:underline text-sm">
                                View
                            </button>
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
                    <label class="text-sm font-medium text-gray-600">Name</label>
                    <p id="modalName" class="text-gray-800 mt-1"></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p id="modalEmail" class="text-gray-800 mt-1"></p>
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
                <div class="col-span-2">
                    <label class="text-sm font-medium text-gray-600">Date Registered</label>
                    <p id="modalDateIssued" class="text-gray-800 mt-1"></p>
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

<!-- SIMPLE SEARCH SCRIPT -->
<script>
function showResidentDetails(resident) {
    document.getElementById('modalName').textContent = resident.name || 'N/A';
    document.getElementById('modalEmail').textContent = resident.email || 'N/A';
    document.getElementById('modalAge').textContent = resident.age || 'N/A';
    document.getElementById('modalCivilStatus').textContent = resident.civil_status || 'N/A';
    document.getElementById('modalPurok').textContent = resident.purok || 'N/A';
    document.getElementById('modalBarangay').textContent = resident.barangay || 'N/A';
    document.getElementById('modalCity').textContent = resident.city || 'N/A';
    document.getElementById('modalIndigent').textContent = resident.is_indigent || 'N/A';
    document.getElementById('modalDateIssued').textContent = resident.date_issued || 'N/A';
    document.getElementById('residentModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('residentModal').classList.add('hidden');
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
