@props(['title', 'imageUrl'])

<div class="flex h-full flex-col rounded-lg bg-white p-6 pt-0">
    <div class="mb-6 flex items-center gap-4 rounded-xl border border-gray-200 p-4">

        <a href="{{ route('bank-soal.index') }}" class="rounded-full p-2 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>

        <div class="flex items-center gap-3">
            <img src="{{ $imageUrl }}" alt="Logo Tryout" class="h-12 w-12">
            <div>
                <h2 class="font-bold text-black">{{ $title }}</h2>
                <p class="text-sm text-black" x-text="totalQuestions + ' Soal'"></p>
            </div>
        </div>

    </div>

    <div class="rounded-xl border border-gray-200 p-4">
        <div class="mb-4 grid grid-cols-5 gap-3 rounded-xl">
            <template x-for="i in Array.from({ length: 50 }, (_, k) => k + 1)" :key="i">
                <button @click="changeQuestion(i - 1)"
                    class="flex h-10 w-10 items-center justify-center rounded-md font-bold transition-colors duration-200"
                    :class="{
                        'bg-main-bg/50 border border-main-bg text-black': getQuestionStatus(i) === 'active',
                        'bg-main-bg border border-main-bg text-white': getQuestionStatus(i) === 'answered',
                        'bg-white text-gray-700 border border-gray-200 hover:bg-gray-100': getQuestionStatus(
                            i) === 'unanswered'
                    }"
                    x-text="i">
                </button>
            </template>
        </div>

        <template x-if="mode === 'tryout'">
            <div class="mt-auto flex justify-end">
                <button @click="isModalOpen = true"
                    class="bg-main-blue-button rounded-lg px-8 py-3 font-bold text-white transition-colors duration-200 hover:bg-blue-700">
                    Kumpulkan
                </button>
            </div>
        </template>
    </div>
</div>
