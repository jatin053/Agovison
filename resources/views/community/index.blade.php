@extends('layouts.app')

@php($pageTitle = 'Farmer Community')
@php($pageSubtitle = 'Share field updates, ask questions, and learn from the live farming network.')

@section('content')
    <div class="row g-4">
        <div class="col-xl-8">
            @auth
                <div class="surface-card mb-4" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="mb-1">Create a field update</h3>
                            <p class="muted-label mb-0">Share crop tips, weather reactions, disease observations, or harvest wins.</p>
                        </div>
                        <span class="badge-soft">Social farming layer</span>
                    </div>
                    <form action="{{ route('community.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Morning irrigation update">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', auth()->user()->city) }}" placeholder="Pune">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Update</label>
                            <textarea name="body" rows="4" class="form-control" required>{{ old('body') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button class="btn btn-success btn-lg">Share update</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="surface-card mb-4" data-aos="fade-up">
                    <h3 class="mb-2">Join the AgroVision AI community</h3>
                    <p class="muted-label">Create an account to publish updates, like posts, and collaborate with farmers, buyers, and experts.</p>
                    <a href="{{ route('register') }}" class="btn btn-success">Create account</a>
                </div>
            @endauth

            <div class="metric-stack">
                @foreach($posts as $post)
                    <div class="feed-card" data-aos="fade-up">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <div class="feed-meta mb-2">
                                    <span><i class="fa-regular fa-user"></i> {{ $post->user->name }}</span>
                                    <span><i class="fa-solid fa-location-dot"></i> {{ $post->location ?: 'AgroVision network' }}</span>
                                    <span><i class="fa-regular fa-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <h4 class="mb-2">{{ $post->title ?: 'Field update' }}</h4>
                            </div>
                            <span class="badge-soft">{{ $post->user->primaryRole() }}</span>
                        </div>

                        <p class="mb-0">{{ $post->body }}</p>

                        @if($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->title ?: 'Community update' }}" class="feed-image">
                        @endif

                        <div class="feed-actions mt-3">
                            <span class="badge-soft"><i class="fa-regular fa-heart"></i> {{ $post->likes_count }}</span>
                            <span class="badge-soft"><i class="fa-regular fa-comment"></i> {{ $post->all_comments_count }}</span>
                            @auth
                                <form action="{{ route('community.posts.like', $post) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-light btn-sm">{{ $post->likes->contains('user_id', auth()->id()) ? 'Unlike' : 'Like' }}</button>
                                </form>
                            @endauth
                        </div>

                        <div class="comment-thread">
                            @foreach($post->comments as $comment)
                                <div class="comment-card">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <strong>{{ $comment->user->name }}</strong>
                                            <div class="small muted-label">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="small muted-label">{{ $comment->likes->count() }} likes</span>
                                            @auth
                                                <form action="{{ route('community.comments.like', $comment) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-outline-light btn-sm">Like</button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-2">{{ $comment->body }}</p>

                                    @foreach($comment->replies as $reply)
                                        <div class="comment-card mt-3 mb-0">
                                            <strong>{{ $reply->user->name }}</strong>
                                            <div class="small muted-label">{{ $reply->created_at->diffForHumans() }}</div>
                                            <p class="mb-0 mt-2">{{ $reply->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                            @auth
                                <form action="{{ route('community.comments.store', $post) }}" method="POST" class="mt-3">
                                    @csrf
                                    <textarea name="body" rows="2" class="form-control" placeholder="Reply with a suggestion or question..." required></textarea>
                                    <button class="btn btn-success btn-sm mt-2">Add comment</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
        <div class="col-xl-4">
            <div class="surface-card mb-4" data-aos="fade-up">
                <h3 class="mb-3">Trending community posts</h3>
                <div class="metric-stack">
                    @foreach($trendingPosts as $post)
                        <div class="mini-card">
                            <span class="muted-label">{{ $post->user->name }}</span>
                            <strong>{{ $post->title ?: 'Field update' }}</strong>
                            <div class="small mt-2">{{ $post->likes_count }} likes</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="surface-card" data-aos="fade-up">
                <h3 class="mb-3">Mandi pulse</h3>
                <div class="metric-stack">
                    @foreach($marketPrices as $price)
                        <div class="mini-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $price['crop'] }}</strong>
                                <span class="signal-chip {{ $price['trend'] }}">{{ $price['change'] }}%</span>
                            </div>
                            <div class="muted-label mt-2">{{ $price['market'] }}</div>
                            <div class="small mt-2">INR {{ number_format($price['price'], 0) }}/{{ $price['unit'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
