<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Depot Air AquaSegar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .water-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 40%, #0369a1 70%, #0e7490 100%);
        }
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            animation: rise 8s infinite ease-in;
        }
        @keyframes rise {
            0%   { transform: translateY(0) scale(1); opacity: 0.5; }
            100% { transform: translateY(-120vh) scale(1.5); opacity: 0; }
        }
    </style>
</head>
<body class="min-h-screen water-bg flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Decorative bubbles -->
    <div class="bubble w-16 h-16" style="left:10%;bottom:-20px;animation-delay:0s;animation-duration:12s;"></div>
    <div class="bubble w-8 h-8"  style="left:25%;bottom:-20px;animation-delay:2s;animation-duration:8s;"></div>
    <div class="bubble w-24 h-24" style="left:60%;bottom:-20px;animation-delay:1s;animation-duration:15s;"></div>
    <div class="bubble w-6 h-6"  style="left:80%;bottom:-20px;animation-delay:3s;animation-duration:9s;"></div>
    <div class="bubble w-12 h-12" style="left:45%;bottom:-20px;animation-delay:4s;animation-duration:11s;"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white shadow-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-blue-700" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8 7 4 10.5 4 14a8 8 0 0016 0c0-3.5-4-7-8-12z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">AquaSegar</h1>
            <p class="text-blue-200 text-sm mt-1">Sistem Informasi Depot Air Minum</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang!</h2>
            <p class="text-sm text-slate-400 mb-6">Masuk ke panel admin depot Anda.</p>

            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Admin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                               placeholder="admin@aquasegar.com"
                               class="w-full pl-9 pr-4 py-2.5 border @error('email') border-red-400 bg-red-50 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                </div>

                <!-- Remember me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600">Ingat saya</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-3 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white font-bold text-sm rounded-xl transition-all shadow-lg shadow-blue-700/30 hover:shadow-blue-800/40">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        <p class="text-center text-blue-200 text-xs mt-6">
            &copy; {{ date('Y') }} AquaSegar &mdash; Depot Air Minum
        </p>
    </div>
</body>
</html>
