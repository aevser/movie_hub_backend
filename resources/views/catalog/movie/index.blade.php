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
                        <a href="{{ route('catalog.genres.index') }}">Жанры</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $genre->name }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-3 mb-3">
            <div class="flex-grow-1">
                <form method="GET">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div class="d-flex gap-2">
                        <div class="input-group flex-grow-1">
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Поиск по названию..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit" style="min-width: 90px;">
                                <i class="bi bi-search"></i> Найти
                            </button>
                        </div>
                        @if(request('search'))
                            <a
                                href="?{{ http_build_query(request()->except('search')) }}"
                                class="btn btn-outline-secondary d-inline-flex align-items-center gap-1"
                                title="Очистить поиск"
                            >
                                <i class="bi bi-x"></i>
                                <span>Очистить</span>
                            </a>
                        @endif

                    </div>
                </form>
            </div>

            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                        id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                        style="min-width: 140px;">
                    <i class="bi bi-sort-down"></i> Сортировка
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                    <li>
                        <a class="dropdown-item {{ request('sort') === 'release_date_desc' || !request('sort') ? 'active' : '' }}"
                           href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'release_date_desc'])) }}">
                            Дата выпуска (новые)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('sort') === 'release_date_asc' ? 'active' : '' }}"
                           href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'release_date_asc'])) }}">
                            Дата выпуска (старые)
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item {{ request('sort') === 'rating_desc' ? 'active' : '' }}"
                           href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'rating_desc'])) }}">
                            Рейтинг (высокий)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ request('sort') === 'rating_asc' ? 'active' : '' }}"
                           href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'rating_asc'])) }}">
                            Рейтинг (низкий)
                        </a>
                    </li>
                </ul>
            </div>
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
                            <a href="{{ route('catalog.genres.movies.show', [$genre, $movie]) }}"
                               class="btn btn-outline-primary btn-sm">
                                Подробнее
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="alert alert-secondary text-center mb-0">
                    @if(request('search'))
                        По запросу "<strong>{{ request('search') }}</strong>" ничего не найдено
                    @else
                        Фильмы в этом жанре пока отсутствуют
                    @endif
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
