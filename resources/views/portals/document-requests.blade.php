@extends('home.admin')

@section('title', 'Document Requests')

@section('content')

<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Document Requests</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resident Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Requested</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $index => $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-400 text-sm">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                onclick="showRequestDetails({{ $request->request_id }})"
                                class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer"
                            >
                                {{ $request->resident->name }}
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ explode(' - ', $request->purpose)[0] ?? 'Document Request' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->status === 'approved') bg-green-100 text-green-800
                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="inline-flex items-center gap-3">
                            <a href="{{ route('document-request.view', $request->request_id) }}" class="inline-flex items-center leading-5 text-sm font-medium text-blue-600 hover:text-blue-900">View</a>
                            @if($request->status === 'pending')
                            <form action="{{ route('document-request.approve', $request->request_id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center leading-5 text-sm font-medium text-green-600 hover:text-green-900">Approve</button>
                            </form>
                            <form action="{{ route('document-request.reject', $request->request_id) }}" method="POST" class="inline-flex items-center gap-2 relative">
                                @csrf
                                <button type="submit" class="inline-flex items-center leading-5 text-sm font-medium text-red-600 hover:text-red-900">Reject</button>
                                <div class="relative">
                                    <select
                                        name="rejection_reason_option"
                                        class="w-44 border border-gray-300 rounded px-2 py-1 text-sm"
                                        onchange="toggleCustomRejectReason(this)"
                                        required
                                    >
                                        <option value="" disabled selected>Select option</option>
                                        <option value="Duplicate Request">Duplicate Request</option>
                                        <option value="Pending/Unsettled Issues">Pending/Unsettled Issues</option>
                                        <option value="Incorrect Information">Incorrect Information</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <div class="hidden custom-reason-wrapper absolute left-0 top-full mt-2 z-20">
                                        <input
                                            type="text"
                                            name="rejection_reason_custom"
                                            class="custom-reason-input w-44 border border-gray-300 rounded px-2 py-1 text-sm"
                                            placeholder="Provide Reason"
                                        >
                                    </div>
                                </div>
                            </form>
                            @else
                            <span class="text-gray-400">{{ ucfirst($request->status) }}</span>
                            @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No document requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Request Details -->
<div id="requestModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Details</h3>
            <div id="requestDetails" class="space-y-3">
                <!-- Details will be loaded here -->
            </div>
            <div class="mt-6">
                <button 
                    onclick="closeModal()"
                    class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCustomRejectReason(selectElement) {
    const customWrapper = selectElement.form.querySelector('.custom-reason-wrapper');
    const customInput = selectElement.form.querySelector('.custom-reason-input');
    if (!customInput || !customWrapper) return;

    const shouldShow = selectElement.value === 'Others';
    customWrapper.classList.toggle('hidden', !shouldShow);
    customInput.required = shouldShow;
    if (!shouldShow) customInput.value = '';
}

function showRequestDetails(requestId) {
    fetch(`/document-request/${requestId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('requestDetails').innerHTML = `
                <div><strong>Resident:</strong> ${data.resident_name}</div>
                <div><strong>Document Type:</strong> ${data.document_type}</div>
                <div><strong>Purpose:</strong> ${data.purpose || 'Not specified'}</div>
                <div><strong>Status:</strong> ${data.status}</div>
                ${data.status === 'rejected' ? `<div><strong>Rejection Reason:</strong> ${data.rejection_reason ?? 'No reason provided.'}</div>` : ''}
                <div><strong>Requested:</strong> ${data.requested_at}</div>
            `;
            document.getElementById('requestModal').classList.remove('hidden');
        });
}

function closeModal() {
    document.getElementById('requestModal').classList.add('hidden');
}
</script>

@endsection
