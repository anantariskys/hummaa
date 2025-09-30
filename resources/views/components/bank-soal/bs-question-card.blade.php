@props(['judul', 'jumlahSoal', 'tryoutUrl' => '#', 'belajarUrl' => '#', 'forumUrl' => '#', 'historyUrl' => '#'])

<div class="w-full max-w-md overflow-hidden rounded-md border border-gray-200 bg-white shadow-lg">

    <div class="flex items-center justify-between border-b border-gray-200 bg-gray-100 p-5">
        <h3 class="text-lg font-semibold text-gray-900">
            {{ $judul }}
        </h3>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500">
                {{ $jumlahSoal }} Soal
            </span>
        
            <a href="{{ $historyUrl }}" title="Lihat Riwayat" class="text-main-bg transition-opacity duration-200 hover:opacity-75">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                         <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                    <path d="M5.60414 5.60414L5.07381 5.07381V5.07381L5.60414 5.60414ZM4.33776 6.87052L3.58777 6.87429C3.58984 7.28556 3.92272 7.61844 4.33399 7.62051L4.33776 6.87052ZM6.87954 7.6333C7.29375 7.63539 7.63122 7.30129 7.6333 6.88708C7.63538 6.47287 7.30129 6.1354 6.88708 6.13332L6.87954 7.6333ZM5.07496 4.3212C5.07288 3.90699 4.73541 3.5729 4.3212 3.57498C3.90699 3.57706 3.5729 3.91453 3.57498 4.32874L5.07496 4.3212ZM3.82661 10.7849C3.88286 10.3745 3.59578 9.99627 3.1854 9.94002C2.77503 9.88377 2.39675 10.1708 2.3405 10.5812L3.82661 10.7849ZM18.8622 5.13777C15.042 1.31758 8.86873 1.27889 5.07381 5.07381L6.13447 6.13447C9.33358 2.93536 14.5571 2.95395 17.8016 6.19843L18.8622 5.13777ZM5.13777 18.8622C8.95796 22.6824 15.1313 22.7211 18.9262 18.9262L17.8655 17.8655C14.6664 21.0646 9.44291 21.0461 6.19843 17.8016L5.13777 18.8622ZM18.9262 18.9262C22.7211 15.1313 22.6824 8.95796 18.8622 5.13777L17.8016 6.19843C21.0461 9.44291 21.0646 14.6664 17.8655 17.8655L18.9262 18.9262ZM5.07381 5.07381L3.80743 6.34019L4.86809 7.40085L6.13447 6.13447L5.07381 5.07381ZM4.33399 7.62051L6.87954 7.6333L6.88708 6.13332L4.34153 6.12053L4.33399 7.62051ZM5.08775 6.86675L5.07496 4.3212L3.57498 4.32874L3.58777 6.87429L5.08775 6.86675ZM2.3405 10.5812C1.93907 13.5099 2.87392 16.5984 5.13777 18.8622L6.19843 17.8016C4.27785 15.881 3.48663 13.2652 3.82661 10.7849L2.3405 10.5812Z" fill="currentColor"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="flex flex-col gap-4 p-5">
        <div class="flex w-full gap-4">
            <a href="{{ $tryoutUrl }}"
                class="bg-main-bg flex flex-1 items-center justify-center rounded-full px-4 py-3 font-semibold text-white transition-opacity duration-200 hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#00A991] focus:ring-offset-2">
                MODE TRYOUT
            </a>

            <a href="{{ $belajarUrl }}"
                class="border-main-bg text-main-bg flex flex-1 items-center justify-center rounded-full border bg-white px-4 py-3 font-semibold transition-colors duration-200 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-[#4285F4] focus:ring-offset-2">
                MODE BELAJAR
            </a>
        </div>

        <a href="{{ $forumUrl }}"
            class="border-main-bg text-main-bg flex w-full items-center justify-center rounded-full border bg-white px-4 py-3 font-semibold transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#00A991] focus:ring-offset-2">
            <svg viewBox="0 0 64 64" class="mr-2 h-5 w-5" id="icons" xmlns="http://www.w3.org/2000/svg" fill="#2C7A7B">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #2C7A7B;
                            }
                        </style>
                    </defs>
                    <title></title>
                    <path class="cls-1"
                        d="M53,21H48V17a6,6,0,0,0-6-6H11a6,6,0,0,0-6,6V50a2,2,0,0,0,1.19,1.83A2.1,2.1,0,0,0,7,52a2,2,0,0,0,1.35-.52L18,42.7V46a6,6,0,0,0,6,6H45.42l10.51,6.69A2,2,0,0,0,57,59a1.94,1.94,0,0,0,1-.25A2,2,0,0,0,59,57V27A6,6,0,0,0,53,21ZM9,45.48V17a2,2,0,0,1,2-2H42a2,2,0,0,1,2,2V36a2,2,0,0,1-2,2H18a2,2,0,0,0-1.35.52Zm46,7.88-7.93-5A2,2,0,0,0,46,48H24a2,2,0,0,1-2-2V42H42a6,6,0,0,0,6-6V25h5a2,2,0,0,1,2,2Z">
                    </path>
                </g>
            </svg>
            FORUM DISKUSI
        </a>
    </div>

</div>