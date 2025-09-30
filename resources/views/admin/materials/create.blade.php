<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Tambah Materi
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Judul -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Durasi -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Durasi</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Materi -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700">File Materi</label>
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" 
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-main-bg file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-main-bg/80">
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.materials') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-main-bg/80">
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
