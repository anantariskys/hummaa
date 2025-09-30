@props([
    'title',
    'description',
    'status',
    'duration',
    'fileSize',
    'progress' => 0,
    'viewLink' => '#',
    'downloadLink' => '#',
])

@php
    $statusClass = match (strtolower($status)) {
        'selesai' => 'bg-green-100 text-main-bg',
        'progres' => 'bg-orange/30 text-orange',
        default => 'bg-gray-100 text-gray-800',
    };

    $progressClass = match (strtolower($status)) {
        'selesai' => 'bg-main-blue-button',
        'progres' => 'bg-orange',
        default => 'bg-gray-500',
    };
@endphp

<div class="hover:shadow-3xl rounded-xl border border-gray-200 p-4 shadow-xl transition hover:border-indigo-300 md:p-5">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center p-3">
                <img src="{{ asset('images/material-book-logo.png') }}" alt="Logo Buku Materi">
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">{{ $title }}</h3>
                <p class="text-sm text-gray-500">{{ $description }}</p>
            </div>
        </div>
        <span
            class="{{ $statusClass }} flex-shrink-0 rounded-full px-3 py-1 text-xs font-medium">{{ $status }}</span>
    </div>
    <div class="mt-4 border-t border-gray-200 pt-4">
        <div class="flex flex-col justify-between gap-4 text-sm text-gray-600 sm:flex-row sm:items-center">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $duration }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    {{ $fileSize }}
                </span>
            </div>
            <div class="flex items-center gap-x-4">
                <a href="{{ $viewLink }}"
                    class="hover:text-main-blue-button flex items-center gap-1.5 rounded-full border border-gray-200 px-4 py-2 transition">
                    <img src="{{ asset('images/eye-logo.svg') }}" alt="Logo lihat" class="h-5 w-5">
                    Lihat
                </a>
                <a href="{{ $downloadLink }}"
                    class="hover:text-main-blue-button flex items-center gap-1.5 rounded-full border border-gray-200 px-4 py-2 transition" download>
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        stroke="#000000" stroke-width="0.00024000000000000003">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M11 3.01254C10.9983 2.46026 11.4446 2.01114 11.9969 2.00941C12.5492 2.00768 12.9983 2.45399 13 3.00627L11 3.01254Z"
                                fill="#000000"></path>
                            <path
                                d="M14.3158 10.2951L13.0269 11.592L13 3.00627L11 3.01254L11.0269 11.5983L9.73003 10.3095C9.33828 9.92018 8.7051 9.92214 8.3158 10.3139C7.9265 10.7056 7.92849 11.3388 8.32024 11.7281L8.32275 11.7306L8.32374 11.7316L12.039 15.4236L15.7206 11.7187L15.7262 11.7131L15.727 11.7123L15.7278 11.7115L15.7337 11.7056L15.7344 11.7049L14.3158 10.2951Z"
                                fill="#000000"></path>
                            <path
                                d="M15.7344 11.7049C16.1237 11.3131 16.1217 10.6799 15.73 10.2906C15.3382 9.90134 14.705 9.90335 14.3158 10.2951L15.7344 11.7049Z"
                                fill="#000000"></path>
                            <path
                                d="M4 12C4 10.8954 4.89543 10 6 10C6.55228 10 7 9.55228 7 9C7 8.44771 6.55228 8 6 8C3.79086 8 2 9.79086 2 12V18C2 20.2091 3.79086 22 6 22H17C19.7614 22 22 19.7614 22 17V12C22 9.79086 20.2091 8 18 8C17.4477 8 17 8.44771 17 9C17 9.55228 17.4477 10 18 10C19.1046 10 20 10.8954 20 12V17C20 18.6569 18.6569 20 17 20H6C4.89543 20 4 19.1046 4 18V12Z"
                                fill="#000000"></path>
                        </g>
                    </svg>
                    Download
                </a>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-3">
            <span class="text-sm font-medium text-gray-700">Progres</span>
            <div class="h-2 w-full rounded-full bg-gray-200">
                <div class="{{ $progressClass }} h-2 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
            <span
                class="{{ str_replace(['bg-', '-500', '-600'], ['text-', '-600', '-700'], $progressClass) }} text-sm font-medium">{{ $progress }}%</span>
        </div>
    </div>
</div>
