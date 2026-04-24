@extends('home.admin')

@section('title', 'Archive List')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Archive List</h2>
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
        <input
            type="text"
            id="searchInput"
            placeholder="Search name, email or role..."
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
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Archived At</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody id="archiveTable" class="text-gray-800">
                @forelse ($archivedUsers as $index => $user)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-400 text-sm w-8">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            @if($user->role == 'admin')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">Admin</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Resident</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-500">{{ $user->updated_at->format('M d, Y h:i A') }}</td>
                        <td class="px-4 py-3 text-center align-middle">
                            <form action="{{ route('admin.users.restore', $user->user_id) }}" method="POST" onsubmit="return confirm('Restore this user?');" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center rounded-full border border-blue-200 bg-blue-50 px-4 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                    Restore
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No archived users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#archiveTable tr');
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
    const rows = document.querySelectorAll('#archiveTable tr:not(:has(td[colspan]))');
    document.getElementById('recordCount').textContent = `Showing ${rows.length} record(s)`;
});
</script>

@endsection
