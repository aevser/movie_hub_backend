@extends('layouts.app')

@section('title', 'Избранное')

@section('content')
    <div class="catalog-wrapper">

        <div class="page-header mb-4">
            <h1 class="page-title">Избранное</h1>
            <p class="page-subtitle">Фильмы, которые вы добавили в избранное</p>
        </div>

        @if($favorites->count())
            <div class="movies-grid">
                @foreach($favorites as $movie)
                    <div class="movie-card">
                        <a href="{{ route('catalog.genres.movies.show', [$movie->genres->first(), $movie]) }}" class="movie-card-link">
                            <div class="movie-card-poster">
                                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}">
                            </div>

                            <div class="movie-card-content">
                                <h3 class="movie-card-title">{{ $movie->title }}</h3>

                                @if($movie->release_date)
                                    <div class="movie-card-year">
                                        {{ \Carbon\Carbon::parse($movie->release_date)->year }}
                                    </div>
                                @endif

                                @if($movie->genres->count())
                                    <div class="movie-card-genres">
                                        @foreach($movie->genres as $genre)
                                            <span class="genre-badge">{{ $genre->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </a>

                        <form method="POST" action="{{ route('favorites.destroy', $movie) }}" class="favorite-remove-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite-remove-btn" title="Удалить из избранного">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper mt-4">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="80" height="80">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <h3 class="empty-title">Нет избранных фильмов</h3>
                <p class="empty-text">Добавьте фильмы в избранное, чтобы они появились здесь</p>
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

    .movies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 24px;
    }

    .movie-card {
        position: relative;
    }

    .movie-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .movie-card-poster {
        width: 100%;
        aspect-ratio: 2/3;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 12px;
        background: #f1f5f9;
    }

    .movie-card-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .movie-card:hover .movie-card-poster img {
        transform: scale(1.05);
    }

    .movie-card-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1e293b;
        line-height: 1.4;
    }

    .movie-card-year {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .movie-card-genres {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .genre-badge {
        font-size: 12px;
        padding: 4px 8px;
        background: #f1f5f9;
        border-radius: 6px;
        color: #475569;
    }

    .favorite-remove-form {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .favorite-remove-btn {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #ef4444;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .favorite-remove-btn:hover {
        transform: scale(1.1);
        background: white;
    }

    .favorite-remove-btn svg {
        width: 20px;
        height: 20px;
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
