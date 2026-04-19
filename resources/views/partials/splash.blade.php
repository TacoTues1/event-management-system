<!-- Splash Screen Overlay -->
<div id="splashScreen" class="fixed inset-0 bg-gradient-to-br from-slate-50 to-blue-50 flex items-center justify-center z-50">
    <div class="text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-6 mx-auto shadow-xl">
            <i data-feather="home" class="w-12 h-12 text-white"></i>
        </div>
        
        <h1 class="text-4xl font-bold text-slate-800 mb-2 tracking-tight">Barangay Bagacay</h1>
        <p class="text-lg text-slate-600 mb-8">Management System</p>
        
        <div class="flex justify-center items-center gap-2">
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
        </div>
        
        <p class="text-sm text-slate-500 mt-4">Loading...</p>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        setTimeout(() => {
            const splash = document.getElementById('splashScreen');
            if (splash) {
                splash.style.opacity = '0';
                splash.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    splash.style.display = 'none';
                }, 500);
            }
        }, 1500);
    });
</script>