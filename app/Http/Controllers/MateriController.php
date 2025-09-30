<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allMateri = Materi::active()->orderBy('created_at', 'asc')->get();


        // Use the existing view name to avoid breaking current implementation
        return view('material.materials-page', compact('allMateri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        $data = $request->only(['title', 'description', 'duration']);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_size'] = $file->getClientOriginalExtension() . ' ' . $this->formatBytes($file->getSize());
        }

        Materi::create($data);

        return redirect()->route('admin.materials')->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        return view('material.show', compact('materi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);
        
        $data = $request->only(['title', 'description', 'duration']);

        
        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_size'] = $file->getClientOriginalExtension() . ' ' . $this->formatBytes($file->getSize());
        }
        
        $material->update($data);


        return redirect()->route('admin.materials')->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $material)
    {
        // Delete file if exists
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('admin.materials')->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Download materi file
     */
    public function download(Materi $materi)
    {
        if (!$materi->file_path || !Storage::disk('public')->exists($materi->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download(
            storage_path('app/public/' . $materi->file_path),
            $materi->title . '.' . pathinfo($materi->file_path, PATHINFO_EXTENSION)
        );
    }

    /**
     * Update progress - AJAX endpoint
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
     * Format bytes to human readable format
     */
    public function indexAdmin(Request $request)
    {

        $search = $request->input('search');

        $query = Materi::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // paginate 10 per halaman
        $allMateri = $query->paginate(10);

        return view('admin.materials.index', compact('allMateri', 'search'));
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

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}
