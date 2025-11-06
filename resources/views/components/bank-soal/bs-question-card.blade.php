@props(['judul', 'jumlahSoal', 'tryoutUrl' => '#', 'belajarUrl' => '#', 'forumUrl' => '#', 'historyUrl' => '#'])

<div x-data="{ showModal: false, selectedMode: null }" class="w-full max-w-md overflow-hidden rounded-md border border-gray-200 bg-white shadow-lg">

    {{-- Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 bg-gray-100 p-5">
        <h3 class="text-lg font-semibold text-gray-900">
            {{ $judul }}
        </h3>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500">
                {{ $jumlahSoal }} Soal
            </span>

            <a href="{{ $historyUrl }}" title="Lihat Riwayat" class="text-main-bg transition-opacity duration-200 hover:opacity-75">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M5.604 5.604A10 10 0 1 1 18.926 18.926L17.866 17.866A8.5 8.5 0 1 0 6.134 6.134L5.604 5.604Z"
                        fill="currentColor" />
                </svg>
            </a>
        </div>
    </div>

    {{-- Body --}}
    <div class="flex flex-col gap-4 p-5">
        <div class="flex w-full gap-4">
            <button 
                @click="selectedMode = 'tryout'; showModal = true"
                class="bg-main-bg flex flex-1 items-center justify-center rounded-full px-4 py-3 font-semibold text-white transition-opacity duration-200 hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#00A991] focus:ring-offset-2">
                MODE TRYOUT
            </button>

            <button 
                @click="selectedMode = 'belajar'; showModal = true"
                class="border-main-bg text-main-bg flex flex-1 items-center justify-center rounded-full border bg-white px-4 py-3 font-semibold transition-colors duration-200 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-[#4285F4] focus:ring-offset-2">
                MODE BELAJAR
            </button>
        </div>

        <a href="{{ $forumUrl }}"
            class="border-main-bg text-main-bg flex w-full items-center justify-center rounded-full border bg-white px-4 py-3 font-semibold transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#00A991] focus:ring-offset-2">
            <svg viewBox="0 0 64 64" class="mr-2 h-5 w-5" fill="#2C7A7B">
                <path
                    d="M53,21H48V17a6,6,0,0,0-6-6H11a6,6,0,0,0-6,6V50a2,2,0,0,0,1.19,1.83A2.1,2.1,0,0,0,7,52a2,2,0,0,0,1.35-.52L18,42.7V46a6,6,0,0,0,6,6H45.42l10.51,6.69A2,2,0,0,0,57,59a1.94,1.94,0,0,0,1-.25A2,2,0,0,0,59,57V27A6,6,0,0,0,53,21ZM9,45.48V17a2,2,0,0,1,2-2H42a2,2,0,0,1,2,2V36a2,2,0,0,1-2,2H18a2,2,0,0,0-1.35.52Zm46,7.88-7.93-5A2,2,0,0,0,46,48H24a2,2,0,0,1-2-2V42H42a6,6,0,0,0,6-6V25h5a2,2,0,0,1,2,2Z">
                </path>
            </svg>
            FORUM DISKUSI
        </a>
    </div>

    {{-- Modal Konfirmasi --}}
    <div 
        x-show="showModal"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
    >
        <div 
            x-transition.scale.origin.center
            class="relative w-[90%] max-w-sm rounded-2xl bg-white p-6 shadow-2xl"
        >
            {{-- Icon --}}
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full"
                :class="selectedMode === 'tryout' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.5 8.5 0 1 0 0-17 8.5 8.5 0 0 0 0 17z" />
                </svg>
            </div>

            <h2 class="text-lg font-semibold text-gray-900 text-center mb-2">Konfirmasi</h2>
            <p class="text-gray-600 text-sm text-center mb-6" 
                x-text="selectedMode === 'tryout' 
                    ? 'Kamu akan memulai TRYOUT. Perhatian: Tryout hanya bisa diakses satu kali. Lanjutkan?' 
                    : 'Kamu akan masuk ke MODE BELAJAR. Lanjutkan sekarang?'">
            </p>

            <div class="flex justify-center gap-3">
                <button 
                    @click="showModal = false"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                    Batal
                </button>

                <a 
                    :href="selectedMode === 'tryout' ? '{{ $tryoutUrl }}' : '{{ $belajarUrl }}'"
                    class="px-4 py-2 rounded-lg font-semibold text-white transition-colors duration-150"
                    :class="selectedMode === 'tryout' ? 'bg-red-600 hover:bg-red-700' : 'bg-main-bg hover:opacity-90'">
                    Ya, Lanjutkan
                </a>
            </div>

            {{-- Tombol Close pojok kanan --}}
            <button @click="showModal = false"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

</div>
