@extends('home.admin')

@section('title', 'Agricultural Certification')

@section('content')

<div class="flex flex-col md:flex-row gap-6 p-6">
    <!-- LEFT PANEL - FORM -->
    <div class="print-hide w-full md:w-1/3 bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Agricultural Certificate Details</h3>
        
        <form class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                    <input type="text" id="firstName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="First name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                    <input type="text" id="middleName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Middle name">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                    <input type="text" id="lastName" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Last name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                    <input type="text" id="suffix" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Jr., Sr., III">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Association Name</label>
                <input type="text" id="association" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Association name">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Farm Area (hectares)</label>
                <input type="text" id="farmArea" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Area in hectares">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Crops</label>
                <input type="text" id="crops" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Crop names">
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
    
    <!-- RIGHT PANEL - PREVIEW -->
    <div class="print-root w-full lg:w-2/3">
        <div class="print-card bg-white rounded-2xl shadow-lg p-6">
            <h3 class="print-hide text-xl font-bold text-slate-800 mb-6">Certificate Preview</h3>
            
            <!-- CERTIFICATE PREVIEW -->
            <div class="bond-paper bg-white border-2 border-slate-200 p-12 mx-auto relative">
                
                <!-- WATERMARK -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-10">
                    <img src="{{ asset('images/bgylogo.png') }}" class="w-[400px]" alt="Watermark">
                </div>
                
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
                    AGRICULTURAL CERTIFICATION
                </h2>
                
                <!-- BODY -->
                <div class="text-sm leading-relaxed space-y-4">
                    <p>
                        This is to certify that <span id="previewName" class="font-bold underline">_________________</span>,
                        of legal age, is a member of <span id="previewAssociation" class="underline">_________________</span>
                        Association, a bonafide resident of Barangay Bagacay, Dumaguete City, Negros Oriental.
                    </p>
                    
                    <p>
                        This is to certify further that Mr./Mrs. <span id="previewName2" class="underline">_________________</span> is:
                    </p>
                    
                    <p>
                        _____ A certified farmer tilling an area of <span id="previewArea" class="underline">_________________</span>
                        hectares located in Barangay Bagacay.
                    </p>
                    
                    <p>
                        _____ The area is planted with <span id="previewCrops" class="underline">_________________</span> (name of crop/s)
                    </p>
                    
                    <p>
                        This certification is issued upon the request of the above-named person
                        in compliance with his/her application in Registry for Basic Sector in Agriculture (RSBSA).
                    </p>
                    
                    <p>
                        Given this <span id="previewDate" class="underline">__/__/____</span>
                        at Barangay Bagacay, Dumaguete City.
                    </p>
                    
                    <div class="text-center mt-16">
                        <p class="font-bold uppercase">VINCENT ANDREW A. PERIGUA</p>
                        <p>Barangay Captain</p>
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
    document.getElementById('association').addEventListener('input', updatePreview);
    document.getElementById('farmArea').addEventListener('input', updatePreview);
    document.getElementById('crops').addEventListener('input', updatePreview);
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
        document.getElementById('previewName2').textContent = fullName || '_________________';
        document.getElementById('previewAssociation').textContent = document.getElementById('association').value || '_________________';
        document.getElementById('previewArea').textContent = document.getElementById('farmArea').value || '_________________';
        document.getElementById('previewCrops').textContent = document.getElementById('crops').value || '_________________';
        
        const dateValue = document.getElementById('dateIssued').value;
        if (dateValue) {
            const [year, month, day] = dateValue.split('-');
            document.getElementById('previewDate').textContent = `${month}/${day}/${year}`;
        } else {
            document.getElementById('previewDate').textContent = '__/__/____';
        }
    }
    
    // Initialize feather icons
    feather.replace();
</script>

<style>
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
