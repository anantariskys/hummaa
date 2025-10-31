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
                               class="rounded-l-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none ">
                        <button type="submit"
                                class="rounded-r-lg bg-main-bg px-3 py-2 text-white ">Cari</button>
                    </form>
                    <a href="{{ route('admin.tryout.create') }}"
                       class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-white hover:bg-main-bg/80">
                        Tambah Try Out
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Durasi (menit)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($allTryout as $tryout)
                            <tr >
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $tryout->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $tryout->category->name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $tryout->duration_minutes }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $tryout->year }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.tryout.show', $tryout->tryout_id) }}"
                                           class="rounded bg-indigo-600 px-3 py-1 text-xs font-medium text-white hover:bg-indigo-700">
                                            Lihat
                                        </a>
                                        <a href="{{ route('admin.tryout.edit', $tryout->tryout_id) }}"
                                           class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tryout.destroy', $tryout->tryout_id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 border-b text-center text-sm text-gray-500">
                                    Tidak ada data try out ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- pagination link --}}
            <div class="mt-4">
                {{ $allTryout->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
