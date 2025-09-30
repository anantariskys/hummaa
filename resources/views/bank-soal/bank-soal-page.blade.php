@extends('layouts.bank-soal-layout')

@section('content')
    <div class="container mx-auto p-4 md:p-8">
        <div x-data="{ activeTab: 'home' }" class="flex flex-col md:flex-row md:space-x-8">

            <aside class="mb-6 w-full md:mb-0 md:w-1/4">
                <div class="rounded-xl border border-gray-300 bg-white p-4 shadow-2xl">
                    <h2 class="mb-2 px-3 pb-4 text-xl font-extrabold text-gray-800">
                        KELOMPOK <span class="text-main-bg">SOAL</span>
                    </h2>

                    @foreach ($categories as $category)
                        <a href="#" @click.prevent="activeTab = '{{ $category->name }}'"
                            :class="{ 'bg-main-blue-button/50 border-l-4 border-main-blue-button text-white': activeTab === '{{ $category->name }}', 'text-gray-800 hover:bg-gray-100': activeTab !== '{{ $category->name }}' }"
                            class="flex w-full items-center border-b border-b-gray-200 p-3 text-left transition-colors duration-200">
                            <div class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full"
                                :class="{ 'bg-main-blue-button': activeTab === '{{ $category->name }}', 'bg-gray-200': activeTab !== '{{ $category->name }}' }">
                                <x-bank-soal.book-icon />
                            </div>
                            <span class="text-base font-semibold">Bank Soal {{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>

            <div class="w-full md:w-3/4 md:pl-5">
                <div x-show="activeTab === 'home'" x-transition.opacity>
                    @include('bank-soal.landing-content')
                </div>

                @foreach ($categories as $category)
                    <div x-show="activeTab === '{{ $category->name }}'" x-transition.opacity style="display: none;">
                        <x-bank-soal.bs-content title="Bank Soal {{ $category->name }}"
                            description="{{ $category->description }}"
                            :filters="$filters">

                            <x-slot:icon>
                                <div class="mr-4 p-3">
                                    <img src="{{ asset($category->logo_url) }}" alt="logo" class="h-14 w-14">
                                </div>
                            </x-slot:icon>

                            @forelse ($category->tryouts as $tryout)
                                <x-bank-soal.bs-question-card judul="{{ $tryout->title }}"
                                    jumlahSoal="{{ $tryout->questions()->count() }}"
                                    tryoutUrl="{{ route('tryout.start', $tryout->tryout_id) }}"
                                    belajarUrl="{{ route('tryout.learn', ['tryout_id' => $tryout->tryout_id, 'mode' => 'belajar']) }}"
                                    historyUrl="{{ route('tryout.history', ['tryout_id' => $tryout->tryout_id])}}" 
                                    forumUrl="{{ route('forum', ['tryout_id' => $tryout->tryout_id]) }}"
                                />
                            @empty
                                <p class="text-center text-gray-500">Belum ada paket tryout untuk kategori ini.</p>
                            @endforelse

                        </x-bank-soal.bs-content>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
