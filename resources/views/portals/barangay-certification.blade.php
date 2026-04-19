@extends('home.admin')

@section('title', 'Barangay Certification')

@section('content')

<div class="flex flex-col md:flex-row gap-6 p-6">
    <!-- LEFT PANEL - FORM -->
    <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Barangay Certificate Details</h3>
        
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
                <label class="block text-sm font-medium text-slate-700 mb-2">Purok</label>
                <select id="purok" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="Purok Mahigugma-on">Purok Mahigugma-on</option>
                    <option value="Purok Gumamela">Purok Gumamela</option>
                    <option value="Purok Santol">Purok Santol</option>
                    <option value="Purok Cebasca">Purok Cebasca</option>
                    <option value="Purok Fuente">Purok Fuente</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Business Type</label>
                <input type="text" id="businessType" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Business type">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Business Since (Year)</label>
                <input type="number" id="businessYear" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Year started" min="1990" max="2030">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Purpose</label>
                <input type="text" id="purpose" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Purpose">
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
    <div class="w-full md:w-2/3">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Certificate Preview</h3>
            
            <!-- CERTIFICATE PREVIEW -->
            <div class="bond-paper bg-white border-2 border-slate-200 p-12 mx-auto relative" style="width: 600px; min-height: 800px; transform: scale(0.8); transform-origin: top;">
                
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
                    BARANGAY CERTIFICATION
                </h2>
                
                <!-- BODY -->
                <div class="text-sm leading-relaxed space-y-4">
                    <p class="font-semibold mb-4">TO WHOM IT MAY CONCERN:</p>
                    
                    <p>
                        This is to certify that <span id="previewName" class="font-bold underline">_________________</span>,
                        of legal age, a resident of <span id="previewPurok" class="underline">_________________</span>,
                        Barangay Bagacay, Dumaguete City, engaged in <span id="previewBusiness" class="underline">_________________</span>
                        business since <span id="previewBusinessYear" class="underline">____</span> up to the present.
                    </p>
                    
                    <p>
                        This certification is issued upon the request of the aforementioned for
                        <span id="previewPurpose" class="underline">_________________</span>.
                    </p>
                    
                    <p>
                        Issued this <span id="previewDate" class="underline">__/__/____</span>
                        at the office of the Barangay Captain Barangay Bagacay, Dumaguete City.
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
    document.getElementById('purok').addEventListener('change', updatePreview);
    document.getElementById('businessType').addEventListener('input', updatePreview);
    document.getElementById('businessYear').addEventListener('input', updatePreview);
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
        document.getElementById('previewPurok').textContent = document.getElementById('purok').value || '_________________';
        document.getElementById('previewBusiness').textContent = document.getElementById('businessType').value || '_________________';
        document.getElementById('previewBusinessYear').textContent = document.getElementById('businessYear').value || '____';
        document.getElementById('previewPurpose').textContent = document.getElementById('purpose').value || '_________________';
        
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
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 80px;
        border: none;
        font-size: 18px;
        line-height: 1.6;
        transform: none !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    @page { 
        size: 8.5in 11in;
        margin: 0;
    }
}
</style>

@endsection