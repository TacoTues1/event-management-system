<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Certificate of Good Moral - Barangay Bagacay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm border-b border-white/20 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('user.dashboard') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                    <i data-feather="arrow-left" class="w-5 h-5"></i>
                </a>
                <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Request Certificate of Good Moral</h1>
                    <p class="text-sm text-gray-500">Fill out the form to request your document</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-600">{{ Auth::user()->purok }}</p>
                </div>
                <div class="relative">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <button onclick="toggleProfileMenu()" class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full shadow-md flex items-center justify-center hover:scale-110 transition-transform">
                        <i data-feather="chevron-down" class="w-3 h-3 text-gray-600"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Profile Dropdown -->
        <div id="profileMenu" class="absolute right-4 top-20 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 hidden animate-fade-in">
            <div class="p-4 border-b border-gray-100">
                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
            </div>
            <div class="p-2">
                <a href="{{ route('user.requests') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                    <i data-feather="file-text" class="w-4 h-4 text-blue-600"></i>
                    <span class="text-sm font-medium">My Requests</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-red-50 text-red-600 transition-colors">
                        <i data-feather="log-out" class="w-4 h-4"></i>
                        <span class="text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Profile Menu Script -->
    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close profile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profileMenu');
            const button = e.target.closest('[onclick="toggleProfileMenu()"]');
            if (!button && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
        </div>
    </header>

    <div class="flex flex-col md:flex-row gap-6 p-6">
        <!-- LEFT PANEL - FORM -->
        <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Certificate Details</h3>
            
            <form action="{{ route('user.request.document') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="document_type" value="Certificate of Good Moral">
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                        <input type="text" id="firstName" name="first_name" value="{{ explode(' ', Auth::user()->name)[0] ?? '' }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="First name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                        <input type="text" id="middleName" name="middle_name" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Middle name">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" name="last_name" value="{{ explode(' ', Auth::user()->name)[1] ?? '' }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Last name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                        <input type="text" id="suffix" name="suffix" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Jr., Sr., III">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Purok</label>
                    <select id="purok" name="purok" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Select Purok</option>
                        @php
                            $selectedPurok = preg_replace('/^Purok\s+/i', '', (string) Auth::user()->purok);
                        @endphp
                        @foreach(config('puroks', []) as $name => $coords)
                            <option value="{{ $name }}" {{ $selectedPurok === $name ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Purpose</label>
                    <input type="text" id="purpose" name="purpose" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Enter purpose" required>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-xl font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    Submit Request
                </button>
            </form>
        </div>
        
        <!-- RIGHT PANEL - PREVIEW -->
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Certificate Preview</h3>
                
                <!-- CERTIFICATE PREVIEW -->
                <div class="bond-paper bg-white border-2 border-slate-200 p-6 sm:p-12 mx-auto relative overflow-x-auto" style="max-width: 600px; min-height: 400px;">
                    
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
                        CERTIFICATE OF GOOD MORAL
                    </h2>
                    
                    <!-- BODY -->
                    <div class="text-sm leading-relaxed space-y-4">
                        <p class="font-semibold mb-4">TO WHOM IT MAY CONCERN:</p>
                        
                        <p>
                            This is to certify that <span id="previewName" class="font-bold underline">_________________</span>,
                            of legal age, a resident of <span id="previewPurok" class="underline">_________________</span>,
                            Barangay Bagacay, Dumaguete City, is a person of good moral character.
                        </p>
                        
                        <p>
                            He/She has not been involved in any criminal activities or misconduct
                            within this barangay and is known to be law-abiding and of good reputation.
                        </p>
                        
                        <p>
                            This certification is issued upon the request of the aforementioned for
                            <span id="previewPurpose" class="underline">_________________</span>.
                        </p>
                        
                        <p>
                            Issued this _____ day of _________, ____
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
        // Update preview
        updatePreview();
        
        // Add event listeners
        document.getElementById('firstName').addEventListener('input', updatePreview);
        document.getElementById('middleName').addEventListener('input', updatePreview);
        document.getElementById('lastName').addEventListener('input', updatePreview);
        document.getElementById('suffix').addEventListener('input', updatePreview);
        document.getElementById('purok').addEventListener('change', updatePreview);
        document.getElementById('purpose').addEventListener('input', updatePreview);
        
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
            document.getElementById('previewPurpose').textContent = document.getElementById('purpose').value || '_________________';
        }
        
        // Initialize feather icons
        feather.replace();
    </script>

</body>
</html>