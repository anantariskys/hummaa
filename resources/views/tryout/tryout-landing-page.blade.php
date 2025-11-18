@extends('layouts.tryout-layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Daftar Event Tryout</h1>
        <p class="text-gray-600">Latihan seperti ujian sebenarnya! Tryout interaktif untuk mengukur kemampuan dan memperbaiki strategi belajarmu.</p>
    </div>

    <!-- Daftar Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tryouts as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <!-- Icon & Title -->
                    <div class="flex items-center mb-4">
                        <div class="mr-4 p-3 bg-blue-100 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $event->tryout->questions->count() }} Soal</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>

                    <!-- Info -->
                    <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $event->tryout->duration_minutes }} menit
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Tahun {{ $event->tryout->year }}
                        </span>
                    </div>

                    <!-- Tombol Dinamis -->
                    @if($event->is_registered)
                        <!-- Jika sudah terdaftar: tombol disabled -->
                        <button 
                            disabled
                            class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sudah Terdaftar
                        </button>
                    @else
                        <!-- Jika belum terdaftar: tombol daftar -->
                        <button 
                            onclick="registerEvent({{ $event->id }}, this)"
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Daftar Tryout
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada event tryout</h3>
                <p class="mt-1 text-sm text-gray-500">Event tryout akan segera tersedia.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- CSRF Token untuk AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function registerEvent(eventId, button) {
    // Disable button saat proses
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch(`/event/${eventId}/register`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Ubah tombol jadi disabled dengan tanda sukses
            button.className = 'w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed flex items-center justify-center gap-2';
            button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Sudah Terdaftar';
            
            // Tampilkan notifikasi sukses
            showNotification(data.message, 'success');
        } else {
            // Re-enable button jika gagal
            button.disabled = false;
            button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Daftar Tryout';
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.disabled = false;
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Daftar Tryout';
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection