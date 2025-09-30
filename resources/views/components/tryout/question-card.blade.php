<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
    <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
        <div>
            <h2 class="font-bold text-black">
                <span x-show="mode === 'tryout'">Pertanyaan <span x-text="currentIndex + 1"></span> dari <span
                        x-text="totalQuestions"></span></span>
                <span x-show="mode === 'belajar'">Mode Belajar: Soal #<span x-text="currentIndex + 1"></span></span>
            </h2>
            <p class="text-sm text-gray-500"
                x-text="mode === 'tryout' ? 'Silahkan jawab pertanyaan di bawah' : 'Jawaban & pembahasan akan muncul otomatis'">
            </p>
        </div>

        <template x-if="mode === 'tryout'">
            <div class="flex items-center gap-2 rounded-lg bg-red-100 px-4 py-2 text-lg font-bold text-red-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span x-text="formatTime()"></span>
            </div>
        </template>
    </div>

    <div x-show="currentQuestion">
        <template x-if="currentQuestion.image">
            <div class="mb-6"><img :src="currentQuestion.image" alt="Ilustrasi Soal"
                    class="mx-auto max-h-72 w-full rounded-lg object-contain"></div>
        </template>
        <p class="mb-6 text-gray-700" x-text="currentQuestion.text"></p>
    </div>

    <div class="mb-8 space-y-3">
        <template x-if="currentQuestion && currentQuestion.type === 'pilihan_ganda'">
            <div class="space-y-3" :key="currentQuestion.id">
                <template x-for="(optionData, optionKey) in currentQuestion.options" :key="optionKey">
                    <div @click="mode === 'tryout' || !answers[currentQuestion.id] ? selectAnswer(optionKey, optionData.id) : null"
                        class="flex items-center justify-between gap-4 rounded-lg border p-2 transition-colors"
                        :class="{
                            'cursor-pointer hover:border-main-bg': mode === 'tryout' || !answers[currentQuestion.id],
                            'cursor-default': mode === 'belajar' && answers[currentQuestion.id],
                            'bg-red-300 border-red-500 text-white': mode === 'belajar' && answers[currentQuestion
                                    .id] && answers[currentQuestion.id].key === optionKey && currentQuestion
                                .correctAnswer !== optionKey,
                            'border-main-bg bg-main-bg/40 text-white': mode === 'belajar' && answers[currentQuestion
                                .id] && currentQuestion.correctAnswer === optionKey,
                            'border-main-bg bg-main-bg/50 text-white': answers[currentQuestion.id] && answers[
                                currentQuestion.id].key === optionKey
                        }">
                        <div class="flex items-center gap-4">
                            <div class="border-ujian-gray-200 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md border bg-white text-sm font-bold text-black"
                                :class="{
                                    '!border-main-bg !bg-main-bg text-white': mode === 'belajar' && answers[
                                        currentQuestion.id] && currentQuestion.correctAnswer === optionKey,
                                    '!border-red-600 !bg-red-600 text-white': mode === 'belajar' && answers[
                                            currentQuestion.id] && answers[currentQuestion.id] && answers[
                                            currentQuestion.id].key === optionKey && currentQuestion.correctAnswer !==
                                        optionKey,
                                    '!border-main-bg/90 !bg-main-bg/90 text-white': answers[currentQuestion.id] &&
                                        answers[currentQuestion.id].key === optionKey
                                }">
                                <span x-text="optionKey"></span>
                            </div>
                            <p class="text-sm font-normal" x-text="optionData.text"></p>
                        </div>

                        <template x-if="mode === 'belajar' && answers[currentQuestion.id]">
                            <div>
                                <svg x-show="currentQuestion.correctAnswer === optionKey" class="text-main-bg h-6 w-6"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg x-show="answers[currentQuestion.id] && answers[currentQuestion.id].key === optionKey && currentQuestion.correctAnswer !== optionKey"
                                    class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="currentQuestion && currentQuestion.type === 'isian'">
            <div x-init="if (!answers[currentQuestion.id]) { answers[currentQuestion.id] = { text: '' } }">

                <label for="jawaban_isian" class="text-sm font-bold text-gray-700">Jawaban kamu:</label>

                <textarea id="jawaban_isian" rows="4"
                    class="focus:border-main-blue-button focus:ring-main-blue-button mt-2 block w-full rounded-lg border border-gray-200 p-1"
                    placeholder="Ketik jawaban disini..." x-model="answers[currentQuestion.id].text"
                    @input.debounce.500ms="mode === 'tryout' ? selectAnswer(null, null, $event.target.value) : null">
                </textarea>

                <div x-show="mode === 'belajar' && !feedbackShown[currentQuestion.id]" class="mt-4">
                    <button
                        @click="feedbackShown[currentQuestion.id] = true; selectAnswer(null, null, answers[currentQuestion.id].text)"
                        class="bg-main-blue-button rounded-lg px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
                        Periksa Jawaban
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div class="flex justify-between">
    </div>

    <template
        x-if="
    mode === 'belajar' && 
    (
        (currentQuestion.type === 'pilihan_ganda' && answers[currentQuestion.id]) || 
        (currentQuestion.type === 'isian' && feedbackShown && feedbackShown[currentQuestion.id])
    )
">
        <div class="mt-8 rounded-lg border border-gray-200 p-4">
            <h3 class="font-bold text-gray-800">Pembahasan</h3>

            <div x-show="currentQuestion.type === 'isian'" class="mb-3">
                <p class="text-sm font-semibold text-gray-700">Kunci Jawaban:</p>
                <p class="mt-1 rounded-md bg-green-100 p-2 text-sm text-gray-800"
                    x-text="currentQuestion.correctAnswer"></p>
            </div>

            <p class="mt-2 text-gray-600" x-text="currentQuestion.explanation"></p>
        </div>
    </template>
</div>
