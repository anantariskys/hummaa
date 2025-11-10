<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Manajemen Materi
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            
            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Materi</h2>
                <div class="flex gap-2">
                    <form action="{{ route('admin.materials.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               placeholder="Cari materi..."
                               class="rounded-l-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none">
                        <button type="submit"
                                class="rounded-r-lg bg-main-bg px-3 py-2 text-white hover:bg-main-bg/80">
                            Cari
                        </button>
                    </form>
                    <a href="{{ route('admin.materials.create') }}"
                       class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-white hover:bg-main-bg/80">
                        Tambah Materi
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Ukuran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aktif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($allMateri as $materi)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $materi->title }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($materi->description, 60) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                        {{ $materi->status === 'Selesai' ? 'bg-green-100 text-green-800' : 
                                           ($materi->status === 'Progres' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $materi->status }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $materi->duration }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $materi->file_size ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                                        {{ $materi->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $materi->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($materi->file_path)
                                            <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank"
                                               class="rounded bg-indigo-600 px-3 py-1 text-xs font-medium text-white hover:bg-indigo-700">
                                                Lihat
                                            </a>
                                            <a href="{{ route('materials.download', $materi->id) }}"
                                               class="rounded bg-green-600 px-3 py-1 text-xs font-medium text-white hover:bg-green-700">
                                                Unduh
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.materials.edit', $materi->id) }}"
                                           class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.materials.destroy', $materi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700"
                                                    onclick="return confirm('Yakin ingin menghapus materi ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data materi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $allMateri->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>