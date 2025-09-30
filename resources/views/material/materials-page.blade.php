<x-app-layout>
    
    <header class="mb-12 py-24 text-center md:mb-16"
            style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
            
            <h1 class="text-sblack text-3xl font-extrabold md:text-3xl"> 
                Bangun Fondasi <span class="text-main-bg">Suksesmu</span> Jadi<br> PPPK Lewat
                <span class="text-main-bg">Penguasaan Materi!</span>
            </h1>
            <p class="text-sblack/60 mx-auto mt-4 max-w-3xl text-base md:text-lg"> 
                Materi terarah dan relevan untuk membantu kamu memahami setiap topik penting dan siap menghadapi
                soal-soal dengan percaya diri.
            </p>
        </header>
        
        <div class="container mx-auto px-4 py-12 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Materi</h2>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari"
                        class="w-full rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 md:w-64">
                </div>
            </div>

            <div class="space-y-5">
                <div class="space-y-5">
                    @foreach ($allMateri as $materi)
                        <x-materials.materials-card 
                            :title="$materi['title']"
                            :description="$materi['description']"
                            :status="$materi['status']"
                            :duration="$materi['duration']"
                            :fileSize="$materi['fileSize']"
                            :progress="$materi['progress']"
                            :viewLink="asset('storage/' . $materi['file_path'])"
                            :downloadLink="asset('storage/' . $materi['file_path'])"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
