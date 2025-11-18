<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Manajemen Try Out
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Try Out</h2>
                <div class="flex gap-2">
                    <form action="{{ route('admin.tryout.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Cari try out..."
                               class="rounded-l-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none">
                        <button type="submit"
                                class="rounded-r-lg bg-main-bg px-3 py-2 text-white">Cari</button>
                    </form>
                    <a href="{{ route('admin.tryout.create') }}"
                       class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-white hover:bg-main-bg/80">
                        Tambah Try Out
                    </a>
                </div>
            </div>

            <!-- Alert untuk info penting -->
            <div class="mb-4 rounded-lg bg-blue-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Info:</strong> Tryout hanya akan muncul di Bank Soal user setelah mereka mendaftar event yang terhubung.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($allTryout as $tryout)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $tryout->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($tryout->event_id && $tryout->event)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                            <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $tryout->event->title }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                            <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            Tidak ada event
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $tryout->category->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $tryout->duration_minutes }} menit
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $tryout->year }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.tryout.show', $tryout->tryout_id) }}"
                                           class="rounded bg-indigo-600 px-3 py-1 text-xs font-medium text-white hover:bg-indigo-700"
                                           title="Lihat Detail & Soal">
                                            Lihat
                                        </a>
                                        <a href="{{ route('admin.tryout.edit', $tryout->tryout_id) }}"
                                           class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600"
                                           title="Edit Try Out">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tryout.destroy', $tryout->tryout_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700"
                                                    onclick="return confirm('⚠️ Yakin ingin menghapus tryout ini?\n\nPeringatan:\n- Semua soal akan ikut terhapus\n- User yang sudah mendaftar tidak akan bisa mengakses lagi\n\nLanjutkan?')"
                                                    title="Hapus Try Out">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada try out</h3>
                                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat try out pertama Anda.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('admin.tryout.create') }}"
                                           class="inline-flex items-center rounded-md bg-main-bg px-4 py-2 text-sm font-medium text-white hover:bg-main-bg/80">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                            </svg>
                                            Tambah Try Out
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $allTryout->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>