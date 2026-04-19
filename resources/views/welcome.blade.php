<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <title>Barangay Bagacay</title>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center p-4 sm:p-6">

  @include('partials.splash')

  <div class="bg-white/80 backdrop-blur-sm w-full max-w-md rounded-3xl shadow-xl border border-white/20 p-8 sm:p-10">

   <div class="flex flex-col items-center mb-8">
      <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-6 shadow-lg">
        <img
            src="{{ asset('images/barangay_logo.jpg') }}"
            alt="Barangay Logo"
            class="w-14 h-14 sm:w-16 sm:h-16 object-contain rounded-full"
        >
      </div>
      <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 text-center mb-2 tracking-tight">
          Barangay Bagacay
      </h1>
      <p class="text-sm text-slate-500 font-light">Management System</p>
  </div>


    @if(session('success'))
          <script>alert("{{ session('success') }}");</script>
      @endif

      @if(session('error'))
          <script>alert("{{ session('error') }}");</script>
      @endif

      @if($errors->any())
          <script>
              let messages = "";
              @foreach($errors->all() as $error)
                  messages += "{{ $error }}\n";
              @endforeach
              alert(messages);
          </script>
    @endif

    <form action="{{ route('login.user') }}" method="POST" class="space-y-5">
      @csrf
      <div>
          <input
            type="text"
            name="username"
            placeholder="Username or Email"
            class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-4 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200"
            required
          />
      </div>
      <div class="relative">
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-4 pr-12 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200"
            required
          />
          <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
            <i data-feather="eye" id="eyeIcon" class="w-5 h-5"></i>
          </button>
      </div>
      <button
          type="submit"
          class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 text-base font-medium rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
      >
          Sign In
      </button>
    </form>

    <div class="text-center mt-8">
      <p class="text-sm text-slate-400 mb-4">
        Need an account? 
        <a href="{{ route('signup-portal') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">Sign up here</a>
      </p>
      
      <div class="pt-6 border-t border-slate-100">
        <p class="text-xs text-slate-400 mb-2">Powered by</p>
        <div class="text-xs text-slate-600 font-medium">Negros Oriental State University</div>
      </div>
    </div>

  </div>
  
  <script>
    // Clear all text inputs on page load
    window.addEventListener('load', function() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], textarea');
        inputs.forEach(input => {
            input.value = '';
        });
    });

    feather.replace();
    
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.setAttribute('data-feather', 'eye-off');
      } else {
        passwordInput.type = 'password';
        eyeIcon.setAttribute('data-feather', 'eye');
      }
      feather.replace();
    }
  </script>
</body>
</html>
