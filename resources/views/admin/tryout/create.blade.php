<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Tambah Try Out
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <!-- Info Alert -->
            <div class="mb-6 rounded-lg bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Info:</strong> Anda bisa membuat tryout tanpa event (sebagai draft). 
                            Tryout tanpa event <strong>tidak akan muncul</strong> di halaman user sampai Anda menghubungkannya dengan event.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.tryout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Event Selection - OPSIONAL -->
                <div class="mb-4">
                    <label for="event_id" class="block text-sm font-medium text-gray-700">
                        Event <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <select name="event_id" id="event_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Tidak ada event (Draft) --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} @if($event->subtitle) - {{ $event->subtitle }} @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Kosongkan jika ingin menyimpan sebagai draft. User tidak akan melihat tryout ini sampai Anda menambahkan event.
                        </span>
                    </p>
                    @error('event_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Judul -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Contoh: Tryout Simulasi TPA #1">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div class="mb-4">
                    <label for="year" class="block text-sm font-medium text-gray-700">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" required
                           min="{{ date('Y') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Durasi (menit) -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">
                        Durasi (menit) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="duration_minutes" id="duration" value="{{ old('duration_minutes') }}" required
                           min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Contoh: 90">
                    <p class="mt-1 text-xs text-gray-500">Waktu yang diberikan kepada user untuk menyelesaikan tryout</p>
                    @error('duration_minutes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                  
                <!-- Category -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" id="category" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Kategori akan menentukan di mana tryout ini muncul di Bank Soal</p>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             
                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-2 mt-6 pt-4 border-t">
                    <a href="{{ route('admin.tryout.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-main-bg/80">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Simpan Try Out
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>