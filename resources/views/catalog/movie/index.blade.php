@extends('layouts.app')

@section('title', $genre->name)

@section('content')

    <div class="catalog-wrapper">

        <div class="page-header mb-4">
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

        <div class="movie-list d-flex flex-column gap-3">
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
                            <a href="{{ route('genres.movies.show', [$genre, $movie]) }}"
                               class="btn btn-outline-primary btn-sm">
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
            <div class="d-flex justify-content-end mt-4">
                {{ $movies->appends(request()->query())->links('components.pagination.pagination') }}
            </div>
        @endif

    </div>

@endsection
