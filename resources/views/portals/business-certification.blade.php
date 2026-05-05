@extends('home.admin')

@section('title', 'Business Certification')

@section('content')

<div class="flex flex-col md:flex-row gap-6 p-6">
    <!-- LEFT PANEL - FORM -->
    <div class="w-full md:w-1/3">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Certificate Information</h3>
            
            <form class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                        <input type="text" id="firstName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                        <input type="text" id="middleName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                        <input type="text" id="suffix" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Jr., Sr., III (optional)">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Civil Status</label>
                    <select id="civilStatus" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="widowed">Widowed</option>
                        <option value="separated">Separated</option>
                    </select>
                </div>
                
                <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Purok</label>
                <select id="purok" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">Select Purok</option>
                    @foreach(config('puroks', []) as $name => $coords)
                    <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Business Name</label>
                    <input type="text" id="businessName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Years in Operation</label>
                    <input type="number" id="businessYears" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" min="1">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Purpose</label>
                    <input type="text" id="purpose" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Date Issued</label>
                    <input type="date" id="dateIssued" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                
                <button type="button" onclick="window.print()" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    Print Certificate
                </button>
            </form>
        </div>
    </div>
    
    <!-- RIGHT PANEL - PREVIEW -->
    <div class="print-root w-full lg:w-2/3">
        <div class="print-card bg-white rounded-2xl shadow-lg p-6">
            <h3 class="print-hide text-xl font-bold text-slate-800 mb-6">Certificate Preview</h3>
            
            <!-- CERTIFICATE PREVIEW -->
            <div class="bond-paper bg-white mx-auto relative">
                
                <!-- HEADER -->
                <div class="relative text-center mb-6">
                    <img src="{{ asset('images/bgylogo.png') }}" class="w-16 h-16 mx-auto mb-4 object-contain">
                    
                    <p class="text-sm">Republic of the Philippines</p>
                    <p class="text-sm">Province of Negros Oriental</p>
                    <p class="text-sm">City of Dumaguete</p>
                    
                    <p class="font-bold mt-2 text-sm">OFFICE OF THE BARANGAY CAPTAIN</p>
                    <p class="font-bold text-sm">BARANGAY BAGACAY</p>
                    
                    <hr class="border-t border-dotted border-black mt-4">
                </div>
                
                <!-- TITLE -->
                <h2 class="text-center tracking-widest text-lg font-semibold mb-8">
                    BUSINESS CERTIFICATION
                </h2>
                
                <!-- BODY -->
                <div class="text-sm leading-relaxed space-y-4">
                    <p class="font-semibold mb-4">TO WHOM IT MAY CONCERN:</p>
                    
                    <p>
                        This is to certify that <span id="previewName" class="font-bold underline">_________________</span>,
                        of legal age, <span id="previewCivil">single/married</span>, and a resident of
                        <span id="previewPurok" class="underline">_________________</span>,
                        Barangay Bagacay, Dumaguete City, owned and managed
                        <span id="previewBusiness" class="underline">_________________</span>
                        business for <span id="previewYears" class="underline">___</span> years now.
                    </p>
                    
                    <p>
                        This certification is issued upon the request of the aforementioned for
                        <span id="previewPurpose" class="underline">_________________</span>.
                    </p>
                    
                    <p>
                        Issued this <span id="previewDate" class="underline">__/__/____</span>
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

<script>
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    document.getElementById('dateIssued').value = `${yyyy}-${mm}-${dd}`;
    
    updatePreview();
    
    document.getElementById('firstName').addEventListener('input', updatePreview);
    document.getElementById('middleName').addEventListener('input', updatePreview);
    document.getElementById('lastName').addEventListener('input', updatePreview);
    document.getElementById('suffix').addEventListener('input', updatePreview);
    document.getElementById('civilStatus').addEventListener('change', updatePreview);
    document.getElementById('purok').addEventListener('change', updatePreview);
    document.getElementById('businessName').addEventListener('input', updatePreview);
    document.getElementById('businessYears').addEventListener('input', updatePreview);
    document.getElementById('purpose').addEventListener('input', updatePreview);
    document.getElementById('dateIssued').addEventListener('input', updatePreview);
    
    function updatePreview() {
        const firstName = document.getElementById('firstName').value;
        const middleName = document.getElementById('middleName').value;
        const lastName = document.getElementById('lastName').value;
        const suffix = document.getElementById('suffix').value;
        
        let fullName = firstName;
        if (middleName) fullName += ' ' + middleName;
        if (lastName) fullName += ' ' + lastName;
        if (suffix) fullName += ' ' + suffix;
        
        document.getElementById('previewName').textContent = fullName || '_________________';
        document.getElementById('previewCivil').textContent = document.getElementById('civilStatus').value;
        document.getElementById('previewPurok').textContent = document.getElementById('purok').value || '_________________';
        document.getElementById('previewBusiness').textContent = document.getElementById('businessName').value || '_________________';
        document.getElementById('previewYears').textContent = document.getElementById('businessYears').value || '___';
        document.getElementById('previewPurpose').textContent = document.getElementById('purpose').value || '_________________';
        
        const dateValue = document.getElementById('dateIssued').value;
        if (dateValue) {
            const [year, month, day] = dateValue.split('-');
            document.getElementById('previewDate').textContent = `${month}/${day}/${year}`;
        } else {
            document.getElementById('previewDate').textContent = '__/__/____';
        }
    }
</script>

<style>
.bond-paper {
    width: 8.5in;
    max-width: 100%;
    min-height: 11in;
    margin: 0 auto;
    padding: 1in;
    border: 1px solid #e2e8f0;
    background: white;
    position: relative;
    transform: scale(0.72);
    transform-origin: top center;
    box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
}

.bond-paper::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("{{ asset('images/bgylogo.png') }}");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 50% auto;
    opacity: 0.08;
    pointer-events: none;
    z-index: 0;
}

.bond-paper > * {
    position: relative;
    z-index: 1;
}

@media print {
            @page {
                size: letter portrait;
                margin: 0;
            }

            html, body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                min-height: 100% !important;
                background: white !important;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            *, *::before, *::after {
                box-sizing: border-box !important;
            }

            .print-hide {
                display: none !important;
            }

            .print-root,
            .print-card {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                background: transparent !important;
                overflow: visible !important;
            }

            .bond-paper {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                isolation: isolate !important;
                width: 8.5in !important;
                height: 11in !important;
                margin: 0 !important;
                padding: 0.45in 0.7in 0.7in !important;
                border: none !important;
                box-shadow: none !important;
                transform: none !important;
                background: white !important;
                display: block !important;
                overflow: hidden !important;
            }

            .bond-paper::before,
            .bond-paper > .absolute.inset-0 {
                z-index: 0 !important;
            }

            .bond-paper > :not(.absolute.inset-0) {
                position: relative !important;
                z-index: 1 !important;
            }

            .bond-paper::before {
                background-size: 50% auto !important;
                background-position: center !important;
            }

            .bond-paper img {
                max-width: 100%;
                height: auto;
            }
        }
</style>

@endsection