@extends('layouts.app')

@section('title', 'Мои отзывы')

@section('content')
    <div class="catalog-wrapper">

        <div class="page-header mb-4">
            <h1 class="page-title">Мои отзывы</h1>
            <p class="page-subtitle">Все отзывы, которые вы оставили</p>
        </div>

        @if($reviews->count())
            <div class="reviews-list">
                @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-movie">
                            <a href="{{ route('catalog.genres.movies.show', [$review->movie->genres->first()->slug, $review->movie->slug]) }}" class="review-movie-link">                                <div class="review-movie-poster">
                                    <img src="{{ $review->movie->poster_url }}" alt="{{ $review->movie->title }}">
                                </div>
                                <div class="review-movie-info">
                                    <h3 class="review-movie-title">{{ $review->movie->title }}</h3>
                                    @if($review->movie->release_date)
                                        <div class="review-movie-year">
                                            {{ \Carbon\Carbon::parse($review->movie->release_date)->year }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>

                        <div class="review-content">
                            <div class="review-header">
                                <div class="review-meta">
                                    @if($review->rating)
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= $review->rating ? 'active' : '' }}">★</span>
                                            @endfor
                                            <span class="rating-number">{{ $review->rating }}/5</span>
                                        </div>
                                    @endif
                                    <div class="review-date">
                                        {{ $review->created_at->format('d.m.Y') }}
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" onsubmit="return confirm('Удалить отзыв?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="review-delete-btn" title="Удалить отзыв">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="18" height="18">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <p class="review-text">{{ $review->review_text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper mt-4">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="80" height="80">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <h3 class="empty-title">Нет отзывов</h3>
                <p class="empty-text">Вы ещё не оставляли отзывов на фильмы</p>
                <a href="{{ route('catalog.genres.index') }}" class="btn-back">
                    Смотреть фильмы
                </a>
            </div>
        @endif

    </div>
@endsection

<style>
    .page-header {
        text-align: center;
    }

    .page-title {
        font-size: 32px;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .review-movie {
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .review-movie-link {
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none;
        color: inherit;
        transition: opacity 0.3s ease;
    }

    .review-movie-link:hover {
        opacity: 0.7;
    }

    .review-movie-poster {
        width: 60px;
        height: 90px;
        border-radius: 8px;
        overflow: hidden;
        background: #f1f5f9;
        flex-shrink: 0;
    }

    .review-movie-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .review-movie-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .review-movie-year {
        font-size: 14px;
        color: #64748b;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .review-meta {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .star {
        color: #e2e8f0;
        font-size: 18px;
    }

    .star.active {
        color: #fbbf24;
    }

    .rating-number {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .review-date {
        font-size: 14px;
        color: #94a3b8;
    }

    .review-delete-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        color: #64748b;
        transition: all 0.3s ease;
        border-radius: 6px;
    }

    .review-delete-btn:hover {
        background: #fee2e2;
        color: #ef4444;
    }

    .review-text {
        color: #475569;
        line-height: 1.6;
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state svg {
        margin: 0 auto 24px;
        opacity: 0.2;
        stroke: #64748b;
    }

    .empty-title {
        font-size: 24px;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .empty-text {
        color: #64748b;
        margin-bottom: 24px;
        font-size: 16px;
    }

    .btn-back {
        display: inline-block;
        padding: 12px 24px;
        background: #1e293b;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: background 0.3s ease;
        font-weight: 500;
    }

    .btn-back:hover {
        background: #334155;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }
</style>
