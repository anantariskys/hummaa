<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{
    // Optional: protect with auth
    // public function __construct() { $this->middleware('auth'); }

    public function index(Request $request)
    {
        $tryoutId = $request->query('tryout_id');

        $query = Discussion::with([
            'user', 
            'latestComment.user', 
            'comments.user' 
        ])->withCount('comments')->latest('created_at');

        if ($tryoutId) {
            $query->where('tryout_id', $tryoutId);
        }

        $discussions = $query->paginate(10);

        // map langsung ke collection
        $postsToDisplay = collect($discussions->items())
        ->map(fn ($d) => $this->mapDiscussionToPost($d));


        return view('forum.page', [
            'postsToDisplay' => $postsToDisplay,
            'paginator'      => $discussions,
            'tryoutId'       => $tryoutId,
        ]);
    }


    private function mapDiscussionToPost(Discussion $d): array
    {
        $latest = $d->latestComment;
        $latestComment = null;

        if ($latest) {
            $latestComment = [
                'author_name'   => $latest->user->name ?? 'Anonim',
                'author_avatar' => $this->avatarUrl($latest->user->avatar ?? null),
                'content'       => $latest->commentar,
                'time'          => optional($latest->created_at)->diffForHumans(),
            ];
        }

        $others = max(($d->comments_count ?? 0) - ($latest ? 1 : 0), 0);

        return [
            'id'              => $d->id,
            'title'           => $d->title,
            'time'            => optional($d->created_at)->diffForHumans(),
            'image'           => $this->imageUrl($d->image),
            'content'         => \Illuminate\Support\Str::limit((string) $d->desc, 280),
            'comments' => $d->comments->map(fn($c) => [
                'id'      => $c->id,
                'author'  => $c->user->name ?? 'Anonim',
                'avatar'  => $this->avatarUrl($c->user->avatar ?? null),
                'content' => $c->commentar,
                'time'    => optional($c->created_at)->diffForHumans(),
            ]),
            'latest_comment'  => $latestComment,
            'reply_count'     => $others,

            'author_name'     => $d->user->name ?? 'Anonim',
            'author_avatar'   => $this->userAvatar($d),

            'comment_post_url'=> route('discussions.comments.store', $d),
        ];
    }



    private function avatarUrl(?string $path): string
    {
        if (!$path) return asset('images/default-profile.jpeg');
        if (\Illuminate\Support\Str::startsWith($path, ['http://','https://'])) return $path;
        $path = preg_replace('#^(public/|storage/)+#', '', $path);
        return '/storage/' . ltrim($path, '/');
    }

    private function userAvatar(Discussion $d): ?string
    {
        return $this->avatarUrl($d->user?->avatar ?? null);
    }

    private function imageUrl(?string $path): ?string
    {
        if (!$path) return null;
        $path = preg_replace('#^(public/|storage/)+#', '', $path);

        return '/storage/' . ltrim($path, '/');
    }

    public function create()
    {
        return view('discussions.create');
    }

    public function store(StoreDiscussionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id() ?? $request->user_id;
        $tryoutId = $request->input('tryout_id');

        $data['tryout_id'] = $tryoutId;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('discussion-photos', 'public');
        }
        try {
            Discussion::create($data);
        } catch (\Exception $e){
            return back()->withInput()->withErrors(['error' => 'Failed to create discussion: ' . $e->getMessage()]);
        }

         return redirect()->route('forum')->with('success', 'Discussion created!');
    }


    public function show(Discussion $discussion)
    {
        $discussion->load([
            'user',
            'comments' => fn($q) => $q->latest(),
            'comments.user',
        ]);

        return view('discussions.show', compact('discussion'));
    }

    public function edit(Discussion $discussion)
    {
        return view('discussions.edit', compact('discussion'));
    }

    public function update(UpdateDiscussionRequest $request, Discussion $discussion)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($discussion->image && Storage::disk('public')->exists($discussion->image)) {
                Storage::disk('public')->delete($discussion->image);
            }
            $data['image'] = $request->file('image')->store('discussions', 'public');
        }

        $discussion->update($data);

        return redirect()
            ->route('discussions.show', $discussion)
            ->with('success', 'Discussion updated!');
    }

    public function destroy(Discussion $discussion)
    {
        if ($discussion->image && Storage::disk('public')->exists($discussion->image)) {
            Storage::disk('public')->delete($discussion->image);
        }

        $discussion->delete();

        return redirect()
            ->route('discussions.index')
            ->with('success', 'Discussion deleted!');
    }
}
