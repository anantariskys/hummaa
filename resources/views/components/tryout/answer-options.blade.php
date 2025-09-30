{{-- File ini sekarang berfungsi sebagai "partial", tidak perlu @props --}}
<div
    {{-- Panggil `selectAnswer` dengan variabel `key` dan `optionId` dari x-data --}}
    @click="mode === 'tryout' ? selectAnswer(key, optionId) : null"
    class="flex items-center justify-between gap-4 rounded-lg border p-2 transition-colors"
    :class="{
        'cursor-pointer hover:border-main-bg': mode === 'tryout',
        'cursor-default': mode === 'belajar',
        'bg-main-bg/40 border-main-bg text-white': mode === 'belajar' && currentQuestion.correctAnswer === key,
        'bg-red-300 border-red-500 text-white': mode === 'belajar' && answers[currentQuestion.id] && answers[currentQuestion.id].key === key && currentQuestion.correctAnswer !== key,
        'bg-main-bg/50 border-main-bg text-white': mode === 'tryout' && answers[currentQuestion.id] && answers[currentQuestion.id].key === key
    }"
>
    <div class="flex items-center gap-4">
        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-md border border-ujian-gray-200 bg-white text-sm font-bold text-black"
             :class="{
                '!border-red-600 !bg-red-600 text-white': mode === 'belajar' && answers[currentQuestion.id] && answers[currentQuestion.id].key === key && currentQuestion.correctAnswer !== key,
                '!border-main-bg !bg-main-bg text-white': mode === 'belajar' && currentQuestion.correctAnswer === key,
                '!border-main-bg/90 !bg-main-bg/90 text-white': mode === 'tryout' && answers[currentQuestion.id] && answers[currentQuestion.id].key === key
             }">
            {{-- `key` di sini diwarisi dari `x-data` di atasnya --}}
            <span x-text="key"></span>
        </div>
        {{-- `text` di sini diwarisi dari `x-data` di atasnya --}}
        <p class="text-sm font-normal" x-text="text"></p>
    </div>

    <template x-if="mode === 'belajar'">
        <div>
            <svg x-show="currentQuestion.correctAnswer === key" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-main-bg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="answers[currentQuestion.id] && answers[currentQuestion.id].key === key && currentQuestion.correctAnswer !== key" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </template>
</div>