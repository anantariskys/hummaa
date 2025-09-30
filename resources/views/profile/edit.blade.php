<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Di sini kita ubah max-w-7xl menjadi max-w-4xl --}}
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('profile.partials.update-profile-information-form')

        </div>
    </div>
</x-app-layout>
