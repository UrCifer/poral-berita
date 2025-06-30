<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Judul Berita</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required 
                                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Isi Berita</label>
                            <textarea id="editor" name="content" required 
                                      class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600"
                                      rows="8">{{ old('content', $post->content) }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Kategori</label>
                            <select name="category_id" id="category_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
                                <option value="">- Pilih Kategori -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Gambar</label>
                            
                            @if($post->image)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Gambar saat ini:</p>
                                    <img src="{{ Storage::url($post->image) }}" alt="Current Image" class="w-48 h-auto object-cover rounded">
                                </div>
                            @endif
                            
                            <input type="file" id="image" name="image" class="w-full p-2">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengganti gambar</p>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-300 text-blue-700 rounded hover:bg-blue-400">
                                Kembali
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Trumbowyg Rich Text Editor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Trumbowyg editor
            $('#editor').trumbowyg();
        });
    </script>
</x-app-layout>