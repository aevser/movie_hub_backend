@extends('layouts.app')

@section('title', $movie->title . ' : ' . \Carbon\Carbon::parse($movie->release_date)->year )

@section('content')

    <div class="catalog-wrapper">

        <div class="page-header mb-4">
            <div class="movie-title-row mb-2">
                <a href="{{ route('genres.movies.index', $genre) }}" class="back-link">←</a>
                <h1 class="movie-title">{{ $movie->title }}</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('genres.index') }}">Жанры</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('genres.movies.index', $genre) }}">{{ $genre->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $movie->title }}</li>
                </ol>
            </nav>
        </div>

        <div class="movie-show">

            <!-- LEFT COLUMN -->
            <div class="movie-show-left">
                <div class="movie-show-poster">
                    <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}">
                </div>

                <div class="movie-director">
                    <div class="section-title">Режиссёр</div>

                    <div class="director-card director-card--row">
                        <div class="director-photo">
                            <img
                                src="{{ $director?->image_url ?? '/images/actor-placeholder.png' }}"
                                alt="{{ $director?->name ?? 'Информация отсутствует' }}"
                            >
                        </div>

                        <div class="director-name">
                            {{ $director?->name ?? 'Информация отсутствует' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="movie-show-content">

                <div class="movie-info-scroll">

                    <div class="movie-show-meta">
                        @if($movie->release_date)
                            <span>Год выпуска: {{ \Carbon\Carbon::parse($movie->release_date)->year }}</span>
                        @endif

                        @if($movie->genres->count())
                            <span class="dot">•</span>
                            <span class="genre-label">Жанр:</span>

                            @foreach($movie->genres as $item)
                                <a href="{{ route('genres.movies.index', $item) }}"
                                   class="genre-link">
                                    {{ $item->name }}@if(!$loop->last),@endif
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <p class="movie-show-description">
                        {{ $movie->description }}
                    </p>

                </div>

                @if($movie->actors->count())
                    <div class="movie-actors">
                        <div class="section-title">В ролях</div>

                        <div class="actors-scroll">
                            @foreach($movie->actors as $actor)
                                <div class="actor-card">
                                    <div class="actor-photo">
                                        <img
                                            src="{{ $actor->image_url ?? '/images/actor-placeholder.png' }}"
                                            alt="{{ $actor->name }}">
                                    </div>

                                    <div class="actor-info">
                                        <div class="actor-name" title="{{ $actor->name }}">
                                            {{ $actor->name }}
                                        </div>
                                        <div class="actor-role">
                                            {{ $actor->pivot->character }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- REVIEWS --}}
        @if(isset($reviews) && $reviews->count())
            <div class="reviews-section">
                <h2 class="section-heading">Отзывы</h2>

                <div class="reviews-list">
                    @foreach($reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <div class="review-author">
                                    <div class="author-avatar">
                                        <img
                                            src="{{ $review->user->avatar_url ?? '/images/user-placeholder.png' }}"
                                            alt="{{ $review->user->name }}">
                                    </div>

                                    <div class="author-info">
                                        <div class="author-name">{{ $review->user->name }}</div>
                                        <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>

                                @if(isset($review->rating))
                                    <div class="review-rating">
                                        <span class="rating-star">★</span>
                                        <span class="rating-value">{{ $review->rating }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="review-text">
                                {{ $review->text }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection
