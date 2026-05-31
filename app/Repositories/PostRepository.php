<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository
{
    public function feed(int $perPage = 8): LengthAwarePaginator
    {
        return Post::query()
            ->with([
                'user',
                'comments.user',
                'comments.replies.user',
                'comments.likes',
                'likes',
            ])
            ->withCount(['allComments', 'likes'])
            ->latest()
            ->paginate($perPage);
    }
}
