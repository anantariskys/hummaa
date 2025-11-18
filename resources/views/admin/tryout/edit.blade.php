<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Edit Try Out
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <!-- Status Alert -->
            @if($tryout->event_id)
                <div class="mb-6 rounded-lg bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                <strong>Status:</strong> Tryout ini terhubung dengan event <strong>"{{ $tryout->event->title }}"</strong>. 
                                User yang sudah mendaftar event tersebut dapat mengakses tryout ini.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-6 rounded-lg bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Perhatian:</strong> Tryout ini belum terhubung dengan event manapun (status: Draft). 
                                User <strong>tidak dapat</strong> mengakses tryout ini. Hubungkan dengan event untuk mempublish.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.tryout.update', $tryout->tryout_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Event Selection - OPSIONAL -->
                <div class="mb-4">
                    <label for="event_id" class="block text-sm font-medium text-gray-700">
                        Event <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <select name="event_id" id="event_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Tidak ada event (Draft) --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $tryout->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} @if($event->subtitle) - {{ $event->subtitle }} @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Pilih event untuk mempublish tryout ini. Kosongkan untuk menyimpan sebagai draft.
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
                    <input type="text" name="title" id="title" value="{{ old('title', $tryout->title) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div class="mb-4">
                    <label for="year" class="block text-sm font-medium text-gray-700">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="year" id="year" value="{{ old('year', $tryout->year) }}" required
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
                    <input type="number" name="duration_minutes" id="duration" value="{{ old('duration_minutes', $tryout->duration_minutes) }}" required
                           min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                            <option value="{{ $category->id }}" {{ old('category_id', $tryout->category_id) == $category->id ? 'selected' : '' }}>
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
                <div class="flex items-center justify-between gap-2 mt-6 pt-4 border-t">
                    <a href="{{ route('admin.tryout.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-main-bg/80">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                        </svg>
                        Update Try Out
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>