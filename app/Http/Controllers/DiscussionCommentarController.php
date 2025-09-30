<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscussionCommentarRequest;
use App\Http\Requests\UpdateDiscussionCommentarRequest;
use App\Models\Discussion;
use App\Models\DiscussionCommentar;
use Illuminate\Http\Request;

class DiscussionCommentarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'update', 'destroy', 'edit']);
    }

    public function store(StoreDiscussionCommentarRequest $request, Discussion $discussion)
    {
        $comment = new DiscussionCommentar([
            'commentar' => $request->validated()['commentar'],
            'user_id' => auth()->id(),
        ]);
        $comment->discussion()->associate($discussion);
        $comment->save();

        return back()->with('success', 'Komentar ditambahkan.');
    }
    public function edit(DiscussionCommentar $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }
        return view('discussion_comments.edit', compact('comment'));
    }

    public function update(UpdateDiscussionCommentarRequest $request, DiscussionCommentar $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $comment->update($request->validated());

        if (!$request->wantsJson()) {
            return back()->with('success', 'Komentar diperbarui.');
        }

        return response()->json([
            'message' => 'Komentar diperbarui.',
            'data' => $comment->load('user'),
        ]);
    }

    /**
     * Hapus komentar.
     */
    public function destroy(Request $request, DiscussionCommentar $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        if (!$request->wantsJson()) {
            return back()->with('success', 'Komentar dihapus.');
        }

        return response()->json(['message' => 'Komentar dihapus.']);
    }
}
