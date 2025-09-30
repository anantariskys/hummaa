<div class="relative bg-white md:pt-44 md:pb-44 pt-12 pb-12">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img class="h-full w-full object-cover" src="{{ asset('images/header.png') }}" alt="Background">
        <div class="absolute inset-0 bg-white/30"></div>
    </div>

    <!-- Content -->
    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                Platform Belajar Online untuk Calon ASN PPPK
            </h1>
            <p class="mt-6 text-sm md:text-lg leading-8 text-gray-600">
                PPPKin hadir sebagai solusi belajar modern untuk kamu yang sedang berjuang menjadi ASN. Mulai dari materi lengkap, latihan soal, tryout online, sampai forum diskusi interaktif.
            </p>
            <div class="mt-10">
                @guest
                    <a href="{{ route('register') }}"
                       class="inline-block rounded-md bg-main-bg px-4 py-2 text-base font-semibold text-white shadow-sm
                       hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                       focus-visible:outline-teal-600 transition-colors duration-300">
                        Daftar Sekarang
                    </a>
                @endguest

                @auth
                        <a href="{{ route('materials.index') }}"
                           class="inline-block rounded-md bg-main-bg px-4 py-2 text-base font-semibold text-white shadow-sm
                           hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
                           focus-visible:outline-teal-600 transition-colors duration-300">
                            Belajar Sekarang
                        </a>
                @endauth

            </div>
        </div>
    </div>
</div>
