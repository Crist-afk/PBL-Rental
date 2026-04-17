<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $categories = ForumCategory::withCount('posts')
            ->orderBy('id')
            ->get();

        $postsQuery = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->latest();
        $activeCategory = null;
        $search = trim($request->string('q')->toString());
        $categorySlug = $request->string('category')->toString();

        if ($categorySlug !== '') {
            $activeCategory = $categories->firstWhere('slug', $categorySlug);

            if ($activeCategory) {
                $postsQuery->where('forum_category_id', $activeCategory->id);
            }
        }

        if ($search !== '') {
            $postsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $posts = $postsQuery->paginate(6)->withQueryString();

        $trendingPosts = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->take(3)
            ->get();

        return view('forum', [
            'categories' => $categories,
            'posts' => $posts,
            'trendingPosts' => $trendingPosts,
            'activeCategory' => $activeCategory,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'forum_category_id' => 'required|exists:forum_categories,id',
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum', 'public');
        }

        ForumPost::create([
            'user_id' => $request->user()->id,
            'forum_category_id' => $validated['forum_category_id'],
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'content' => $validated['content'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('forum')->with('forum_success', 'Diskusi baru berhasil dipublikasikan.');
    }

    public function update(Request $request, ForumPost $forumPost)
    {
        $this->authorizePostOwner($request, $forumPost);

        $validated = $request->validateWithBag('postUpdate', [
            'edit_forum_category_id' => 'required|exists:forum_categories,id',
            'edit_title' => 'required|string|max:150',
            'edit_content' => 'required|string|max:5000',
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'remove_image' => 'nullable|boolean',
            'editing_post' => 'nullable',
        ]);

        if ($request->boolean('remove_image') && $forumPost->image_path) {
            Storage::disk('public')->delete($forumPost->image_path);
            $forumPost->image_path = null;
        }

        if ($request->hasFile('edit_image')) {
            if ($forumPost->image_path) {
                Storage::disk('public')->delete($forumPost->image_path);
            }

            $forumPost->image_path = $request->file('edit_image')->store('forum', 'public');
        }

        $forumPost->update([
            'forum_category_id' => $validated['edit_forum_category_id'],
            'title' => $validated['edit_title'],
            'content' => $validated['edit_content'],
        ]);

        return redirect()->route('forum.show', $forumPost)->with('forum_success', 'Diskusi berhasil diperbarui.');
    }

    public function destroy(Request $request, ForumPost $forumPost)
    {
        $this->authorizePostOwner($request, $forumPost);

        if ($forumPost->image_path) {
            Storage::disk('public')->delete($forumPost->image_path);
        }

        $forumPost->delete();

        return redirect()->route('forum')->with('forum_success', 'Diskusi berhasil dihapus.');
    }

    public function show(ForumPost $forumPost)
    {
        $forumPost->load(['user', 'category'])
            ->loadCount('comments');

        $comments = $forumPost->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->oldest()
            ->get();

        $relatedPosts = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->where('forum_category_id', $forumPost->forum_category_id)
            ->whereKeyNot($forumPost->id)
            ->latest()
            ->take(3)
            ->get();

        return view('forum-detail', [
            'post' => $forumPost,
            'comments' => $comments,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    public function storeComment(Request $request, ForumPost $forumPost)
    {
        $validated = $request->validateWithBag('commentCreate', [
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {
            $parentComment = ForumComment::where('forum_post_id', $forumPost->id)
                ->whereKey($parentId)
                ->first();

            if (! $parentComment) {
                return redirect()
                    ->route('forum.show', $forumPost)
                    ->withErrors(['content' => 'Balasan tidak valid untuk diskusi ini.']);
            }
        }

        ForumComment::create([
            'forum_post_id' => $forumPost->id,
            'user_id' => $request->user()->id,
            'parent_id' => $parentId,
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('forum.show', $forumPost)
            ->with('forum_success', $parentId ? 'Balasan berhasil dikirim.' : 'Komentar berhasil dikirim.');
    }

    public function updateComment(Request $request, ForumPost $forumPost, ForumComment $forumComment)
    {
        $this->ensureCommentBelongsToPost($forumPost, $forumComment);
        $this->authorizeCommentOwner($request, $forumComment);

        $validated = $request->validateWithBag('commentUpdate', [
            'edit_comment_content' => 'required|string|max:2000',
            'editing_comment' => 'nullable',
        ]);

        $forumComment->update([
            'content' => $validated['edit_comment_content'],
        ]);

        return redirect()->route('forum.show', $forumPost)->with('forum_success', 'Komentar berhasil diperbarui.');
    }

    public function destroyComment(Request $request, ForumPost $forumPost, ForumComment $forumComment)
    {
        $this->ensureCommentBelongsToPost($forumPost, $forumComment);
        $this->authorizeCommentOwner($request, $forumComment);

        $forumComment->replies()->delete();
        $forumComment->delete();

        return redirect()->route('forum.show', $forumPost)->with('forum_success', 'Komentar berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug !== '' ? $baseSlug : 'diskusi-baru';
        $counter = 2;

        while (ForumPost::where('slug', $slug)->exists()) {
            $slug = ($baseSlug !== '' ? $baseSlug : 'diskusi-baru') . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function authorizePostOwner(Request $request, ForumPost $forumPost): void
    {
        abort_unless($request->user()->is($forumPost->user), 403);
    }

    private function authorizeCommentOwner(Request $request, ForumComment $forumComment): void
    {
        abort_unless($request->user()->is($forumComment->user), 403);
    }

    private function ensureCommentBelongsToPost(ForumPost $forumPost, ForumComment $forumComment): void
    {
        abort_unless($forumComment->forum_post_id === $forumPost->id, 404);
    }
}
