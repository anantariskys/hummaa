<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Tambah Soal Try Out
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

            <form action="{{ route('admin.tryout.questions.store', $tryout->tryout_id) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Nomor Soal -->
                    <div>
                        <label for="question_number" class="block text-sm font-medium text-gray-700">Nomor Soal</label>
                        <input type="number" name="question_number" id="question_number" 
                               value="{{ old('question_number', $nextQuestionNumber) }}"
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
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            @foreach($questionTypes as $type)
                                <option value="{{ $type->id }}" 
                                        data-type="{{ $type->type }}"
                                        {{ old('question_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $type->type)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <textarea name="question_text" id="question_text" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg" 
                                  required>{{ old('question_text') }}</textarea>
                    </div>

                    <!-- Image URL (Optional) -->
                    <div>
                        <label for="image_url" class="block text-sm font-medium text-gray-700">URL Gambar (Opsional)</label>
                        <input type="url" name="image_url" id="image_url" 
                               value="{{ old('image_url') }}"
                               placeholder="https://example.com/image.jpg"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">
                    </div>

                    <!-- Opsi Jawaban (untuk multiple choice) -->
                    <div id="options-container" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Opsi Jawaban</label>
                        <div id="options-list">
                            <!-- Options will be added here dynamically -->
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
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">{{ old('correct_answer_text') }}</textarea>
                    </div>

                    <!-- Pembahasan -->
                    <div>
                        <label for="explanation" class="block text-sm font-medium text-gray-700">Pembahasan (Opsional)</label>
                        <textarea name="explanation" id="explanation" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg">{{ old('explanation') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" 
                            class="rounded-lg bg-main-bg px-6 py-2 text-white hover:bg-main-bg/80">
                        Simpan Soal
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
        let optionCount = 0;

        // Toggle options/essay based on question type
        document.getElementById('question_type_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const typeName = selectedOption.getAttribute('data-type');
            
            const optionsContainer = document.getElementById('options-container');
            const essayAnswer = document.getElementById('essay-answer');
            
            if (typeName === 'multiple_choice') {
                optionsContainer.style.display = 'block';
                essayAnswer.style.display = 'none';
                
                // Add initial options if empty
                if (optionCount === 0) {
                    addOption();
                    addOption();
                }
            } else {
                optionsContainer.style.display = 'none';
                essayAnswer.style.display = 'block';
            }
        });

        // Add option button
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
                <input type="hidden" name="options[${optionCount}][is_correct]" value="0">
            `;
            
            optionsList.appendChild(optionDiv);
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            optionItem.remove();
            
            // Re-count remaining options
            const remainingOptions = document.querySelectorAll('.option-item').length;
            if (remainingOptions < 2) {
                alert('Minimal harus ada 2 opsi jawaban!');
                addOption();
            }
        }

        // Restore old input if validation fails
        @if(old('question_type_id'))
            document.addEventListener('DOMContentLoaded', function() {
                const questionTypeSelect = document.getElementById('question_type_id');
                questionTypeSelect.dispatchEvent(new Event('change'));
                
                @if(old('options'))
                    // Restore old options
                    const oldOptions = @json(old('options'));
                    const optionsList = document.getElementById('options-list');
                    optionsList.innerHTML = ''; // Clear default options
                    optionCount = 0;
                    
                    Object.keys(oldOptions).forEach(key => {
                        optionCount++;
                        const option = oldOptions[key];
                        const optionDiv = document.createElement('div');
                        optionDiv.className = 'mb-3 flex items-start gap-2 option-item';
                        optionDiv.innerHTML = `
                            <div class="flex-1">
                                <input type="text" 
                                       name="options[${optionCount}][option_text]" 
                                       value="${option.option_text || ''}"
                                       placeholder="Teks Opsi ${optionCount}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-main-bg focus:ring-main-bg"
                                       required>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="options[${optionCount}][is_correct]" 
                                           value="1"
                                           ${option.is_correct == '1' ? 'checked' : ''}
                                           class="rounded border-gray-300 text-main-bg focus:ring-main-bg">
                                    <span class="ml-2 text-sm text-gray-700">Benar</span>
                                </label>
                                <button type="button" 
                                        class="remove-option rounded bg-red-600 px-3 py-2 text-xs text-white hover:bg-red-700"
                                        onclick="removeOption(this)">
                                    Hapus
                                </button>
                            </div>
                            <input type="hidden" name="options[${optionCount}][is_correct]" value="0">
                        `;
                        optionsList.appendChild(optionDiv);
                    });
                @endif
            });
        @endif
    </script>
</x-app-layout>