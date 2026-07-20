<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amarin E-Book System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { amarin: '#0ea5e9', amarinDark: '#0369a1' } } }
        }
    </script>
    <style>
        body { background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); background-attachment: fixed; }
        .glass-panel { background: rgba(255, 255, 255, 0.65); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 8px 32px 0 rgba(3, 105, 161, 0.07); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-800 antialiased">

    <!-- Efek Cahaya Latar Belakang -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-cyan-300 rounded-full mix-blend-multiply filter blur-[100px] opacity-50"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-[100px] opacity-50"></div>

    <div class="glass-panel w-full max-w-md rounded-[2.5rem] p-8 sm:p-10 relative z-10">

        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg mb-4 transform transition hover:scale-105">
                <i class="fa-solid fa-anchor text-white text-3xl"></i>
            </div>
            <h2 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-cyan-600 tracking-tight">Amarin E-Book System</h2>
            <p class="text-sm font-bold text-slate-500 mt-1 uppercase tracking-widest">Administrator Portal</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-600 font-bold text-sm text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-1 ml-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-slate-400"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-white/60 focus:border-amarin focus:ring focus:ring-amarin/20 rounded-2xl transition-all shadow-inner text-sm" placeholder="itoperation@amarinshipmgmt.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 fw-bold" />
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-1 ml-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-11 pr-4 py-3 bg-white/50 border border-white/60 focus:border-amarin focus:ring focus:ring-amarin/20 rounded-2xl transition-all shadow-inner text-sm" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 fw-bold" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded text-amarin focus:ring-amarin bg-white/50 border-white/60 shadow-sm" name="remember">
                    <span class="ml-2 text-sm font-semibold text-slate-600 group-hover:text-amarin transition-colors">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-amarin hover:text-blue-700 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-2xl shadow-[0_10px_20px_-10px_rgba(14,165,233,0.5)] hover:-translate-y-0.5 hover:shadow-[0_15px_25px_-10px_rgba(14,165,233,0.6)] transition-all">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sistem
                </button>
            </div>
        </form>

        <!-- Back to Home -->
        <div class="mt-8 text-center border-t border-slate-200/50 pt-6">
            <a href="/" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/50 text-slate-400 hover:text-amarin hover:bg-white shadow-sm transition-all" title="Kembali ke Beranda Pustaka">
                <i class="fa-solid fa-home"></i>
            </a>
        </div>
    </div>
</body>
</html>
