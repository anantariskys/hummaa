<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of materials for users
     */
    public function index()
    {
        $allMateri = Materi::active()
            ->orderBy('created_at', 'asc')
            ->get();

        return view('material.materials-page', compact('allMateri'));
    }

    /**
     * Display the specified material
     */
    public function show(Materi $materi)
    {
        // Check if material is active
        if (!$materi->is_active) {
            abort(404);
        }

        return view('material.show', compact('materi'));
    }

    /**
     * View material file in browser
     */
    public function view(Materi $materi)
    {
        // Check if material is active
        if (!$materi->is_active) {
            abort(404, 'Materi tidak aktif');
        }

        // Check if file exists
        if (!$materi->file_path || !Storage::disk('public')->exists($materi->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $materi->file_path);
        
        // Return file to be viewed in browser
        return response()->file($filePath);
    }

    /**
     * Download material file
     */
    public function download(Materi $materi)
    {
        // Check if material is active
        if (!$materi->is_active) {
            abort(404, 'Materi tidak aktif');
        }

        // Check if file exists
        if (!$materi->file_path || !Storage::disk('public')->exists($materi->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Get file extension
        $extension = pathinfo($materi->file_path, PATHINFO_EXTENSION);
        
        // Create download filename
        $downloadName = $materi->title . '.' . $extension;

        return response()->download(
            storage_path('app/public/' . $materi->file_path),
            $downloadName
        );
    }

    /**
     * Update progress - AJAX endpoint for users
     */
    public function updateProgress(Request $request, Materi $materi)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $progress = $request->progress;
        $status = $this->determineStatusFromProgress($progress);

        $materi->update([
            'progress' => $progress,
            'status' => $status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress berhasil diperbarui',
            'data' => [
                'progress' => $progress,
                'status' => $status
            ]
        ]);
    }

    /**
     * Determine status based on progress
     */
    private function determineStatusFromProgress(int $progress): string
    {
        return match (true) {
            $progress === 0 => 'Belum Dimulai',
            $progress >= 100 => 'Selesai',
            default => 'Progres'
        };
    }
}