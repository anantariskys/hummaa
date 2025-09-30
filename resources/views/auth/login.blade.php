<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Masuk ke PPKIn
    </h1>

    <!-- Display error messages if any -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email">
                Email <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Alamat Email"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password">
                Password <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="************"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-main-bg shadow-sm focus:ring-main-bg" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="flex items-center my-4">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-4 text-xs text-gray-500">Atau</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <div>
            <x-google-button href="{{ route('auth.google') }}">
                {{ __('Masuk dengan Google') }}
            </x-google-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-gray-800 underline hover:text-main-bg">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>