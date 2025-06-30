<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Akun</h1>
        <p class="text-gray-600 mt-2">Buat akun untuk mulai berbagi berita</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="input-container">
            <i class="fas fa-user input-icon"></i>
            <input 
                id="name" 
                class="login-input" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Nama Lengkap"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="input-container">
            <i class="fas fa-envelope input-icon"></i>
            <input 
                id="email" 
                class="login-input" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
                placeholder="Email"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-container">
            <i class="fas fa-lock input-icon"></i>
            <input 
                id="password" 
                class="login-input" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" 
                placeholder="Password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="input-container">
            <i class="fas fa-lock input-icon"></i>
            <input 
                id="password_confirmation" 
                class="login-input" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password" 
                placeholder="Konfirmasi Password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Buttons -->
        <div class="pt-2">
            <button type="submit" class="btn-login flex items-center justify-center w-full">
                <i class="fas fa-user-plus mr-2"></i> {{ __('Daftar') }}
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

    <!-- Login Link -->
    <div class="mt-8 text-center border-t border-gray-200 pt-6">
        <p class="text-sm text-gray-600">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-purple-600 hover:underline font-medium">
                Login sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
