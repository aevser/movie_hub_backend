@extends('layouts.app')

@section('title', $movie->title . ' : ' . \Carbon\Carbon::parse($movie->release_date)->year )

@section('content')
    <div class="container-xxl py-5">
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

                {{-- RIGHT COLUMN --}}
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
                                            <img src="{{ $actor->image_url ?? '/images/actor-placeholder.png' }}" alt="{{ $actor->name }}">
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
                                            <img src="{{ $review->user->avatar_url ?? '/images/user-placeholder.png' }}" alt="{{ $review->user->name }}">
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
    </div>

    <style>
        .catalog-wrapper {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* MOVIE LAYOUT */
        .movie-show {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        /* LEFT COLUMN */
        .movie-show-left {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* POSTER */
        .movie-show-poster {
            width: 300px;
            height: 450px;
            border-radius: 16px;
            overflow: hidden;
            background: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .movie-show-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* DIRECTOR */
        .movie-director {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem;
        }

        .director-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .director-photo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            background: #e9ecef;
            flex-shrink: 0;
        }

        .director-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .director-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: #343a40;
        }

        /* CONTENT */
        .movie-show-content {
            height: 565px;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            min-width: 0;
        }

        .movie-info-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 0.75rem;
            margin-right: -0.75rem;
        }

        .movie-info-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .movie-info-scroll::-webkit-scrollbar-track {
            background: #f1f3f5;
            border-radius: 3px;
        }

        .movie-info-scroll::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 3px;
        }

        .movie-info-scroll::-webkit-scrollbar-thumb:hover {
            background: #adb5bd;
        }

        /* META */
        .movie-show-meta {
            font-size: 0.9rem;
            color: #6c757d;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .movie-show-meta .dot {
            color: #dee2e6;
        }

        .movie-show-meta .genre-link {
            color: #495e9d;
            text-decoration: none;
            transition: color 0.2s;
        }

        .movie-show-meta .genre-link:hover {
            color: #364a7e;
            text-decoration: underline;
        }

        /* DESCRIPTION */
        .movie-show-description {
            font-size: 0.95rem;
            line-height: 1.7;
            color: #495057;
            margin: 0;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #868e96;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        /* ACTORS */
        .movie-actors {
            flex-shrink: 0;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }

        .actors-scroll {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .actors-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .actors-scroll::-webkit-scrollbar-track {
            background: #f1f3f5;
            border-radius: 3px;
        }

        .actors-scroll::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 3px;
        }

        .actors-scroll::-webkit-scrollbar-thumb:hover {
            background: #adb5bd;
        }

        /* ACTOR CARD */
        .actor-card {
            flex: 0 0 130px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 0.65rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .actor-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            border-color: #dee2e6;
        }

        .actor-photo {
            width: 100%;
            aspect-ratio: 2 / 3;
            border-radius: 8px;
            overflow: hidden;
            background: #f1f3f5;
            margin-bottom: 0.5rem;
        }

        .actor-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .actor-info {
            text-align: center;
        }

        .actor-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #343a40;
            line-height: 1.3;
            margin-bottom: 0.2rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .actor-role {
            font-size: 0.7rem;
            color: #868e96;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* HEADER */
        .movie-title-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .back-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #6c757d;
            font-size: 1.25rem;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .back-link:hover {
            background: #f8f9fa;
            color: #495057;
            border-color: #dee2e6;
        }

        .movie-title {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .movie-show {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .movie-show-left {
                gap: 1rem;
            }

            .movie-show-poster {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }

            .movie-show-content {
                height: auto;
                gap: 1rem;
            }

            .movie-info-scroll {
                max-height: none;
                overflow-y: visible;
            }

            .actor-card {
                flex: 0 0 110px;
            }
        }
    </style>
@endsection
