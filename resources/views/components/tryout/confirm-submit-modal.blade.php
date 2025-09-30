<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" {{-- Sembunyikan secara default untuk mencegah flicker --}}>
    <div @click="isModalOpen = false" class="fixed inset-0 bg-black/60"></div>

    <div class="relative w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
        <h3 class="text-xl font-bold text-gray-800">Kumpulkan Tryout?</h3>
        <p class="mt-2 text-gray-600">
            Anda telah menjawab <span x-text="Object.keys(answers).length"></span> dari <span
                x-text="totalQuestions"></span> pertanyaan. Seluruh pertanyaan sudah dijawab. Apakah Anda yakin ingin
            mengirim ujian Anda?
        </p>

        <div class="mt-6 flex justify-end space-x-3">
            <button @click="isModalOpen = false" type="button"
                class="rounded-lg border border-gray-300 bg-white px-6 py-2 font-semibold text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Kembali
            </button>
            <button @click="submitExam()" {{-- Memanggil fungsi untuk submit --}} type="button"
                class="bg-main-blue-button focus:ring-main-blue-button rounded-lg px-6 py-2 font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2">
                Kumpulkan
            </button>
        </div>
    </div>
</div>
