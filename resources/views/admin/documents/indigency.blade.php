@extends('home.admin')

@section('title', 'View Certificate of Indigency Request')

@section('content')

<div class="flex gap-6 p-6">
    <!-- LEFT PANEL - REQUEST INFO -->
    <div class="w-1/3 bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Request Information</h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Resident Name</label>
                <p class="text-slate-900 bg-slate-50 rounded-xl px-4 py-3">{{ $request->resident->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Document Type</label>
                <p class="text-slate-900 bg-slate-50 rounded-xl px-4 py-3">{{ $documentType }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Purpose</label>
                <p class="text-slate-900 bg-slate-50 rounded-xl px-4 py-3">{{ $actualPurpose }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : 
                       ($request->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($request->status) }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Requested Date</label>
                <p class="text-slate-900 bg-slate-50 rounded-xl px-4 py-3">{{ $request->created_at->format('M d, Y h:i A') }}</p>
            </div>
            
            @if($request->status === 'pending')
            <div class="flex gap-3 mt-6">
                <form action="{{ route('document-request.approve', $request->request_id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-medium transition-all duration-200">
                        Approve Request
                    </button>
                </form>
                <form action="{{ route('document-request.reject', $request->request_id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-medium transition-all duration-200">
                        Reject Request
                    </button>
                </form>
            </div>
            @elseif($request->status === 'approved')
            <div class="mt-6">
                <button onclick="window.print()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-medium transition-all duration-200">
                    Print Document
                </button>
            </div>
            @endif
        </div>
    </div>
    
    <!-- RIGHT PANEL - DOCUMENT PREVIEW -->
    <div class="w-2/3">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Document Preview</h3>
            
            <!-- CERTIFICATE PREVIEW -->
            <div class="bond-paper bg-white border-2 border-slate-200 p-12 mx-auto relative" style="width: 600px; min-height: 800px; transform: scale(0.8); transform-origin: top;">
                
                <!-- WATERMARK -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-10">
                    <img src="{{ asset('images/barangay_logo.jpg') }}" class="w-[400px]" alt="Watermark">
                </div>
                
                <!-- HEADER -->
                <div class="relative text-center mb-6">
                    <img src="{{ asset('images/barangay_logo.jpg') }}" class="w-16 h-16 mx-auto mb-4 object-contain">
                    
                    <p class="text-sm">Republic of the Philippines</p>
                    <p class="text-sm">Province of Negros Oriental</p>
                    <p class="text-sm">City of Dumaguete</p>
                    
                    <p class="font-bold mt-2 text-sm">OFFICE OF THE BARANGAY CAPTAIN</p>
                    <p class="font-bold text-sm">BARANGAY BAGACAY</p>
                    
                    <hr class="border-t border-dotted border-black mt-4">
                </div>
                
                <!-- TITLE -->
                <h2 class="text-center tracking-widest text-lg font-semibold mb-8">
                    CERTIFICATE OF INDIGENCY
                </h2>
                
                <!-- BODY -->
                <div class="text-sm leading-relaxed space-y-4">
                    <p class="font-semibold mb-4">TO WHOM IT MAY CONCERN:</p>
                    
                    <p>
                        This is to certify that <span class="font-bold underline">{{ $request->resident->name }}</span>,
                        of legal age, {{ strtolower($request->resident->civil_status) }}, is a resident of
                        <span class="underline">{{ $request->resident->purok }}</span>,
                        Barangay Bagacay, Dumaguete City.
                    </p>
                    
                    <p>
                        Furthermore he/she belongs to the indigent families of this barangay
                        whose family income falls below poverty line.
                    </p>
                    
                    <p>
                        This certification is issued upon the request of the aforementioned for
                        <span class="underline">{{ $actualPurpose }}</span>.
                    </p>
                    
                    <p>
                        Issued this <span class="underline">{{ now()->format('j') }}</span>
                        day of <span class="underline">{{ now()->format('F') }}</span>,
                        <span class="underline">{{ now()->format('Y') }}</span>
                        at the office of the Barangay Captain Barangay Bagacay,
                        Dumaguete City, Philippines.
                    </p>
                    
                    <div class="text-center mt-16">
                        <p class="font-bold uppercase">VINCENT ANDREW A. PERIGUA</p>
                        <p>Punong Barangay</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    
    body * { 
        visibility: hidden; 
    }
    
    .bond-paper, .bond-paper * { 
        visibility: visible; 
    }
    
    .bond-paper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) !important;
        width: 8.5in;
        height: 11in;
        margin: 0;
        padding: 1in;
        border: none;
        font-size: 16px;
        line-height: 1.5;
        background: white;
    }
    
    @page { 
        size: 8.5in 11in;
        margin: 0;
    }
}
</style>

@endsection