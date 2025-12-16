@extends('layouts.app')

@section('title', $genre->name)

@section('content')
    <div class="container-xxl py-5">
        <div class="catalog-wrapper">

            <div class="page-header">
                <h2 class="fw-bold mb-1">
                    Фильмы в жанре <span class="text-primary">{{ $genre->name }}</span>
                </h2>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('genres.index') }}">Жанры</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $genre->name }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="movie-list d-flex flex-column gap-3 mt-4">
                @forelse($movies as $movie)
                    <div class="movie-row d-flex">

                        <div class="movie-row-poster">
                            <img src="{{ $movie->poster_url }}"
                                 alt="{{ $movie->title }}"
                                 loading="lazy">
                        </div>

                        <div class="movie-row-content d-flex flex-column">
                            <h5 class="movie-row-title mb-1">
                                {{ $movie->title }}
                            </h5>

                            <div class="movie-row-meta mb-2">
                                @if($movie->release_date)
                                    <span>Год выпуска: {{ \Carbon\Carbon::parse($movie->release_date)->year }}</span>
                                @endif

                                    @if($movie->genres->count())
                                        <span class="dot">•</span>
                                        <span class="genre-label">Жанр:</span>

                                        @foreach($movie->genres as $item)
                                            <span class="genre-name">
                                                {{ $item->name }}@if(!$loop->last),@endif
                                            </span>
                                        @endforeach
                                    @endif
                            </div>

                            <p class="movie-row-description mb-3">
                                {{ $movie->description }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('genres.movies.show', [$genre, $movie]) }}" class="btn btn-outline-primary btn-sm">
                                    Подробнее
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="alert alert-secondary text-center mb-0">
                        Фильмы в этом жанре пока отсутствуют
                    </div>
                @endforelse
            </div>

            @if($movies->hasPages())
                <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
                    {{ $movies->appends(request()->query())->links('components.pagination.pagination') }}
                </div>
            @endif

        </div>
    </div>

    <style>

        .catalog-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }


        .breadcrumb {
            font-size: .85rem;
            padding-top: 10px;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #6c757d;
        }

        .breadcrumb a:hover {
            color: #696cff;
        }

        .breadcrumb-item.active {
            color: #adb5bd;
        }

        .movie-row {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e9ecef;
            padding: 1rem;
            gap: 1.25rem;
            transition: box-shadow .25s ease, transform .25s ease;
        }

        .movie-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 .75rem 1.5rem rgba(0,0,0,.12);
        }

        .movie-row-poster {
            width: 110px;
            min-width: 110px;
            aspect-ratio: 2 / 3;
            border-radius: 10px;
            overflow: hidden;
            background: #f1f3f5;
        }

        .movie-row-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .movie-row-title {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .movie-row-meta {
            font-size: .8rem;
            color: #868e96;
            display: flex;
            flex-wrap: wrap;
            gap: .35rem;
            align-items: center;
        }

        .movie-row-meta .dot {
            margin: 0 .25rem;
        }

        .movie-row-description {
            font-size: .9rem;
            color: #6c757d;
            line-height: 1.45;
        }

        @media (max-width: 576px) {
            .movie-row {
                flex-direction: column;
            }

            .movie-row-poster {
                width: 100%;
                max-width: 160px;
            }
        }

    </style>

@endsection
