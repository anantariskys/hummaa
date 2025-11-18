<?php

namespace App\Http\Controllers;

use App\Models\QuestionBankCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1. Ambil nilai filter dari URL
        $search = $request->input('search');
        $year = $request->input('year');
        
        // 2. Ambil ID event yang sudah didaftar oleh user
        $registeredEventIds = $user->registeredEvents()->pluck('events.id')->toArray();

        // 3. Buat query dinamis dengan kombinasi filter pendaftaran + search + year
        $categories = QuestionBankCategory::with([
            'tryouts' => function ($query) use ($registeredEventIds, $search, $year) {
                // FILTER 1: Hanya tryout dari event yang sudah didaftar
                $query->whereIn('event_id', $registeredEventIds);
                
                // FILTER 2: PENTING! Hanya tryout yang ada event_id (bukan draft)
                $query->whereNotNull('event_id');
                
                // FILTER 3: Jika ada input pencarian, filter berdasarkan judul tryout
                if ($search) {
                    $query->where('title', 'like', "%{$search}%");
                }
                
                // FILTER 4: Jika ada input tahun, filter berdasarkan tahun tryout
                if ($year) {
                    $query->where('year', $year);
                }
                
                // Eager load questions untuk menghitung jumlah soal
                $query->with('questions');
            },
        ])
        ->get()
        ->filter(function($category) {
            // Hanya tampilkan kategori yang memiliki minimal 1 tryout (setelah difilter)
            return $category->tryouts->isNotEmpty();
        });

        return view('bank-soal.bank-soal-page', [
            'categories' => $categories,
            'filters' => [
                'search' => $search, 
                'year' => $year
            ],
        ]);
    }
}