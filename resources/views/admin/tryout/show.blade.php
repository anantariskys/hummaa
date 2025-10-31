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
                <a href="{{ route('admin.tryout.index') }}"
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

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4">
                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Daftar Soal</h3>
                <a href="{{ route('admin.tryout.questions.create', $tryout->tryout_id) }}"
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
                        @forelse ($questions as $question)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $question->question_number }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($question->question_text, 80) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $question->questionType ? ucfirst(str_replace('_', ' ', $question->questionType->type)) : '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.tryout.questions.edit', [$tryout->tryout_id, $question->question_id]) }}"
                                           class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tryout.questions.destroy', [$tryout->tryout_id, $question->question_id]) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700">
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
            
            {{-- Pagination link --}}
            @if($questions->hasPages())
                <div class="mt-4">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>