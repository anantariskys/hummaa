<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Edit Soal Try Out
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">{{ $tryout->title }}</h2>
                <a href="{{ route('admin.tryout.show', $tryout->tryout_id) }}"
                    class="inline-flex items-center rounded-lg bg-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tryout.questions.update', [$tryout->tryout_id, $question->question_id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nomor Soal -->
                    <div>
                        <label for="question_number" class="block text-sm font-medium text-gray-700">Nomor Soal</label>
                        <input type="number" name="question_number" id="question_number"
                            value="{{ old('question_number', $question->question_number) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                            required min="1">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                            required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $question->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipe Soal -->
                    <div>
                        <label for="question_type_id" class="block text-sm font-medium text-gray-700">Tipe Soal</label>
                        <select name="question_type_id" id="question_type_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                            required>
                            <option value="">Pilih Tipe</option>
                            @foreach ($questionTypes as $type)
                                <option value="{{ $type->id }}" data-type="{{ $type->type }}"
                                    {{ old('question_type_id', $question->question_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $type->type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <textarea name="question_text" id="question_text" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg" required>{{ old('question_text', $question->question_text) }}</textarea>
                    </div>

                    <!-- Image URL (Opsional) -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700">URL Gambar (Opsional)</label>
                        <input type="url" name="image_url" id="image_url"
                            value="{{ old('image_url', $question->image_url) }}"
                            placeholder="https://example.com/image.jpg"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">
                        @if ($question->image_url)
                            <div class="mt-2">
                                <img src="{{ $question->image_url }}" alt="Question Image" class="max-w-xs rounded border">
                            </div>
                        @endif
                    </div>

                    <!-- Opsi Jawaban (untuk multiple choice) -->
                    <div id="options-container" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Opsi Jawaban</label>
                        <div id="options-list">
                            @if ($question->options && $question->options->count() > 0)
                                @foreach ($question->options as $index => $option)
                                    <div class="mb-3 flex items-start gap-2 option-item">
                                        <div class="flex-1">
                                            <input type="text"
                                                name="options[{{ $index + 1 }}][option_text]"
                                                value="{{ old('options.' . ($index + 1) . '.option_text', $option->option_text) }}"
                                                placeholder="Teks Opsi {{ $index + 1 }}"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                                                required>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <label class="flex items-center">
                                                <input type="hidden" name="options[{{ $index + 1 }}][is_correct]" value="0">
                                                <input type="checkbox"
                                                    name="options[{{ $index + 1 }}][is_correct]"
                                                    value="1"
                                                    {{ old('options.' . ($index + 1) . '.is_correct', $option->is_correct) ? 'checked' : '' }}
                                                    class="rounded border-gray-300 text-main-bg focus:ring-main-bg">
                                                <span class="ml-2 text-sm text-gray-700">Benar</span>
                                            </label>
                                            <button type="button"
                                                class="remove-option rounded bg-red-600 px-3 py-2 text-xs text-white hover:bg-red-700"
                                                onclick="removeOption(this)">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-option-btn"
                            class="mt-2 rounded-lg bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                            + Tambah Opsi
                        </button>
                    </div>

                    <!-- Jawaban Essay -->
                    <div id="essay-answer" style="display: none;">
                        <label for="correct_answer_text" class="block text-sm font-medium text-gray-700">Jawaban (untuk Essay)</label>
                        <textarea name="correct_answer_text" id="correct_answer_text" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">{{ old('correct_answer_text', $question->correct_answer_text) }}</textarea>
                    </div>

                    <!-- Pembahasan -->
                    <div>
                        <label for="explanation" class="block text-sm font-medium text-gray-700">Pembahasan (Opsional)</label>
                        <textarea name="explanation" id="explanation" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">{{ old('explanation', $question->explanation) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" class="rounded-lg bg-main-bg px-6 py-2 text-white hover:bg-main-bg/80">
                        Update Soal
                    </button>
                    <a href="{{ route('admin.tryout.show', $tryout->tryout_id) }}"
                        class="rounded-lg bg-gray-200 px-6 py-2 text-gray-700 hover:bg-gray-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let optionCount = {{ $question->options ? $question->options->count() : 0 }};

        // Toggle tipe soal
        document.getElementById('question_type_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const typeName = selectedOption.getAttribute('data-type');

            const optionsContainer = document.getElementById('options-container');
            const essayAnswer = document.getElementById('essay-answer');

            if (typeName === 'Pilihan Ganda') {
                optionsContainer.style.display = 'block';
                essayAnswer.style.display = 'none';
                if (optionCount === 0) {
                    addOption();
                    addOption();
                }
            } else {
                optionsContainer.style.display = 'none';
                essayAnswer.style.display = 'block';
            }
        });

        // Tambah opsi
        document.getElementById('add-option-btn').addEventListener('click', function() {
            addOption();
        });

        function addOption() {
            optionCount++;
            const optionsList = document.getElementById('options-list');

            const optionDiv = document.createElement('div');
            optionDiv.className = 'mb-3 flex items-start gap-2 option-item';
            optionDiv.innerHTML = `
                <div class="flex-1">
                    <input type="text" 
                        name="options[${optionCount}][option_text]" 
                        placeholder="Teks Opsi ${optionCount}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                        required>
                </div>
                <div class="flex items-center gap-2">
                    <label class="flex items-center">
                        <input type="hidden" name="options[${optionCount}][is_correct]" value="0">
                        <input type="checkbox" 
                            name="options[${optionCount}][is_correct]" 
                            value="1"
                            class="rounded border-gray-300 text-main-bg focus:ring-main-bg">
                        <span class="ml-2 text-sm text-gray-700">Benar</span>
                    </label>
                    <button type="button" 
                        class="remove-option rounded bg-red-600 px-3 py-2 text-xs text-white hover:bg-red-700"
                        onclick="removeOption(this)">
                        Hapus
                    </button>
                </div>
            `;
            optionsList.appendChild(optionDiv);
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            optionItem.remove();
            const remaining = document.querySelectorAll('.option-item').length;
            if (remaining < 2) {
                alert('Minimal harus ada 2 opsi jawaban!');
                addOption();
            }
        }

        // Tampilkan sesuai tipe soal saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const questionTypeSelect = document.getElementById('question_type_id');
            questionTypeSelect.dispatchEvent(new Event('change'));
        });
    </script>
</x-app-layout>
