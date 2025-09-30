<x-app-layout>
    <header class="mb-12 py-24 text-center md:mb-10"
        style="background-image: url('{{ asset('images/material-header-background.jpeg') }}'); background-size: cover; background-position: center;">
        <h1 class="text-sblack text-3xl font-extrabold md:text-3xl">
            Manajemen Bank Soal
        </h1>
    </header>

    <div class="container mx-auto px-4 sm:px-6 md:py-2 lg:px-8">
        <div class="bg-white p-6 md:p-8">
            <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Bank Soal</h2>
                <div class="flex gap-2">
                    <form action="{{ route('admin.questions') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari bank soal..."
                            class="rounded-l-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none ">
                        <button type="submit" class="rounded-r-lg bg-main-bg px-3 py-2 text-white ">Cari</button>
                    </form>
                    <a href="{{ route('admin.questions.create') }}"
                        class="inline-flex items-center rounded-lg bg-main-bg px-4 py-2 text-white hover:bg-main-bg/80">
                        Tambah Bank Soal
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Pertanyaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Tipe Soal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($questions as $question)
                            <tr x-data="{ open: false }">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $question->question_text }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $question->category->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $question->question_type_id == 1 ? 'Pilihan Ganda' : 'Isian Singkat' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.questions.edit', $question->question_id) }}"
                                            class="rounded bg-yellow-500 px-3 py-1 text-xs font-medium text-white hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $question->question_id) }}"
                                            method="POST" class="inline">
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
                            {{-- Baris detailnya --}}
                            <tr >
                                <td colspan="4" class="px-6 py-4 bg-gray-50 text-sm text-gray-700">
                                    @if ($question->question_type_id == 1)
                                        <p class="font-semibold mb-2">Pilihan Jawaban:</p>
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($question->options as $option)
                                                <li
                                                    @if ($option->is_correct) class="text-green-600 font-medium" @endif>
                                                    {{ $option->option_text }}
                                                    @if ($option->is_correct)
                                                        (Benar)
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p><span class="font-semibold">Jawaban Benar:</span>
                                            {{ $question->correct_answer_text }}</p>
                                    @endif
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
                {{ $questions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
