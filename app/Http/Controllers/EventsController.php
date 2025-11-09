<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $search = $request->input('search');

    $events = Events::when($search, function ($query, $search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('subtitle', 'like', "%{$search}%");
    })->orderBy('created_at', 'desc')
      ->paginate(10); // <<-- penting, gunakan paginate()

    return view('admin.events.index', compact('events', 'search'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'badge' => 'nullable|string|max:100',
        'duration' => 'nullable|string|max:100',
        'question_count' => 'nullable|string|max:100',
        'test_parts' => 'nullable|array',
        'test_parts.*' => 'nullable|string|max:255',
    ]);

    Events::create($validated);

    return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
}


   public function edit(Events $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Events $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:100',
            'question_count' => 'nullable|string|max:50',
            'test_parts' => 'array',
            'test_parts.*' => 'nullable|string|max:255',
        ]);

        $event->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'badge' => $request->badge,
            'duration' => $request->duration,
            'question_count' => $request->question_count,
            'test_parts' => $request->test_parts ?? [],
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Events $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
