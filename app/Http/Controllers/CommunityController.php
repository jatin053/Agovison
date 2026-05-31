<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use App\Services\MarketPriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLogService,
        private readonly MarketPriceService $marketPriceService,
    ) {
    }

    public function index(PostRepository $postRepository): View
    {
        return view('community.index', [
            'posts' => $postRepository->feed(),
            'marketPrices' => $this->marketPriceService->highlights(4),
            'trendingPosts' => Post::query()
                ->with('user')
                ->withCount('likes')
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }

    public function store(PostRequest $request, ImageUploadService $imageUploadService): RedirectResponse
    {
        $validated = $request->validated();

        $post = auth()->user()->posts()->create([
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'],
            'location' => $validated['location'] ?? auth()->user()->city,
            'image_path' => $request->file('image')
                ? $imageUploadService->store($request->file('image'), 'community')
                : null,
        ]);

        $this->activityLogService->log('community.posted', 'Community update published.', $post, auth()->user());

        return back()->with('success', 'Community post shared successfully.');
    }

    public function comment(CommentRequest $request, Post $post): RedirectResponse
    {
        $comment = $post->allComments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->validated()['parent_id'] ?? null,
            'body' => $request->validated()['body'],
        ]);

        $this->activityLogService->log('community.commented', 'Comment added to community post.', $comment, auth()->user());

        return back()->with('success', 'Comment posted successfully.');
    }

    public function togglePostLike(Post $post): RedirectResponse
    {
        $existing = $post->likes()->where('user_id', auth()->id())->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Post like removed.');
        }

        $post->likes()->create(['user_id' => auth()->id()]);
        $this->activityLogService->log('community.liked', 'Post liked in community feed.', $post, auth()->user());

        return back()->with('success', 'Post liked.');
    }

    public function toggleCommentLike(Comment $comment): RedirectResponse
    {
        $existing = $comment->likes()->where('user_id', auth()->id())->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Comment like removed.');
        }

        $comment->likes()->create(['user_id' => auth()->id()]);
        $this->activityLogService->log('community.comment_liked', 'Comment liked in community feed.', $comment, auth()->user());

        return back()->with('success', 'Comment liked.');
    }
}
