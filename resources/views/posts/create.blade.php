<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="title" class="block font-medium text-sm mb-1">Judul Berita</label>
                            <input type="text" id="title" name="title" required 
                                   class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm mb-1">Isi Berita</label>
                            <textarea id="content" name="content" required rows="6"
                                      class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <div class="mt-4">
                            <label for="category_id" class="block font-medium text-sm mb-1">Kategori</label>
                            <select id="category_id" name="category_id" required
                                   class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                                <option value="">- Pilih Kategori -</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm mb-2">Gambar Berita</label>
                            <div class="relative w-full">
                                <input type="file" id="image" name="image" class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer" onchange="previewImage(this)">
                                <div class="bg-white border border-gray-300 rounded py-2 px-4 flex items-center">
                                    <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span id="file-name-display" class="text-gray-700">Pilih file gambar</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks 2MB</p>
                            </div>
                            
                            <!-- Image Preview - Setelah upload file -->
                            <div id="image-preview-wrapper" class="mt-4 hidden">
                                <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar:</p>
                                <div class="relative border rounded-lg overflow-hidden bg-gray-100" style="max-height: 200px;">
                                    <img id="preview-image" src="#" alt="Preview Gambar" class="max-h-full max-w-full mx-auto object-contain">
                                </div>
                                <div id="image-info" class="mt-2">
                                    <div class="flex items-center text-sm text-gray-700">
                                        <svg class="mr-1.5 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span id="file-details" class="text-gray-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded hover:bg-green-700 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Simpan Berita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('image-preview-wrapper').classList.remove('hidden');
                    document.getElementById('file-details').textContent = file.name + ' (' + formatFileSize(file.size) + ')';
                    document.getElementById('file-name-display').textContent = file.name;
                }
                reader.readAsDataURL(file);
            }
        }
        
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' bytes';
            else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            else return (bytes / 1048576).toFixed(1) + ' MB';
        }
    </script>
</x-app-layout>
