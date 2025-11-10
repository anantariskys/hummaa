<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMateriController extends Controller
{
    /**
     * Display a listing of materials in admin panel
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Materi::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        // Paginate 10 per page
        $allMateri = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.materials.index', compact('allMateri', 'search'));
    }

    /**
     * Show the form for creating a new material
     */
    public function create()
    {
        return view('admin.materials.create');
    }

    /**
     * Store a newly created material in storage
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
        
        // Set default values
        $data['status'] = 'Belum Dimulai';
        $data['progress'] = 0;
        $data['is_active'] = true;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $data['file_path'] = $filePath;
            $data['file_size'] = $this->formatBytes($file->getSize());
        }

        Materi::create($data);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Display the specified material in admin
     */
    public function show(Materi $material)
    {
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified material
     */
    public function edit(Materi $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    /**
     * Update the specified material in storage
     */
    public function update(Request $request, Materi $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'is_active' => 'nullable|boolean',
        ]);
        
        $data = $request->only(['title', 'description', 'duration']);
        
        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active');

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
            $data['file_size'] = $this->formatBytes($file->getSize());
        }
        
        $material->update($data);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified material from storage
     */
    public function destroy(Materi $material)
    {
        // Delete file if exists
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Toggle material active status
     */
    public function toggleActive(Materi $material)
    {
        $material->update([
            'is_active' => !$material->is_active
        ]);

        $status = $material->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Materi berhasil {$status}!");
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