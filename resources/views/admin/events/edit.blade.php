<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Edit Event
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8 rounded-xl shadow">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" x-data="{ testParts: {{ json_encode($event->test_parts ?? ['']) }} }">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subjudul -->
                <div class="mb-4">
                    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subjudul</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $event->subtitle) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Badge -->
                <div class="mb-4">
                    <label for="badge" class="block text-sm font-medium text-gray-700">Badge (opsional)</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $event->badge) }}"
                        placeholder="Contoh: Dasar, Menengah, Lanjutan"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('badge')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Durasi -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Durasi</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $event->duration) }}"
                        placeholder="Contoh: 60 menit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Soal -->
                <div class="mb-4">
                    <label for="question_count" class="block text-sm font-medium text-gray-700">Jumlah Soal</label>
                    <input type="text" name="question_count" id="question_count" value="{{ old('question_count', $event->question_count) }}"
                        placeholder="Contoh: 50 soal"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('question_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bagian Tes -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bagian Tes</label>

                    <template x-for="(part, index) in testParts" :key="index">
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text"
                                   :name="`test_parts[${index}]`"
                                   x-model="testParts[index]"
                                   placeholder="Contoh: Penalaran Logis"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <button type="button"
                                    x-show="testParts.length > 1"
                                    @click="testParts.splice(index, 1)"
                                    class="text-red-500 hover:text-red-700 text-lg font-bold">
                                &times;
                            </button>
                        </div>
                    </template>

                    <button type="button"
                            @click="testParts.push('')"
                            class="mt-2 text-sm text-indigo-600 hover:underline">
                        + Tambah Tes
                    </button>

                    @error('test_parts')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.events.index') }}"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-main-bg/80">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
