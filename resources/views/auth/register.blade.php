<x-guest-layout>
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Daftar Akun Anda!
    </h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name">
                Nama Lengkap <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap"/>
            <p class="text-xs text-gray-500 mt-1">Masukan nama asli Anda, nama akan digunakan pada data sertifikat.</p>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email">
                Email <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Alamat Email"/>
            <p class="text-xs text-gray-500 mt-1">Gunakan alamat email aktif anda.</p>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password">
                Password <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="************"/>
            <p class="text-xs text-gray-500 mt-1">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation">
                Konfirmasi Password <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="************"/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full px-4 py-3 justify-center">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <div class="flex items-center my-4">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-4 text-xs text-gray-500">Atau</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <div>
            <x-google-button href="{{ route('auth.google') }}">
                {{ __('Daftar dengan Google') }}
            </x-google-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-gray-800 underline hover:text-main-bg">
                    Masuk Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
