<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionBankCategory;

class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil nilai filter dari URL
        $search = $request->input('search');
        $year = $request->input('year');

        // 2. Buat query dinamis untuk memfilter relasi tryouts
        $categories = QuestionBankCategory::with([
            'tryouts' => function ($query) use ($search, $year) {
                // Jika ada input pencarian, filter berdasarkan judul tryout
                if ($search) {
                    $query->where('title', 'like', "%{$search}%");
                }
                // Jika ada input tahun, filter berdasarkan tahun tryout
                if ($year) {
                    $query->where('year', $year);
                }
            },
        ])->get();

        // dd( $categories);

        return view('bank-soal.bank-soal-page', [
            'categories' => $categories,
            'filters' => ['search' => $search, 'year' => $year], // Kirim balik nilai filter ke view
        ]);
    }
}
