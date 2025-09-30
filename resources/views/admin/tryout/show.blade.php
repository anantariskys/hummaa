<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Detail Try Out
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">{{ $tryout->title }}</h2>
                <a href="{{ route('admin.tryout') }}"
                   class="inline-flex items-center rounded-lg bg-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-300">
                    Kembali
                </a>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-lg border p-4">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="text-lg font-semibold">{{ $tryout->category->name }}</p>
                </div>
                <div class="rounded-lg border p-4">
                    <p class="text-sm text-gray-500">Durasi</p>
                    <p class="text-lg font-semibold">{{ $tryout->duration_minutes }} menit</p>
                </div>
                <div class="rounded-lg border p-4">
                    <p class="text-sm text-gray-500">Tahun</p>
                    <p class="text-lg font-semibold">{{ $tryout->year }}</p>
                </div>
            </div>

            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Daftar Soal</h3>
                <a href="{{ route('admin.tryout', $tryout->tryout_id) }}"
                   class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-white hover:bg-main-bg/80">
                    Tambah Soal
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pertanyaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($questions as $index => $question)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $questions->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($question->question_text, 80) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $question->question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.tryout', [$tryout->tryout_id, $question->question_id]) }}"
                                           class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tryout', [$tryout->tryout_id, $question->question_id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700"
                                                    onclick="return confirm('Yakin ingin menghapus soal ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada soal untuk try out ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
              {{-- pagination link --}}
            <div class="mt-4">
                {{ $questions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
