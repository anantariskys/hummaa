<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Tambah Soal
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Kategori --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Tipe Soal --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tipe Soal</label>
                    <select name="question_type_id" id="question_type_id"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        @foreach($questionTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Teks Soal --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Teks Soal</label>
                    <textarea name="question_text" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
                    <input type="file" name="image_url" class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                {{-- Penjelasan --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Penjelasan</label>
                    <textarea name="explanation" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>

                {{-- Opsi Pilihan Ganda (muncul kalau tipe soal = 1) --}}
                <div id="options-section" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700">Opsi Jawaban</label>
                    @for($i = 1; $i <= 4; $i++)
                        <div class="flex items-center mt-2 gap-2">
                            <input type="text" name="options[{{ $i }}][text]" placeholder="Opsi {{ $i }}"
                                   class="flex-1 rounded-md border-gray-300">
                            <label class="flex items-center gap-1 text-sm">
                                <input type="radio" name="options[{{ $i }}][is_correct]" value="1">
                                Benar
                            </label>
                        </div>
                    @endfor
                </div>

                {{-- Jawaban Benar (muncul kalau tipe soal = 2) --}}
                <div id="answer-section" class="mb-4 hidden">
                    <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
                    <input type="text" name="correct_answer_text" class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.questions') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-sm font-medium text-white hover:bg-main-bg/80">
                        Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
      const questionTypeSelect = document.getElementById('question_type_id');
const optionsSection = document.getElementById('options-section');
const answerSection = document.getElementById('answer-section');

function toggleSections() {
    const isMultipleChoice = questionTypeSelect.value == 1;

    // Show/hide section
    optionsSection.classList.toggle('hidden', !isMultipleChoice);
    answerSection.classList.toggle('hidden', isMultipleChoice);

    // Enable/disable inputs
    optionsSection.querySelectorAll('input').forEach(input => {
        input.disabled = !isMultipleChoice;
    });

    answerSection.querySelectorAll('input').forEach(input => {
        input.disabled = isMultipleChoice;
    });
}

// jalan saat load & saat change
toggleSections();
questionTypeSelect.addEventListener('change', toggleSections);

    </script>
</x-app-layout>
