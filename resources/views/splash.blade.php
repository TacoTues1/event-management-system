<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Bagacay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .pulse-animation { animation: pulse 2s infinite; }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center">
    
    <div class="text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-6 mx-auto shadow-xl">
            <i data-feather="home" class="w-12 h-12 text-white"></i>
        </div>
        
        <h1 class="text-4xl font-bold text-slate-800 mb-2 tracking-tight">Barangay Bagacay</h1>
        <p class="text-lg text-slate-600 mb-8">Management System</p>
        
        <div class="flex justify-center items-center gap-2">
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-animation"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-animation" style="animation-delay: 0.2s;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full pulse-animation" style="animation-delay: 0.4s;"></div>
        </div>
        
        <p class="text-sm text-slate-500 mt-4">Loading...</p>
    </div>

    <script>
        feather.replace();
        
        // Redirect to welcome page after 3 seconds
        setTimeout(() => {
            window.location.href = '{{ route("welcome-portal") }}';
        }, 3000);
    </script>
</body>
</html>