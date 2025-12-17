@extends('layouts.app')

@section('title', 'Фильмы')

@section('content')

    <div class="page-header mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('catalog.genres.index') }}">Жанры</a></li>
                <li class="breadcrumb-item active">Результаты поиска</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-1">Найдено фильмов: {{ $movies->total() }}</h2>
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

    <div class="row">
        <aside class="col-lg-3 col-md-4 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 90px">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="bx bx-filter-alt me-1"></i> Фильтры
                    </h5>

                    <form method="GET" action="{{ route('catalog.movies.filter') }}">

                        <div class="accordion accordion-flush" id="filters">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#filterGenres">
                                        Жанры
                                    </button>
                                </h2>
                                <div id="filterGenres" class="accordion-collapse collapse">
                                    <div class="accordion-body filter-scroll">
                                        @foreach($genres as $genre)
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="genres[]"
                                                       value="{{ $genre->id }}"
                                                    {{ in_array($genre->id, request('genres', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $genre->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#filterDirectors">
                                        Режиссеры
                                    </button>
                                </h2>
                                <div id="filterDirectors" class="accordion-collapse collapse">
                                    <div class="accordion-body filter-scroll">
                                        @foreach($directors as $director)
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="directors[]"
                                                       value="{{ $director->id }}"
                                                    {{ in_array($director->id, request('directors', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $director->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#filterActors">
                                        Актеры
                                    </button>
                                </h2>
                                <div id="filterActors" class="accordion-collapse collapse">
                                    <div class="accordion-body filter-scroll">
                                        @foreach($actors as $actor)
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="actors[]"
                                                       value="{{ $actor->id }}"
                                                    {{ in_array($actor->id, request('actors', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    {{ $actor->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#filterDate">
                                        Дата выхода
                                    </button>
                                </h2>

                                <div id="filterDate" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="mb-2">
                                            <input type="date"
                                                   name="date_from"
                                                   class="form-control form-control-sm"
                                                   value="{{ request('date_from') }}">
                                        </div>

                                        <div>
                                            <input type="date"
                                                   name="date_to"
                                                   class="form-control form-control-sm"
                                                   value="{{ request('date_to') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#filterRating">
                                        Рейтинг
                                    </button>
                                </h2>
                                <div id="filterRating" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="number"
                                                       name="rating_from"
                                                       class="form-control form-control-sm"
                                                       placeholder="От"
                                                       value="{{ request('rating_from') }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="number"
                                                       name="rating_to"
                                                       class="form-control form-control-sm"
                                                       placeholder="До"
                                                       value="{{ request('rating_to') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-primary w-100 mt-4">
                            Найти
                        </button>

                    </form>
                </div>
            </div>
        </aside>


        <div class="col-lg-9 col-md-8">
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
                        По заданым параметрам фильмы отсутсвуют
                    </div>
                @endforelse
            </div>

            @if($movies->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    {{ $movies->appends(request()->query())->links('components.pagination.pagination') }}
                </div>
            @endif
        </div>
    </div>

@endsection
