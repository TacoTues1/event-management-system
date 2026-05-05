<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Certificate of Indigency - Barangay Bagacay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }

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
            background-image: url("{{ asset('images/barangay_logo.jpg') }}");
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

        .bond-paper .absolute.inset-0,
        .bond-paper .opacity-10 {
            display: none;
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
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">

    <!-- Header -->
    <header class="print-hide bg-white/80 backdrop-blur-sm border-b border-white/20 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('user.dashboard') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                    <i data-feather="arrow-left" class="w-5 h-5"></i>
                </a>
                <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Request Certificate of Indigency</h1>
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
        <div class="print-hide w-full md:w-1/3 bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-slate-800 mb-6">Certificate Details</h3>
            
            <form action="{{ route('user.request.document') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="document_type" value="Certificate of Indigency">

                @php
                    $nameParts = preg_split('/\s+/', trim((string) Auth::user()->name));
                    $reqFirstName = $nameParts[0] ?? '';
                    $reqMiddleNameRaw = $nameParts[1] ?? '';
                    $reqLastName = $nameParts[2] ?? '';
                    $reqSuffix = $nameParts[3] ?? '';

                    // Capitalize first letter for consistent display.
                    $reqFirstName = mb_strtoupper(mb_substr((string) $reqFirstName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr((string) $reqFirstName, 1, null, 'UTF-8');
                    $reqLastName = mb_strtoupper(mb_substr((string) $reqLastName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr((string) $reqLastName, 1, null, 'UTF-8');

                    $reqMiddleName = trim((string) $reqMiddleNameRaw);
                    if ($reqMiddleName !== '') {
                        $reqMiddleName = mb_strtoupper(mb_substr($reqMiddleName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($reqMiddleName, 1, null, 'UTF-8');
                        // If stored as a single initial (e.g., "K"), make it "K."
                        if (strpos($reqMiddleName, '.') === false && mb_strlen(str_replace('.', '', $reqMiddleName), 'UTF-8') === 1) {
                            $reqMiddleName .= '.';
                        }
                    } else {
                        $reqMiddleName = '';
                    }
                @endphp
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                        <input type="text" id="firstName" name="first_name" value="{{ $reqFirstName }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="First name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                        <input type="text" id="middleName" name="middle_name" value="{{ $reqMiddleName }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Middle name">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" name="last_name" value="{{ $reqLastName }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Last name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                        <input type="text" id="suffix" name="suffix" value="{{ $reqSuffix }}" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20" placeholder="Jr., Sr., III">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Civil Status</label>
                    <select id="civilStatus" name="civil_status" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        <option value="single" {{ Auth::user()->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ Auth::user()->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="divorced" {{ Auth::user()->civil_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="widowed" {{ Auth::user()->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
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
        <div class="print-root w-full md:w-2/3">
            <div class="print-card bg-white rounded-2xl shadow-lg p-6">
                <h3 class="print-hide text-xl font-bold text-slate-800 mb-6">Certificate Preview</h3>
                
                <!-- CERTIFICATE PREVIEW -->
                <div class="bond-paper bg-white border-2 border-slate-200 p-6 sm:p-12 mx-auto relative overflow-x-auto">
                    
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
                            This is to certify that <span id="previewName" class="font-bold underline">_________________</span>,
                            of legal age, <span id="previewCivil">single/married</span>, is a resident of
                            <span id="previewPurok" class="underline">_________________</span>,
                            Barangay Bagacay, Dumaguete City.
                        </p>
                        
                        <p>
                            Furthermore he/she belongs to the indigent families of this barangay
                            whose family income falls below poverty line.
                        </p>
                        
                        <p>
                            This certification is issued upon the request of the aforementioned for
                            <span id="previewPurpose" class="underline">_________________</span>.
                        </p>
                        
                        <p>
                            Issued this _____ day of _________, ____
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
        // Update preview
        updatePreview();
        
        // Add event listeners
        document.getElementById('firstName').addEventListener('input', updatePreview);
        document.getElementById('middleName').addEventListener('input', updatePreview);
        document.getElementById('lastName').addEventListener('input', updatePreview);
        document.getElementById('suffix').addEventListener('input', updatePreview);
        document.getElementById('civilStatus').addEventListener('change', updatePreview);
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
            document.getElementById('previewCivil').textContent = document.getElementById('civilStatus').value;
            document.getElementById('previewPurok').textContent = document.getElementById('purok').value || '_________________';
            document.getElementById('previewPurpose').textContent = document.getElementById('purpose').value || '_________________';
        }
        
        // Initialize feather icons
        feather.replace();
    </script>

</body>
</html>