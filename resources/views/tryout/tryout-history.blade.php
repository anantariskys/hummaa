@extends('layouts.tryout-layout')

@section('content')
<div class="px-4 py-10">
    <div class="text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Riwayat Pengerjaan</h2>
        <p class="text-gray-500 text-lg">{{ $tryout->title }}</p>
    </div>

    <div class="bg-white shadow rounded-xl p-6 md:p-8">
        @if($attempts->isEmpty())
            <div class="text-center py-10">
                <i class="bi bi-journal-x text-5xl text-gray-400"></i>
                <h4 class="mt-4 text-xl font-semibold text-gray-700">Riwayat Tidak Ditemukan</h4>
                <p class="text-gray-500">Anda belum pernah menyelesaikan tryout ini.</p>
                <a href="{{ route('tryout.start',['tryout_id'=>$tryout->tryout_id]) }}" 
                   class="mt-6 inline-block bg-main-bg hover:bg-teal-800 text-white font-medium px-5 py-2 rounded-lg
                   transition-colors duration-300">
                    Mulai Kerjakan Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-3 text-center w-12">No.</th>
                            <th class="px-4 py-3 text-left">Waktu Selesai</th>
                            <th class="px-4 py-3 text-center w-24">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($attempts as $index => $attempt)
                            @php
                                $score = round($attempt->score);
                                $badgeClass = 'bg-red-500';
                                if ($score >= 80) {
                                    $badgeClass = 'bg-green-500';
                                } elseif ($score >= 60) {
                                    $badgeClass = 'bg-yellow-400 text-black';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center font-semibold">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($attempt->end_time)->translatedFormat('d F Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block min-w-[2.5rem] text-center px-3 py-1 rounded-full text-white text-sm {{ $badgeClass }}">
                                        {{ $score }}
                                    </span>
                                </td>
                          
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-6 flex justify-between">
        <a href="{{ route('tryout.index') }}" 
           class="inline-flex items-center px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </a>
        @if(!$attempts->isEmpty())
        <a href="{{ route('tryout.start',['tryout_id'=>$tryout->tryout_id]) }}" 
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            Kerjakan Lagi
        </a>
        @endif
    </div>
</div>
@endsection
