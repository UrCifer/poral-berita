<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang Di Portal Berita</h1>
        <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="input-container mb-6">
            <i class="fas fa-envelope input-icon"></i>
            <input 
                id="email" 
                class="login-input" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="Email"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-container mb-6">
            <i class="fas fa-lock input-icon"></i>
            <input 
                id="password" 
                class="login-input" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" 
                placeholder="Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" 
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    class="text-sm text-purple-600 hover:text-purple-800 hover:underline"
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="btn-login flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Log in') }}
            </button>
        </div>

        <!-- Home Link -->
        <div class="flex items-center justify-center mt-6">
            <a 
                href="{{ route('home') }}" 
                class="flex items-center text-gray-600 hover:text-purple-600 transition-colors duration-300"
            >
                <i class="fas fa-home mr-1"></i> {{ __('Kembali ke Beranda') }}
            </a>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-8 text-center border-t border-gray-200 pt-6">
        <p class="text-sm text-gray-600">
            Belum memiliki akun? 
            <a href="{{ route('register') }}" class="text-purple-600 hover:underline font-medium">
                Daftar sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
