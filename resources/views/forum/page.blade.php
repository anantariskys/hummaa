<x-app-layout>
    <div class="bg-gray-50 flex justify-center w-full">
        <div class="p-12 w-full max-w-5xl">
            <main class="space-y-6 lg:col-span-3">
                <form
                    action="{{ route('discussions.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
                >
                    @csrf
                    {{-- TITLE --}}
                    <div>
                        <label class="mb-1 block text-md text-black font-semibold -mt-4">Judul</label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Tuliskan judul/topik diskusi"
                            class="w-full rounded-md border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            required
                        >
                        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- DESC --}}
                    <div>
                        <label class="mb-1 block text-md text-black font-semibold">Deskripsi</label>
                        <textarea
                            name="desc"
                            rows="4"
                            placeholder="Tulis deskripsi atau pertanyaan di sini..."
                            class="w-full rounded-md border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                        >{{ old('desc') }}</textarea>
                        @error('desc') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- IMAGE --}}
                    <div>
                        <label class="mb-1 block text-md text-black font-semibold">Gambar (opsional)</label>
                        <input
                            type="file"
                            name="image"
                            accept="image/*"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-main-bg file:px-3 file:py-2 file:text-white hover:file:bg-teal-700"
                        >
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="rounded-full bg-main-bg px-4 py-2 text-white hover:bg-teal-700">
                            Posting
                        </button>
                    </div>
                    <input type="hidden" name="tryout_id" value="{{ request('tryout_id') }}">
                </form>

                @forelse($postsToDisplay as $post)
                    <x-forum.post-card :post="$post" />
                @empty
                    <div class="text-center text-gray-500 py-12">
                        <p>Tidak ada postingan.</p>
                    </div>
                @endforelse

                @if($paginator)
                    <div>
                        {{ $paginator->withQueryString()->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-app-layout>
