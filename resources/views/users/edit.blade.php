<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="w-full sm:max-w-md p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full sm:max-w-md p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Password Baru</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full sm:max-w-md p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Role</label>
                            <select id="role" name="role" class="w-full sm:max-w-md p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-start space-x-4 mt-8">
                            <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>